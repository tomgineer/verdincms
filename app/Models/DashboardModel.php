<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\AnalyticsModel;
use App\Models\SystemModel;
use App\Models\ActionsModel;

/**
 * ****************************************************
 * Dashboard Model — Voralis Core 2026 Edition
 * ****************************************************
 *
 * Handles data aggregation and analytics retrieval for the dashboard.
 * Combines stats, content metrics, user data, and system diagnostics.
 *
 * Version : Voralis Core 2026
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
 * Retrieves detailed system and database environment information.
 *
 * This method gathers system configuration values, PHP environment details,
 * and database metadata including platform, version, character set, timezone,
 * and current connections.
 *
 * @return array {
 *     @type array $system {
 *         @type string $VerdinCMS Version      The VerdinCMS version.
 *         @type string $CodeIgniter Version    The CodeIgniter version.
 *         @type string $App Environment        The current application environment.
 *         @type string $Base URL               The application base URL.
 *         @type string $PHP Version            The PHP version.
 *         @type string $PHP SAPI               The PHP Server API (SAPI) type.
 *         @type string $PHP Timezone           The PHP timezone setting.
 *         @type string $PHP Memory Limit       The PHP memory limit.
 *         @type string $PHP Max Upload Size    The maximum upload filesize.
 *         @type string $PHP Max POST Size      The maximum POST size.
 *         @type string $PHP Max Execution Time The maximum script execution time.
 *         @type string $Server Software        The server software string or OS info.
 *         @type string $Operating System       The operating system name and version.
 *     }
 *     @type array $database {
 *         @type string $Database Platform      The database platform/driver name.
 *         @type string $Database Version       The database version.
 *         @type string $Database Name          The name of the database.
 *         @type string $Character Set          The database character set.
 *         @type string $Collation              The database collation.
 *         @type string $MySQL Timezone         The database server timezone.
 *         @type string $MySQL Session Timezone The session timezone setting.
 *         @type string $NOW()                  The current date and time from the database.
 *         @type string $CURRENT_TIMESTAMP      The current timestamp from the database.
 *         @type string $CURDATE()              The current date from the database.
 *         @type string $Current DB User        The current database user.
 *         @type string $Active Connections     The number of active database connections.
 *     }
 * }
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
 * Retrieves the latest posts or pages.
 *
 * This method fetches a list of the latest posts or pages from the database,
 * including basic details such as title, subtitle, hits, word count, and formatted creation date.
 * When fetching pages, it also includes the page and section slugs.
 *
 * @param string $type  The type of content to retrieve. Accepted values are 'post' or 'page'. Defaults to 'post'.
 * @param int    $limit The maximum number of records to return. Defaults to 10.
 *
 * @return array[] Each array contains the content data with keys:
 *                 - id (int)
 *                 - title (string)
 *                 - subtitle (string|null)
 *                 - hits (int)
 *                 - words (int)
 *                 - f_created (string)
 *                 - slug (string, only if type is 'page')
 *                 - s_slug (string, only if type is 'page')
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
 * Retrieves entries from the cron log.
 *
 * This method fetches log entries from the cron_log table, including formatted date and time.
 * Results are ordered by creation date in descending order and can be paginated using limit and offset.
 *
 * @param int $limit  The maximum number of records to return. Defaults to PHP_INT_MAX.
 * @param int $offset The offset for pagination. Defaults to 0.
 *
 * @return array[] Each array contains the cron log data with keys:
 *                 - id (int)
 *                 - type (string)
 *                 - log (string)
 *                 - cron_date (string) Formatted date (e.g. Monday, 04 May 2025).
 *                 - cron_time (string) Formatted time (e.g. 14:32:10).
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
 * Retrieves hit entries from the stats table.
 *
 * This method fetches hit records, including formatted creation date and mobile flag.
 * Results are ordered by the last updated date in descending order and can be paginated using limit and offset.
 *
 * @param int $limit  The maximum number of records to return. Defaults to PHP_INT_MAX.
 * @param int $offset The offset for pagination. Defaults to 0.
 *
 * @return array[] Each array contains the hit entry data with keys:
 *                 - (all original columns from stats table)
 *                 - date_logged (string) Formatted creation date (e.g. 04 May 2025).
 *                 - is_mobile (string) 'Yes' if mobile, 'No' otherwise.
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
 * Retrieves posts or pages that require review.
 *
 * This method fetches content entries marked for review from either the posts or pages table,
 * including related topic or section information depending on the type.
 *
 * @param string $type  The type of content to retrieve. Accepted values are 'post' or 'page'.
 * @param int    $limit The maximum number of records to return. Defaults to 15.
 *
 * @return array[] Each array contains the content data with keys:
 *                 - id (int)
 *                 - status (int)
 *                 - title (string)
 *                 - subtitle (string|null)
 *                 - hits (int)
 *                 - f_created (string) Formatted creation date and time (e.g. May 04, 2025 14:32).
 *                 - topic (string) The topic title (only if type is 'post').
 *                 - topic_slug (string) The topic slug (only if type is 'post').
 *                 - slug (string) The page slug (only if type is 'page').
 *                 - section (string) The section title (only if type is 'page').
 *                 - s_slug (string) The section slug (only if type is 'page').
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
 * Retrieves archived content (drafts and deleted posts/pages).
 *
 * This method fetches unpublished content from the posts or pages table based on the given status codes.
 * It includes additional information such as formatted creation date, status label, and related topic or section info.
 * Writers (tier 9) only see their own archived content.
 *
 * @param string $type   The type of content to retrieve. Accepted values are 'post' or 'page'. Defaults to 'post'.
 * @param string $status A comma-separated list of status codes to filter by. Defaults to '2,3' (Draft and Deleted).
 *
 * @return array[] Each array contains the archived content data with keys:
 *                 - id (int)
 *                 - status (int)
 *                 - title (string)
 *                 - subtitle (string|null)
 *                 - hits (int)
 *                 - f_created (string) Formatted creation date and time (e.g. May 04, 2025 14:32).
 *                 - f_status (string) The status label ('Draft', 'Deleted', or 'Unknown').
 *                 - topic (string) The topic title (only if type is 'post').
 *                 - topic_slug (string) The topic slug (only if type is 'post').
 *                 - slug (string) The page slug (only if type is 'page').
 *                 - section (string) The section title (only if type is 'page').
 *                 - s_slug (string) The section slug (only if type is 'page').
 */
