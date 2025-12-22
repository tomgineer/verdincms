<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\AnalyticsModel;
// use App\Models\SystemModel;
// use App\Models\ActionsModel;

/**
 * ****************************************************
 * Dashboard Model — VerdinCMS 2026 Edition
 * ****************************************************
 *
 * Handles data aggregation and analytics retrieval for the dashboard.
 * Combines stats, content metrics, user data, and system diagnostics.
 *
 * Version : VerdinCMS 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Notes:
 * - Optimized for fast dashboard rendering and smart caching options.
 * - Fully compatible with CodeIgniter 4.x and PHP 8.3.
 *
 * ****************************************************
 */

class DashboardModel extends Model {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

/**
 * Retrieves hourly analytics data including raw statistics and formatted chart data.
 *
 * This method fetches hourly traffic statistics from the AnalyticsModel and prepares
 * the data for chart rendering, including both hourly traffic and peak hours.
 *
 * @return array {
 *     @type array $stats        Raw hourly traffic statistics.
 *     @type array $chart_hourly Formatted chart data for hourly traffic.
 *     @type array $chart_peak   Formatted chart data for peak hours.
 * }
 */
public function getHourlyAnalyticsData(): array {
    $analytics = new AnalyticsModel();
    $data = $analytics->getStatsHourlyTraffic();

    return [
        'stats'        => $data,
        'chart_hourly' => $analytics->formatForChart($data['hourly_traffic'], 'f_hour', 'cnt', 0, false, 'Hourly Traffic'),
        'chart_peak'   => $analytics->formatForChart($data['peak_hours'], 'f_hour', 'cnt', 0, false, 'Peak Hours')
    ];
}

/**
 * Retrieves visitor and hit statistics data, including raw stats and formatted chart data.
 *
 * This method fetches visitor and hit statistics from the AnalyticsModel and prepares
 * the data for chart rendering, providing both visitor and hit charts.
 *
 * @return array {
 *     @type array $stats          Raw visitor and hit statistics.
 *     @type array $chart_visitors Formatted chart data for visitors.
 *     @type array $chart_hits     Formatted chart data for hits.
 * }
 */
public function getVisitorAndHitStatsData(): array {
    $analytics = new AnalyticsModel();
    $data = $analytics->getVisitorAndHitStats();

    return [
        'stats'          => $data,
        'chart_visitors' => $analytics->formatForChart($data['visitors'], 'f_created', 'cnt', 0, true, 'Visitors'),
        'chart_hits'     => $analytics->formatForChart($data['hits'], 'f_created', 'cnt', 0, true, 'Hits')
    ];
}

/**
 * Retrieves country or browser statistics data, including raw stats and formatted chart data.
 *
 * Depending on the specified type, this method fetches either country visit statistics
 * or browser usage statistics from the AnalyticsModel and prepares the data for chart rendering.
 * If an invalid type is provided, an error is logged and an empty array is returned.
 *
 * @param string $type The type of statistics to retrieve. Accepted values are 'country' or 'browser'.
 *
 * @return array {
 *     @type array|null $countries      Raw country visit statistics (only if type is 'country').
 *     @type array|null $chart_countries Formatted chart data for country visits (only if type is 'country').
 *     @type array|null $browsers       Raw browser usage statistics (only if type is 'browser').
 *     @type array|null $chart_browsers Formatted chart data for browser visits (only if type is 'browser').
 * }
 */
public function getCountryAndBrowserStatsData(string $type = 'country'): array {
    $analytics = new AnalyticsModel();

    if ($type === 'country') {
        $countries = $analytics->getStatsCountries();
        return [
            'countries'       => $countries,
            'chart_countries' => $analytics->formatForChart($countries, 'country', 'visits', 10, false, 'Country Visits')
        ];
    }

    if ($type === 'browser') {
        $browsers = $analytics->getStatsBrowsers();
        return [
            'browsers'        => $browsers,
            'chart_browsers'  => $analytics->formatForChart($browsers, 'browser_label', 'visits', 10, false, 'Browser Visits')
        ];
    }

    log_message('error', "Invalid stats type requested: {$type}");
    return [];
}

/**
 * Retrieves PHP and database environment information.
 *
 * This method returns details about the current PHP version, Zend version,
 * loaded PHP extensions, and database platform and version.
 *
 * @return array {
 *     @type string $PHP Version       The current PHP version.
 *     @type string $Zend Version      The current Zend Engine version.
 *     @type string $Loaded Extensions A comma-separated list of loaded PHP extensions.
 *     @type string $DB Platform       The database platform/driver name.
 *     @type string $DB Version        The database version.
 * }
 */
public function getPhpInfo(): array {
    return [
        'PHP Version'       => phpversion(),
        'Zend Version'      => zend_version(),
        'Loaded Extensions' => implode(', ', get_loaded_extensions()),
        'DB Platform'       => $this->db->getPlatform(),
        'DB Version'        => $this->db->getVersion(),
    ];
}

/**
 * Gather detailed system and database configuration information.
 *
 * Includes PHP, server, VerdinCMS, and database settings.
 *
 * @return array Associative array with 'system' and 'database' info.
 */
public function getSystemAndDatabaseInfo(): array {
    $maxUpload = ini_get('upload_max_filesize');
    $maxPost   = ini_get('post_max_size');
    $maxMemory = ini_get('memory_limit');
    $maxExec   = ini_get('max_execution_time');

    $systemInfo = [
        'VerdinCMS Version'      => setting('system.version'),
        'CodeIgniter Version'    => \CodeIgniter\CodeIgniter::CI_VERSION,
        'App Environment'        => ENVIRONMENT,
        'Base URL'               => base_url(),
        'PHP Version'            => phpversion(),
        'PHP SAPI'               => php_sapi_name(),
        'PHP Timezone'           => date_default_timezone_get(),
        'PHP Memory Limit'       => $maxMemory,
        'PHP Max Upload Size'    => $maxUpload,
        'PHP Max POST Size'      => $maxPost,
        'PHP Max Execution Time' => $maxExec . ' sec',
        'Server Software'        => $_SERVER['SERVER_SOFTWARE'] ?? php_uname(),
        'Operating System'       => php_uname('s') . ' ' . php_uname('r'),
    ];

    $platform   = ucfirst($this->db->getPlatform());
    $version    = $this->db->getVersion();
    $database   = $this->db->getDatabase();

    $variables = $this->db->query("
        SHOW VARIABLES
        WHERE Variable_name IN ('character_set_database', 'collation_database', 'system_time_zone')
    ")->getResultArray();

    $varMap = array_column($variables, 'Value', 'Variable_name');
    $charset   = $varMap['character_set_database'] ?? 'unknown';
    $collation = $varMap['collation_database'] ?? 'unknown';
    $timezone  = $varMap['system_time_zone'] ?? 'unknown';

    $sessionTzRow = $this->db->query("SELECT @@session.time_zone AS tz")->getRow();
    $timezoneSession = $sessionTzRow?->tz ?? 'unknown';

    $userRow = $this->db->query("SELECT CURRENT_USER() AS user")->getRow();
    $timeRow = $this->db->query("SELECT NOW() AS now, CURRENT_TIMESTAMP AS current_ts, CURDATE() AS curdate")->getRow();
    $connections = $this->db->query("SHOW STATUS WHERE Variable_name = 'Threads_connected'")->getRow('Value');

    $databaseInfo = [
        'Database Platform'         => $platform,
        'Database Version'          => $version,
        'Database Name'             => $database,
        'Character Set'             => $charset,
        'Collation'                 => $collation,
        'MySQL Timezone'            => $timezone,
        'MySQL Session Timezone'    => $timezoneSession . ' (Set in Config/Events)',
        'NOW()'                     => $timeRow?->now ?? 'unknown',
        'CURRENT_TIMESTAMP'         => $timeRow?->current_ts ?? 'unknown',
        'CURDATE()'                 => $timeRow?->curdate ?? 'unknown',
        'Current DB User'           => $userRow?->user ?? 'unknown',
        'Active Connections'        => $connections ?? 'unknown',
    ];

    return [
        'system'   => $systemInfo,
        'database' => $databaseInfo,
    ];
}

/**
 * Retrieve the latest content entries from posts or pages.
 *
 * @param string $type  Content type ('post' or 'page').
 * @param int    $limit Maximum number of items to return.
 * @return array        List of latest content items with metadata.
 */
public function getLatestContent($type = 'post', $limit = 10) {
    $builder = $this->db->table(($type === 'post') ? 'posts p' : 'pages p')
                        ->select('p.id, p.title, p.subtitle, p.hits, p.words')
                        ->select("DATE_FORMAT(created, '%d %b %Y') AS f_created", false);

    if ($type === 'page') {
        $builder->select('p.slug, s.slug AS s_slug');
        $builder->join('sections s', 's.id = p.section_id');
    }

    $builder->where('p.id !=', 0)
            ->orderBy('p.created', 'DESC')
            ->limit($limit);

    return $builder->get()->getResultArray();
}

/**
 * Retrieve cron job log entries with formatted date and time.
 *
 * @param int $limit  Maximum number of log entries to return.
 * @param int $offset Offset for paginated results.
 * @return array      List of cron log records.
 */
public function getCronLog(int $limit = PHP_INT_MAX, int $offset = 0): array {
    return $this->db->table('cron_log')
                    ->select([
                        'id',
                        'type',
                        'log',
                        "DATE_FORMAT(created, '%W, %d %M %Y') AS cron_date",
                        "DATE_FORMAT(created, '%H:%i:%S') AS cron_time"
                    ])
                    ->orderBy('created', 'DESC')
                    ->limit($limit, $offset)
                    ->get()
                    ->getResultArray();
}

/**
 * Retrieve visitor hit entries with formatted date and mobile flag.
 *
 * @param int $limit  Maximum number of entries to return.
 * @param int $offset Offset for paginated results.
 * @return array      List of hit records with extra fields.
 */
public function getHitsEntries(int $limit = PHP_INT_MAX, int $offset = 0): array {
     return $this->db->table('stats')
                     ->select([
                         '*',
                         "DATE_FORMAT(created, '%d %b %Y') AS date_logged",
                         "IF(is_mobile = 1, 'Yes', 'No') AS is_mobile"
                     ])
                     ->orderBy('updated', 'DESC')
                     ->limit($limit, $offset)
                     ->get()
                     ->getResultArray();
}

/**
 * Retrieves error log files and their contents.
 *
 * This method scans the log directory for log files matching the "log-*.log" pattern,
 * reads their contents (if accessible), and returns them sorted by last modified date in descending order.
 * If the log directory cannot be read, a single error entry is returned.
 *
 * @return array[] Each array contains log file data with keys:
 *                 - filename (string) The log file name.
 *                 - content (string) The content of the log file or an error message if unreadable.
 *                 - date (int) The file's last modified timestamp (UNIX timestamp).
 */
public function getErrorLogs(): array {
    $logPath = WRITEPATH . 'logs/';
    $files   = scandir($logPath);
    $logs    = [];

    if ($files === false) {
        return [['error' => 'Unable to read log directory.']];
    }

    foreach ($files as $file) {
        // Only process files that match "log-*.log"
        $isLogFile = str_starts_with($file, 'log-') && pathinfo($file, PATHINFO_EXTENSION) === 'log';
        if (!$isLogFile) continue;

        $filePath = $logPath . $file;

        $logs[] = [
            'filename' => $file,
            'content'  => is_readable($filePath)
                ? file_get_contents($filePath)
                : 'Unable to read this log file.',
            'date'     => is_readable($filePath)
                ? filemtime($filePath)
                : 0
        ];
    }

    // Sort logs by last modified date (descending)
    usort($logs, fn($a, $b) => $b['date'] <=> $a['date']);

    return $logs;
}

/**
 * Retrieve content entries (posts or pages) marked for review.
 *
 * @param string $type  Content type ('post' or 'page').
 * @param int    $limit Maximum number of entries to return.
 * @return array        List of review-pending content items with metadata.
 *
 * @throws \InvalidArgumentException If an invalid type is provided.
 */
public function needReview(string $type = 'post', int $limit = 15): array {
    // Match the type to the correct table and additional joins
    $match = match ($type) {
        'post' => [
            'table'  => 'posts',
            'select' => 't.title AS topic, t.slug AS topic_slug',
            'join'   => ['topics t', 't.id = p.topic_id']
        ],
        'page' => [
            'table'  => 'pages',
            'select' => 'p.slug, s.title AS section, s.slug AS s_slug',
            'join'   => ['sections s', 's.id = p.section_id']
        ],
        default => throw new \InvalidArgumentException('Invalid type: must be "post" or "page".')
    };

    $builder = $this->db->table($match['table'] . ' p')
        ->select('p.id, p.status, p.title, p.subtitle, p.hits')
        ->select("DATE_FORMAT(p.created, '%b %d, %Y %H:%i') AS f_created", false)
        ->select($match['select'])
        ->join(...$match['join'])
        ->where('p.status', 1)
        ->where('p.review', 1)
        ->where('p.id !=', 0)
        ->orderBy('p.id', 'ASC')
        ->limit($limit);

    return $builder->get()->getResultArray();
}

/**
 * Retrieve archived content entries (posts or pages).
 *
 * Supports filtering by status codes (e.g., drafts, deleted) and user tier.
 *
 * @param string $type   Content type ('post' or 'page').
 * @param string $status Comma-separated list of status codes to include.
 * @param int    $limit  Maximum number of entries to return.
 * @return array         List of archived content items with metadata.
 */
public function getArchivedContent(
    string $type = 'post',
    string $status = '2,3',
    int $limit = 30
): array {
    $user_id   = session('user_id');
    $statusArr = explode(',', $status);

    $query = $this->db->table(($type === 'post') ? 'posts p' : 'pages p')
                      ->select('p.id, p.status, p.title, p.subtitle, p.hits')
                      ->select("DATE_FORMAT(p.created, '%b %d, %Y %H:%i') AS f_created", false)
                      ->select("CASE p.status WHEN 2 THEN 'Draft' WHEN 3 THEN 'Deleted' ELSE 'Unknown' END AS f_status", false)
                      ->whereIn('p.status', $statusArr)
                      ->orderBy('p.created', 'DESC')
                      ->limit($limit);

    if ($type === 'post') {
        $query->select('t.title as topic, t.slug as topic_slug')
              ->join('topics t', 't.id = p.topic_id');
    } else {
        $query->select('p.slug, s.title as section, s.slug AS s_slug')
              ->join('sections s', 's.id = p.section_id');
    }

    if ( tier() == 9 ) { // Writer
        $query->where('p.user_id', $user_id);
    }

    return $query->get()->getResultArray();
}

/**
 * Retrieve subjects with post or page counts.
 *
 * Supports fetching either topics (with post counts) or sections (with page counts).
 *
 * @param string $type  Subject type ('topics' or 'sections').
 * @param int    $limit Maximum number of subjects to return.
 * @return array        List of subjects with metadata and content counts.
 */
public function getSubjects(string $type = 'topics', int $limit = PHP_INT_MAX): array {
    if ($type === 'topics') {
        $builder = $this->db->table('topics t')
                            ->select('t.id, t.title, t.description, t.slug, COUNT(p.topic_id) AS count')
                            ->join('posts p', 't.id = p.topic_id', 'left')
                            ->groupBy('t.id')
                            ->orderBy('count', 'DESC')
                            ->orderBy('t.title', 'ASC')
                            ->limit($limit);
    } elseif ($type === 'sections') {
        $builder = $this->db->table('sections s')
                            ->select('s.id, s.title, s.description, s.slug, COUNT(p.section_id) AS count')
                            ->join('pages p', 's.id = p.section_id', 'left')
                            ->groupBy('s.id')
                            ->orderBy('count', 'DESC')
                            ->orderBy('s.title', 'ASC')
                            ->limit($limit);
    } else {
        return [];
    }

    return $builder->get()->getResultArray();
}

/**
 * Retrieve user records with group and stand-in details.
 *
 * Optionally filters by one or more status codes.
 *
 * @param string $status Comma-separated list of status codes to filter by.
 * @return array         List of users with metadata and formatted fields.
 */
public function getUserData(string $status = ''): array {
    // Parse comma-separated statuses into array
    $statusArr = [];
    if (strlen($status) > 0) {
        $statusArr = array_filter(array_map('trim', explode(',', $status)), fn($val) => is_numeric($val));
    }

    $builder = $this->db->table('users u')
                        ->select([
                            'u.*',
                            'g.tier',
                            'g.title AS group_title',
                            "CONCAT(ur.first_name, ' ', ur.last_name) AS standin",
                            "DATE_FORMAT(u.created, '%b %d, %Y %H:%i') AS f_created",
                            "CASE u.status
                                WHEN 0 THEN 'Deleted'
                                WHEN 1 THEN 'Active'
                                WHEN 2 THEN 'Inactive'
                                END AS status_label"
                        ], false)
                        ->join('user_groups g', 'g.id = u.user_group_id', 'inner')
                        ->join('users ur', 'ur.id = u.standin_id', 'left')
                        ->orderBy('u.last_name', 'ASC');

        if (!empty($statusArr)) {
            $builder->whereIn('u.status', $statusArr);
        }

    return $builder->get()->getResultArray();
}

/**
 * Retrieves blocks grouped by their block group title.
 *
 * This method fetches all blocks from the database along with their block group titles,
 * and returns them grouped by block group in an associative array.
 *
 * @return array<string, array> An associative array where each key is a block group title,
 *                              and each value is an array of blocks with keys:
 *                              - (all original columns from blocks table)
 *                              - block_group (string|null) The block group title, or null if none.
 */
public function getBlocks(): array {
    $results = $this->db->table('blocks b')
                        ->select('b.*, g.title AS block_group')
                        ->join('block_groups g', 'g.id = b.block_group_id', 'left')
                        ->orderBy('g.title', 'ASC')
                        ->orderBy('b.alias', 'ASC')
                        ->get()
                        ->getResultArray();

    return array_reduce($results, function(array $groups, array $block): array {
        $groups[$block['block_group']][] = $block;
        return $groups;
    }, []);
}

/**
 * Deletes multiple records from a given table inside a transaction.
 *
 * @param string $table The table name (validated by the controller).
 * @param array  $ids   Array of integer IDs to delete.
 * @return array        Status and number of affected rows.
 */
public function bulk_delete(string $table, array $ids): array {
    $builder = $this->db->table($table);

    $this->db->transStart();
    $builder->whereIn('id', $ids)->delete();
    $affected = $this->db->affectedRows();
    $this->db->transComplete();

    if (! $this->db->transStatus()) {
        return [
            'status'        => 'error',
            'message'       => 'Transaction failed',
            'affected_rows' => 0,
        ];
    }

    return [
        'status'        => 'success',
        'affected_rows' => $affected,
    ];
}

/**
 * Reads and returns the raw contents of /config/settings.json.
 *
 * Ensures UTF-8 compatibility and returns the JSON text exactly as stored.
 * If the file does not exist, a JSON-encoded error message is returned
 * instead of throwing an exception.
 *
 * @return string The raw JSON contents of the settings file, or an error JSON string.
 */
public function getSettings(): string {
    $file = ROOTPATH . 'themes/config.json';

    if (!is_file($file)) {
        return json_encode(['error' => 'Settings file not found.'], JSON_UNESCAPED_UNICODE);
    }

    $json = file_get_contents($file);

    // Ensure the file is UTF-8 encoded and valid JSON
    if ($json === false || trim($json) === '') {
        return json_encode(['error' => 'Settings file is empty or unreadable.'], JSON_UNESCAPED_UNICODE);
    }

    // Normalize JSON to make sure Unicode characters (like Greek) are not escaped
    $decoded = json_decode($json, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        return json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    // If invalid JSON, just return raw content as a fallback
    return $json;
}

/**
 * Retrieves basic data (id and title) from pages, topics, and sections tables.
 *
 * @return array Associative array containing the table name as key
 *               and an array of rows (id, title) as value.
 */
public function getSortTables(): array {
    $tables  = ['pages', 'topics', 'sections'];
    $columns = ['id', 'title'];
    $result  = [];

    foreach ($tables as $table) {
        $builder = $this->db->table($table)
            ->select(implode(',', $columns))
            ->orderBy('position', 'ASC')
            ->orderBy('title', 'ASC');

        $query = $builder->get();
        $result[$table] = $query->getResultArray();
    }

    return $result;
}

/**
 * Updates the sort order of records in a given table.
 *
 * @param string $table Table name ('pages', 'topics', or 'sections').
 * @param array  $ids   Ordered array of record IDs.
 * @return void
 */
public function updateOrder(string $table, array $ids): void {
    // Whitelist allowed tables for safety
    $allowedTables = ['pages', 'topics', 'sections'];
    if (! in_array($table, $allowedTables, true)) {
        log_message('error', "updateOrder() rejected invalid table: {$table}");
        return;
    }

    $builder = $this->db->table($table);

    // Loop through IDs and update the sort/position field
    foreach ($ids as $position => $id) {
        $builder->where('id', (int) $id)
                ->update(['position' => $position + 1]);
    }
}

/**
 * Returns active and inactive newsletter subscriber emails.
 *
 * @return array{active_subs: array, inactive_subs: array}
 */
public function getSubscribers(): array {
    $get = fn(int $status) => array_column(
        $this->db->table('newsletter')
            ->select('email')
            ->where('confirmed', $status)
            ->orderBy('email', 'ASC')
            ->get()
            ->getResultArray(),
        'email'
    );

    return [
        'active_subs'   => $get(1),
        'inactive_subs' => $get(0),
    ];
}

/**
 * Builds a default HTML snippet for this week's newsletter content.
 *
 * Uses getNewsletterContent() and returns nicely structured HTML with:
 * - "Νέα άρθρα της εβδομάδας" for posts
 * - "Νέες σελίδες της εβδομάδας" for pages
 *
 * @return string
 */
public function buildWeeklyNewsletterHtml(int $limit = 20): string {
    $content = $this->getNewsletterContent($limit);

    $posts = $content['posts'] ?? [];
    $pages = $content['pages'] ?? [];

    $html = '';

    // Posts block
    if (!empty($posts)) {
        $html .= "<h1>Νέα άρθρα της εβδομάδας</h1>\n\n";

        foreach ($posts as $post) {
            $title    = htmlspecialchars($post['title'] ?? '', ENT_QUOTES, 'UTF-8');
            $subtitle = htmlspecialchars($post['subtitle'] ?? '', ENT_QUOTES, 'UTF-8');

            // base_url/post/{id}
            $url = base_url('post/' . ($post['id'] ?? ''));

            $html .= "<h3>{$title}</h3>\n";

            if ($subtitle !== '') {
                $html .= "<p>{$subtitle}</p>\n";
            }

            $html .= '<p><a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">Διαβάστε περισσότερα</a></p>' . "\n\n";
        }
    }

    // Pages block
    if (!empty($pages)) {
        // Add spacing between sections if both exist
        if ($html !== '') {
            $html .= "\n\n";
        }

        $html .= "<h1>Νέες σελίδες της εβδομάδας</h1>\n\n";

        foreach ($pages as $page) {
            $title       = htmlspecialchars($page['title'] ?? '', ENT_QUOTES, 'UTF-8');
            $subtitle    = htmlspecialchars($page['subtitle'] ?? '', ENT_QUOTES, 'UTF-8');
            $sectionSlug = $page['section_slug'] ?? '';
            $pageSlug    = $page['page_slug'] ?? '';

            // base_url/(section slug)/(page slug)
            $path = trim($sectionSlug . '/' . $pageSlug, '/');
            $url  = base_url($path);

            $html .= "<h3>{$title}</h3>\n";

            if ($subtitle !== '') {
                $html .= "<p>{$subtitle}</p>\n";
            }

            $html .= '<p><a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">Διαβάστε περισσότερα</a></p>' . "\n\n";
        }
    }

    return trim($html);
}

/**
 * Get recent posts and pages for newsletter content.
 *
 * @param int $limit Maximum number of posts/pages to return per group.
 * @return array{
 *     posts: array<int, array<string,mixed>>,
 *     pages: array<int, array<string,mixed>>
 * }
 */
protected function getNewsletterContent(int $limit = 20): array {
    // Determine timeframe
    $startDate = date('Y-m-d 00:00:00', strtotime('monday this week'));
    $endDate   = date('Y-m-d 23:59:59', strtotime('sunday this week'));

    // Testing: last ~630 days
    $startDate = date('Y-m-d 00:00:00', strtotime('-630 days'));
    $endDate   = date('Y-m-d 23:59:59', strtotime('now'));

    // Fetch posts
    $posts = $this->db->table('posts')
        ->select('id, title, subtitle, created')
        ->where('created >=', $startDate)
        ->where('created <=', $endDate)
        ->orderBy('created', 'DESC')
        ->limit($limit)
        ->get()
        ->getResultArray();

    // Fetch pages (with section + page slug)
    $pages = $this->db->table('pages p')
        ->select('p.id, p.title, p.subtitle, p.slug AS page_slug, s.slug AS section_slug, p.created')
        ->join('sections s', 's.id = p.section_id', 'inner')
        ->where('p.created >=', $startDate)
        ->where('p.created <=', $endDate)
        ->where('p.status', 1)
        ->where('p.accessibility', 0)
        ->where('s.id !=', 1)
        ->orderBy('p.created', 'DESC')
        ->limit($limit)
        ->get()
        ->getResultArray();

    return [
        'posts' => $posts,
        'pages' => $pages,
    ];
}


} // ─── End of Class ───
