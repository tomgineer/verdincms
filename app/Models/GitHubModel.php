<?php namespace App\Models;

use CodeIgniter\Model;
use DateTimeImmutable;
use Throwable;

class GitHubModel extends Model {

    protected $db;

    public function __construct() {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

/**
 * Fetch all public GitHub repositories for a user and upsert them into `github_repos`.
 *
 * @param string $username GitHub username (e.g. "tomgineer").
 * @param string $sort ASC or DESC ordering by alias/name update (applied in API sorting).
 * @param string|null $token Optional token if you hit rate limits.
 * @return array{fetched:int, upserted:int, pages:int, errors:array<int,string>}
 */
public function syncGithubRepos(string $username, string $sort = 'DESC', ?string $token = null): array {
    $sort = strtoupper($sort);
    if (!in_array($sort, ['ASC', 'DESC'], true)) {
        $sort = 'DESC';
    }

    // Empty table before sync (TRUNCATE)
    $this->db->table('github_repos')->truncate();

    $now = (new DateTimeImmutable('now'))->format('Y-m-d H:i:s');

    $perPage = 100;
    $page = 1;

    $fetched = 0;
    $upserted = 0;
    $errors = [];

    while (true) {
        // GitHub supports: sort=created|updated|pushed|full_name. We'll use updated.
        $direction = ($sort === 'ASC') ? 'asc' : 'desc';

        $url = "https://api.github.com/users/" . rawurlencode($username) . "/repos"
            . "?per_page={$perPage}&page={$page}&sort=updated&direction={$direction}";

        $resp = $this->githubHttpGetJson($url, $token);

        if ($resp['ok'] !== true) {
            $errors[] = "GitHub API error (page {$page}): " . ($resp['error'] ?? 'Unknown error');
            break;
        }

        $repos = $resp['data'] ?? [];
        if (!is_array($repos) || $repos === []) {
            break;
        }

        foreach ($repos as $repo) {
            if (!is_array($repo) || !isset($repo['id'], $repo['name'], $repo['full_name'], $repo['html_url'])) {
                continue;
            }

            $row = [
                'github_id'         => (int) $repo['id'],
                'owner_login'       => (string) ($repo['owner']['login'] ?? $username),
                'name'              => (string) $repo['name'],
                'full_name'         => (string) $repo['full_name'],
                'description'       => isset($repo['description']) ? (string) $repo['description'] : null,
                'html_url'          => (string) $repo['html_url'],
                'homepage'          => !empty($repo['homepage']) ? (string) $repo['homepage'] : null,
                'language'          => !empty($repo['language']) ? (string) $repo['language'] : null,
                'is_fork'           => !empty($repo['fork']) ? 1 : 0,
                'is_archived'       => !empty($repo['archived']) ? 1 : 0,
                'visibility'        => !empty($repo['visibility']) ? (string) $repo['visibility'] : null,
                'stargazers_count'  => (int) ($repo['stargazers_count'] ?? 0),
                'forks_count'       => (int) ($repo['forks_count'] ?? 0),
                'open_issues_count' => (int) ($repo['open_issues_count'] ?? 0),
                'created_at'        => $this->isoToSqlDateTime($repo['created_at'] ?? null),
                'updated_at'        => $this->isoToSqlDateTime($repo['updated_at'] ?? null),
                'pushed_at'         => $this->isoToSqlDateTime($repo['pushed_at'] ?? null),
                'synced_at'         => $now,
            ];

            $sql = "
                INSERT INTO github_repos (
                    github_id, owner_login, name, full_name, description, html_url, homepage,
                    language, is_fork, is_archived, visibility, stargazers_count, forks_count,
                    open_issues_count, created_at, updated_at, pushed_at, synced_at
                ) VALUES (
                    :github_id:, :owner_login:, :name:, :full_name:, :description:, :html_url:, :homepage:,
                    :language:, :is_fork:, :is_archived:, :visibility:, :stargazers_count:, :forks_count:,
                    :open_issues_count:, :created_at:, :updated_at:, :pushed_at:, :synced_at:
                )
                ON DUPLICATE KEY UPDATE
                    owner_login = VALUES(owner_login),
                    name = VALUES(name),
                    full_name = VALUES(full_name),
                    description = VALUES(description),
                    html_url = VALUES(html_url),
                    homepage = VALUES(homepage),
                    language = VALUES(language),
                    is_fork = VALUES(is_fork),
                    is_archived = VALUES(is_archived),
                    visibility = VALUES(visibility),
                    stargazers_count = VALUES(stargazers_count),
                    forks_count = VALUES(forks_count),
                    open_issues_count = VALUES(open_issues_count),
                    created_at = VALUES(created_at),
                    updated_at = VALUES(updated_at),
                    pushed_at = VALUES(pushed_at),
                    synced_at = VALUES(synced_at)
            ";

            try {
                $this->db->query($sql, $row);
                $upserted++;
            } catch (Throwable $e) {
                $errors[] = "DB upsert failed for {$row['full_name']}: " . $e->getMessage();
            }
        }

        $fetched += count($repos);

        if (count($repos) < $perPage) {
            break;
        }

        $page++;
    }

    return [
        'fetched'  => $fetched,
        'upserted' => $upserted,
        'pages'    => $page,
        'errors'   => $errors,
    ];
}

/**
 * HTTP GET JSON from GitHub API.
 *
 * @param string $url
 * @param string|null $token
 * @return array{ok:bool, data?:mixed, error?:string, status?:int}
 */
private function githubHttpGetJson(string $url, ?string $token = null): array {
    $headers = [
        'User-Agent: VerdinCMS-GitHubSync',
        'Accept: application/vnd.github+json',
        'X-GitHub-Api-Version: 2022-11-28',
    ];

    if (!empty($token)) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }

    if (function_exists('curl_init')) {
        $ch = curl_init($url);

        if ($ch === false) {
            return ['ok' => false, 'error' => 'curl_init failed'];
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_TIMEOUT        => 20,
        ]);

        $body   = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err    = curl_error($ch);

        curl_close($ch);

        if ($body === false) {
            return ['ok' => false, 'error' => "cURL error: {$err}", 'status' => $status];
        }

        $json = json_decode($body, true);

        if ($status >= 200 && $status < 300) {
            return ['ok' => true, 'data' => $json, 'status' => $status];
        }

        $msg = is_array($json) && isset($json['message'])
            ? (string) $json['message']
            : 'HTTP error';

        return ['ok' => false, 'error' => "{$msg} (HTTP {$status})", 'status' => $status];
    }