public function getArchivedContent(string $type = 'post', string $status = '2,3'): array {
    $user_id   = session('user_id');
    $statusArr = explode(',', $status);

    $query = $this->db->table(($type === 'post') ? 'posts p' : 'pages p')
                      ->select('p.id, p.status, p.title, p.subtitle, p.hits')
                      ->select("DATE_FORMAT(p.created, '%b %d, %Y %H:%i') AS f_created", false)
                      ->select("CASE p.status WHEN 2 THEN 'Draft' WHEN 3 THEN 'Deleted' ELSE 'Unknown' END AS f_status", false)
                      ->whereIn('p.status', $statusArr)
                      ->orderBy('p.created', 'DESC');

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
 * Retrieves a list of topics or sections with associated content counts.
 *
 * This method fetches either topics (with post counts) or sections (with page counts)
 * from the database. Results are ordered by content count (descending) and then title (ascending).
 * If an invalid type is provided, an empty array is returned.
 *
 * @param string $type  The type of subject to retrieve. Accepted values are 'topics' or 'sections'. Defaults to 'topics'.
 * @param int    $limit The maximum number of records to return. Defaults to PHP_INT_MAX.
 *
 * @return array[] Each array contains the subject data with keys:
 *                 - id (int)
 *                 - title (string)
 *                 - description (string|null)
 *                 - slug (string)
 *                 - count (int) The number of associated posts (for topics) or pages (for sections).
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
 * Retrieves user or member data, optionally filtered by status.
 *
 * This method fetches records from either the users or members table, including
 * formatted dates and status labels. If a comma-separated status filter is provided,
 * only records matching the status codes are returned.
 * Returns an empty array if an invalid type is provided.
 *
 * @param string $type   The type of records to retrieve. Accepted values are 'users' or 'members'. Defaults to 'users'.
 * @param string $status Optional comma-separated list of status codes to filter by.
 *
 * @return array[] Each array contains the user or member data with keys:
 *                 - (all original columns from users or members table)
 *                 - tier (int, only if type is 'users')
 *                 - group_title (string, only if type is 'users')
 *                 - standin (string|null, only if type is 'users')
 *                 - f_created (string) Formatted creation date and time.
 *                 - status_label (string) The status label ('Deleted', 'Active', 'Inactive').
 *                 - f_membership_activated (string, only if type is 'members') Formatted membership activation date.
 *                 - f_membership_expiration (string, only if type is 'members') Formatted membership expiration date.
 *
 * Returns an empty array for invalid type.
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
 * Retrieves a list of predefined admin links.
 *
 * This method returns an array of admin link definitions used for navigation or shortcuts
 * in the admin panel.
 *
 * @return array[] Each array contains link data with keys:
 *                 - title (string) The display title of the link.
 *                 - action (string) The route or action URL.
 *                 - icon (string) The icon identifier.
 */
public function getAdminLinks(): array {
    $links = [
        [
            'title'  => 'Add Post',
            'action' => 'admin/edit/post/new',
            'icon'   => 'add',
        ],
        [
            'title'  => 'Add Page',
            'action' => 'admin/edit/page/new',
            'icon'   => 'add-page',
        ],
    ];

    return $links;

}

/**
 * Retrieves a list of sortable entities for the admin interface.
 *
 * This method returns an array of sortable entity definitions, used to
 * define sortable actions in the admin panel.
 *
 * @return array[] Each array contains sortable data with keys:
 *                 - title (string) The display title of the sortable action.
 *                 - action (string) The sortable action identifier.
 *                 - icon (string) The icon identifier.
 */
public function getSortablesArray(): array {
    $sortables = [
        [
            'title'  => 'Sort Pages',
            'action' => 'sortPages',
            'icon'   => 'swap-vert',
        ],
        [
            'title'  => 'Sort Topics',
            'action' => 'sortTopics',
            'icon'   => 'swap-vert',
        ],
        [
            'title'  => 'Sort Sections',
            'action' => 'sortSections',
            'icon'   => 'swap-vert',
        ],
        [
            'title'  => 'Sort Settings',
            'action' => 'sortSettings',
            'icon'   => 'swap-vert',
        ],
    ];
    return $sortables;
}

} // ─── End of Class ───