    // Fallback: file_get_contents (shared hosting safe)
    $context = stream_context_create([
        'http' => [
            'method'  => 'GET',
            'header'  => implode("\r\n", $headers) . "\r\n",
            'timeout' => 20,
        ],
    ]);

    $body = @file_get_contents($url, false, $context);
    if ($body === false) {
        return ['ok' => false, 'error' => 'file_get_contents failed (check allow_url_fopen and SSL).'];
    }

    $status = 0;
    if (isset($http_response_header[0]) &&
        preg_match('#HTTP/\S+\s+(\d{3})#', $http_response_header[0], $m)) {
        $status = (int) $m[1];
    }

    $json = json_decode($body, true);

    if ($status >= 200 && $status < 300) {
        return ['ok' => true, 'data' => $json, 'status' => $status];
    }

    $msg = is_array($json) && isset($json['message'])
        ? (string) $json['message']
        : 'HTTP error';

    return ['ok' => false, 'error' => "{$msg} (HTTP {$status})", 'status' => $status];
}


/**
 * Convert GitHub ISO-8601 date to SQL DATETIME.
 *
 * @param string|null $iso
 * @return string|null
 */
private function isoToSqlDateTime(?string $iso): ?string {
    if (empty($iso)) {
        return null;
    }

    try {
        return (new DateTimeImmutable($iso))->format('Y-m-d H:i:s');
    } catch (Throwable $e) {
        return null;
    }
}

/**
 * Returns all GitHub repositories from the database.
 *
 * @param string $orderBy Column to sort by.
 * @param string $direction Sort direction (ASC or DESC).
 * @return array List of GitHub repositories.
 */
public function getGithubRepos(string $orderBy = 'pushed_at', string $direction = 'DESC'): array {
    $direction = strtoupper($direction);
    if (!in_array($direction, ['ASC', 'DESC'], true)) {
        $direction = 'DESC';
    }

    // Whitelist sortable columns
    $allowedOrderBy = [
        'name',
        'full_name',
        'language',
        'stargazers_count',
        'forks_count',
        'open_issues_count',
        'created_at',
        'updated_at',
        'pushed_at',
        'synced_at',
    ];

    if (!in_array($orderBy, $allowedOrderBy, true)) {
        $orderBy = 'pushed_at';
    }

    return $this->db->table('github_repos')
        ->orderBy($orderBy, $direction)
        ->get()
        ->getResultArray();
}


} // ─── End of Class ───
