<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

/**
 * ****************************************************
 * Analytics Model — VerdinCMS 2026 Edition
 * ****************************************************
 *
 * Handles all analytics-related database operations, including tracking,
 * statistics aggregation, and traffic/event logging functionality.
 *
 * Version : VerdinCMS 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Notes:
 * - Optimized for performance and data accuracy in large datasets.
 * - Fully compatible with CodeIgniter 4.x and PHP 8.3.
 *
 * ****************************************************
 */

class AnalyticsModel extends Model {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

/**
 * Retrieves daily visitor and hit statistics.
 *
 * Optionally formats results for chart display.
 *
 * @param int  $limit     Number of days to retrieve
 * @param bool $forChart  Whether to format for charting
 * @return array          Visitors and hits data
 */
public function getVisitorAndHitStats(int $limit = 30, bool $forChart = false): array {
    // Get visitor counts
    $visitors = $this->db->table('stats')
                         ->select("DATE_FORMAT(created, '%W, %d %b %Y') AS f_created", false)
                         ->selectCount('id', 'cnt')
                         ->groupBy('created')
                         ->orderBy('created', 'DESC')
                         ->limit($limit)
                         ->get()->getResultArray();

    // Get hit sums
    $hits = $this->db->table('stats')
                     ->select("DATE_FORMAT(created, '%W, %d %b %Y') AS f_created", false)
                     ->selectSum('hits', 'cnt')
                     ->groupBy('created')
                     ->orderBy('created', 'DESC')
                     ->limit($limit)
                     ->get()->getResultArray();

    // Reverse if needed
    if ($forChart) {

        $visitors = array_map(static function ($row) {
            return [
                'label' => $row['f_created'],
                'cnt'   => $row['cnt']
            ];
        }, $visitors);

        $hits = array_map(static function ($row) {
            return [
                'label' => $row['f_created'],
                'cnt'   => $row['cnt']
            ];
        }, $hits);

        $visitors = array_reverse($visitors);
        $hits     = array_reverse($hits);
    }

    return [
        'visitors' => $visitors,
        'hits'     => $hits,
    ];
}

/**
 * Retrieves aggregated visit statistics by country.
 *
 * @param int $limit  Maximum number of countries to return
 * @return array      Country visit counts with percentages
 */
public function getStatsCountries(int $limit = 30): array {
    $builder = $this->db->table('stats');

    // Build the query
    $results = $builder->select(
                            "country, country_code,
                             COUNT(id) AS visits,
                             COUNT(DISTINCT fingerprint) AS unique_visitors,
                             SUM(is_mobile = 1) AS mobile_visits,
                             SUM(is_mobile = 0) AS desktop_visits,
                             DATE_FORMAT(MAX(updated), '%b %d, %Y') AS last_visit"
                        )
                        ->groupBy('country_code')
                        ->orderBy('visits', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->getResultArray();

    // Calculate total visits for % calculation
    if (!empty($results)) {
        $totalVisits = array_sum(array_column($results, 'visits'));

        $results = array_map(static function ($row) use ($totalVisits) {
            $row['perc'] = $totalVisits > 0 ? ceil(($row['visits'] * 1000) / $totalVisits) / 10 . '%' : '0%';
            return $row;
        }, $results);
    }

    return $results;
}

/**
 * Retrieves visit statistics grouped by browser and major version.
 *
 * @param int $limit  Maximum number of browsers to return
 * @return array      Browser usage data with percentages
 */
public function getStatsBrowsers(int $limit = 30): array {
    $results = $this->db->table('stats')
                        ->select("
                            browser,
                            CONCAT(browser, ' ', LEFT(browser_ver, LOCATE('.', browser_ver) - 1)) AS title,
                            COUNT(id) AS visits,
                            COUNT(DISTINCT fingerprint) AS unique_visitors,
                            SUM(is_mobile = 1) AS mobile_visits,
                            SUM(is_mobile = 0) AS desktop_visits,
                            LEFT(browser_ver, LOCATE('.', browser_ver) - 1) AS major_version,
                            DATE_FORMAT(MAX(updated), '%b %e, %Y') AS last_visit
                        ", false)
                        ->where("browser !=", '')
                        ->groupBy('browser, major_version')
                        ->orderBy('visits', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->getResultArray();

    if (!empty($results)) {
        $total = array_sum(array_column($results, 'visits'));

        $results = array_map(static function ($row) use ($total) {
            $row['perc'] = $total > 0 ? ceil(($row['visits'] * 1000) / $total) / 10 . '%' : '0%';
            $row['browser_label'] = $row['browser'] . ' ' . $row['major_version'];
            return $row;
        }, $results);
    }

    return $results;
}

/**
 * Retrieves traffic grouped by hour of the day.
 *
 * Returns both hourly distribution and peak traffic hours.
 *
 * @return array  Hourly traffic data and peak hour stats
 */
public function getStatsHourlyTraffic(): array {
    // Build the query using CodeIgniter 4 Query Builders
    $hourly_traffic = $this->db->table('stats')
                               ->select("
                                   HOUR(updated) AS hour_of_day,
                                   DATE_FORMAT(updated, '%H:00') AS f_hour,
                                   COUNT(id) AS cnt,
                                   SUBSTRING_INDEX(GROUP_CONCAT(country ORDER BY country ASC), ',', 1) AS top_country
                               ", false)
                               ->groupBy('hour_of_day')
                               ->orderBy('hour_of_day', 'ASC')
                               ->get()
                               ->getResultArray();

    // Sort a copy descending by count to get peak hours
    $peak_hours = $hourly_traffic;
    usort($peak_hours, static fn($a, $b) => $b['cnt'] <=> $a['cnt']);

    return [
        'hourly_traffic' => $hourly_traffic,
        'peak_hours'     => $peak_hours
    ];
}

/**
 * Retrieves the most popular posts or pages by hits.
 *
 * @param string $type   'post' or 'page'
 * @param int    $limit  Number of items to return
 * @return array         List of popular content
 */
public function getPopularContent($type = 'post', $limit = 20) {
    $builder = $this->db->table(($type === 'post') ? 'posts p' : 'pages p')
                        ->select('p.id, p.title, p.subtitle, p.hits, p.words')
                        ->select("DATE_FORMAT(created, '%d %b %Y') AS f_created", false);

    if ($type === 'page') {
        $builder->select('p.slug, s.slug AS s_slug');
        $builder->join('sections s', 's.id = p.section_id');
    }

    $builder->where('p.id !=', 0)
            ->orderBy('p.hits', 'DESC')
            ->limit($limit);

    return $builder->get()->getResultArray();
}

/**
 * Retrieves top-performing topics and sections based on hits per content.
 *
 * @param int $limit  Max number of entries to return
 * @return array      Topics and sections statistics
 */
public function getTopTopicsAndSections(int $limit = 20): array {
    $topics = $this->db->table('topics t')
                       ->select([
                           't.id',
                           't.title',
                           't.slug',
                           'SUM(p.hits) AS hits',
                           'COUNT(p.id) AS posts',
                           'CEIL(SUM(p.hits) / COUNT(p.id)) AS hits_post'
                       ])
                       ->join('posts p', 'p.topic_id = t.id', 'left')
                       ->where('t.id !=', 1)
                       ->groupBy('t.id')
                       ->orderBy('hits_post', 'DESC')
                       ->limit($limit)
                       ->get()->getResultArray();

    $sections = $this->db->table('sections s')
                            ->select([
                                's.id',
                                's.title',
                                's.slug',
                                'SUM(p.hits) AS hits',
                                'COUNT(p.id) AS pages',
                                'CEIL(SUM(p.hits) / COUNT(p.id)) AS hits_page'
                            ])
                            ->join('pages p', 'p.section_id = s.id', 'left')
                            ->where('s.id !=', 1)
                            ->groupBy('s.id')
                            ->orderBy('hits_page', 'DESC')
                            ->limit($limit)
                            ->get()->getResultArray();

    return [
        'topics'   => $topics,
        'sections' => $sections
    ];
}

/**
 * Gathers all system analytics data for the dashboard overview.
 *
 * Includes growth, content, usage, live stats, and system info.
 *
 * @return array  Full analytics overview
 */
public function getOverviewData() {
    $cacheKey = 'dashboard_overview_data';
    $cached   = cache($cacheKey);

    if ($cached !== null) {
        return $cached;
    }

    // Get total hits for posts and pages
    $postsHits = $this->db->table('posts')->selectSum('hits')->get()->getRow()->hits;
    $pagesHits = $this->db->table('pages')->selectSum('hits')->get()->getRow()->hits;

    // Get daily averages and visitor growth rates
    $avgData    = $this->getDailyAverages();
    $growthData = $this->getVisitorGrowthRates();

    // Get the number of active posts and pages
    $totalPosts = $this->db->table('posts')->countAll();
    $pages = $this->db->table('pages')->countAll();
    $publicPosts = $this->db->table('posts')->where('status', 1)->countAllResults();

    // Get the total word count for posts and pages
    $words = $this->db->query("SELECT (SELECT SUM(words) FROM posts) + (SELECT SUM(words) FROM pages) AS total")->getRow('total');

    // Get the number of photos and files
    $photos = count(glob(FCPATH . 'images' . DIRECTORY_SEPARATOR . '*.webp'));
    $files  = iterator_count(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(ROOTPATH, \FilesystemIterator::SKIP_DOTS)));

    // Get the earliest stats data date
    $statsDataSince = $this->db->table('stats')->select("DATE_FORMAT(MIN(created), '%d %b %Y') AS date", false)->get()->getRow('date');

    // Calculate total visitors (sum of 'cnt' from grouped 'created' data)
    $totalVisitors = array_sum(array_column(
        $this->db->table('stats')
                 ->selectCount('id', 'cnt')
                 ->groupBy('created')
                 ->orderBy('created', 'DESC')
                 ->get()->getResultArray()
    , 'cnt'));

    // Get the number of active members
    $members = 0; //$this->db->table('members')->where('status', 1)->countAllResults();

    // Get uptime days (difference between the earliest 'created' date and today for pages)
    $uptimeDays = $this->db->query("SELECT DATEDIFF(CURDATE(), MIN(created)) AS uptime_days FROM pages")->getRow()->uptime_days;

    // Get the date of the first post (excluding posts with id = 0)
    $firstPostDate = $this->db->table('posts')
                              ->select("DATE_FORMAT(MIN(created), '%d %b %Y') AS date", false)
                              ->where('id !=', 0)
                              ->get()->getRow('date');

    // Get the date of the latest post (excluding posts with id = 0)
    $latestPostDate = $this->db->table('posts')
                               ->select("DATE_FORMAT(MAX(created), '%d %b %Y') AS date", false)
                               ->where('id !=', 0)
                               ->get()->getRow('date');

    // Get the date of the first page
    $firstPageDate = $this->db->table('pages')
                              ->select("DATE_FORMAT(MIN(created), '%d %b %Y') AS date", false)
                              ->get()->getRow('date');

    // Get the date of the latest page
    $latestPageDate = $this->db->table('pages')
                               ->select("DATE_FORMAT(MAX(created), '%d %b %Y') AS date", false)
                               ->get()->getRow('date');

    // Awaiting Review
    $postsAwaiting = $this->db->table('posts')
                              ->where('review', 1)
                              ->countAllResults();
    $pagesAwaiting = $this->db->table('pages')
                              ->where('review', 1)
                              ->countAllResults();
    $awaitingReview = $postsAwaiting + $pagesAwaiting;

    // Session Files
    $sessionPath     = ROOTPATH . 'writable' . DIRECTORY_SEPARATOR . 'session' . DIRECTORY_SEPARATOR;
    $sessionFiles    = glob($sessionPath . '*');
    $sessionFilesCnt = count(array_filter($sessionFiles, 'is_file'));

    // Cache Files
    $cachePath     = ROOTPATH . 'writable' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
    $cacheFiles    = glob($cachePath . '*');
    $cacheFilesCnt = count(array_filter($cacheFiles, 'is_file'));

    // Averages
    $averages  = [
        'Visitors per Day'        => $avgData['visitors_avg'],
        'Visitors per Month'      => ($avgData['visitors_avg'] * 30),
        'Visitors per Year'       => ($avgData['visitors_avg'] * 365),
        'Hits per Day'            => $avgData['hits_avg'],
        'Hits per Month'          => ($avgData['hits_avg'] * 30),
        'Hits per Year'           => ($avgData['hits_avg'] * 365),
        'Impressions per Visitor' => ($totalVisitors > 0) ? number_format(($postsHits + $pagesHits) / $totalVisitors, 1) : '0'
    ];

    // Growth
    $growth = [
        'Total Views'                 => ($postsHits + $pagesHits),
        'Total Visitors'              => $totalVisitors,
        'Visitors (Recent 15 Days)'   => $growthData['recent'],
        'Visitors (Previous 15 Days)' => $growthData['previous'],
        'Growth Rate'                 => $growthData['rate'],
        'Statistical Data Since'      => $statsDataSince
    ];

    // Content
    $content = [
        'Total Posts'      => ($totalPosts - 1),
        'Public Posts'     => $publicPosts,
        'Pages'            => $pages,
        'Pages & Posts'    => ($totalPosts + $pages),
        'Words'                    => $words,
        'Equivalent Book Pages'    => ceil($words / 300),
        'First Post Date'  => $firstPostDate,
        'Latest Post Date' => $latestPostDate,
        'First Page Date'  => $firstPageDate,
        'Latest Page Date' => $latestPageDate,
        'Awaiting Review'  => $awaitingReview
    ];

    // Users
    $users = [
        'Users'                    => $this->db->table('users')->where('status', 1)->countAllResults(),
        'Members'                  => $members,
        'Estimated Monthly Profit' => '$' . ($members * 10),
        'Estimated Yearly Profit'  => '$' . ($members * 10 * 12)
    ];

    // System
    $system = [
        'Version'       => setting('system.version'),
        'Photos'        => $photos,
        'Session Files' => $sessionFilesCnt,
        'Cache Files'   => ($cacheFilesCnt - 1),
        'Total Files'   => $files,
        'Uptime'        => $uptimeDays . ' days'
    ];

    // Return
    $result = compact('averages', 'growth', 'content', 'users', 'system');

    cache()->save($cacheKey, $result, setting("cache.lifetime"));

    return $result;
}

/**
 * Calculates visitor growth rate between two recent 15-day periods.
 *
 * @return array  Recent and previous totals with growth percentage
 */
public function getVisitorGrowthRates(): array {
    // Last 15 days (excluding today)
    $recentVisitors = $this->db->table('stats')
                               ->selectCount('id', 'cnt')
                               ->groupBy('created')
                               ->orderBy('created', 'DESC')
                               ->limit(15, 1) // LIMIT 15 OFFSET 1
                               ->get()->getResultArray();

    // Previous 15 days
    $previousVisitors = $this->db->table('stats')
                                 ->selectCount('id', 'cnt')
                                 ->groupBy('created')
                                 ->orderBy('created', 'DESC')
                                 ->limit(15, 16) // LIMIT 15 OFFSET 16
                                 ->get()->getResultArray();

    $recentTotal   = array_sum(array_column($recentVisitors, 'cnt'));
    $previousTotal = array_sum(array_column($previousVisitors, 'cnt'));

    $rate = 0;
    if ($previousTotal > 0) {
        $rate = (($recentTotal - $previousTotal) / $previousTotal) * 100;
    }

    return [
        'recent'   => $recentTotal,
        'previous' => $previousTotal,
        'rate'     => round($rate, 1) . '%'
    ];
}

/**
 * Calculates daily average visitors and hits over a given time range.
 *
 * @param int $range  Number of days to average
 * @return array      Average stats
 */
public function getDailyAverages(int $range = 15): array {
    // Visitors per day (by counting ID rows)
    $visitorQuery = $this->db->table('stats')
                             ->selectCount('id', 'cnt')
                             ->groupBy('created')
                             ->orderBy('created', 'DESC')
                             ->limit($range, 1)
                             ->get()->getResultArray();

    $visitorSum = array_sum(array_column($visitorQuery, 'cnt'));

    // Hits per day (by summing hits column)
    $hitQuery = $this->db->table('stats')
                         ->selectSum('hits', 'cnt')
                         ->groupBy('created')
                         ->orderBy('created', 'DESC')
                         ->limit($range, 1)
                         ->get()->getResultArray();

    $hitSum = array_sum(array_column($hitQuery, 'cnt'));

    return [
        'visitors_avg' => ceil($visitorSum / $range),
        'hits_avg'     => ceil($hitSum / $range)
    ];
}

/**
 * Retrieves live analytics data for the current day.
 *
 * Includes active users, today's visitors, and hit count.
 *
 * @param int $intervalMinutes  Time window for active users
 * @return array                Live stats
 */
public function getLiveData($intervalMinutes = 10) {
    $usersOnline = $this->db->table('stats')
                            ->where('updated >=', "NOW() - INTERVAL {$intervalMinutes} MINUTE", false) // Crucial: false disables escaping
                            ->countAllResults(); // Executes COUNT(*) based on the WHERE clause

    $visitorsToday = $this->db->table('stats')
                              ->where('created', 'CURDATE()', false)
                              ->countAllResults(); // Efficiently counts rows matching the WHERE


    $hitsResult = $this->db->table('stats')
                           ->selectSum('hits', 'totalHits') // Select SUM(hits) aliased as totalHits
                           ->where('created', 'CURDATE()', false) // Same date condition
                           ->get()
                           ->getRow(); // Fetch the single row result

    $hitsToday = $hitsResult ? (int)$hitsResult->totalHits : 0;

    return compact('usersOnline', 'visitorsToday', 'hitsToday');
}

/**
 * Retrieves the number of posts and pages published per day.
 *
 * Includes data for the last X days and fills missing dates.
 *
 * @param int $limitDays  Number of days to include
 * @return array          Daily post and page creation counts
 */
public function getDailyCreationCounts(int $limitDays = 14): array {
    $daysToSubtract = $limitDays - 1;

    $postsFromDb  = $this->db->table('posts')
                             ->select("DATE_FORMAT(created, '%W, %d %b %Y') AS f_created, COUNT(*) AS cnt", false)
                             ->where('id !=', 0)
                             ->where('DATE(created) >=', "NOW() - INTERVAL {$daysToSubtract} DAY", false)
                             ->groupBy("DATE_FORMAT(created, '%W, %d %b %Y')")
                             ->get()->getResultArray();

    $pagesFromDb  = $this->db->table('pages')
                             ->select("DATE_FORMAT(created, '%W, %d %b %Y') AS f_created, COUNT(*) AS cnt", false)
                             ->where('DATE(created) >=', "NOW() - INTERVAL {$daysToSubtract} DAY", false)
                             ->groupBy("DATE_FORMAT(created, '%W, %d %b %Y')")
                             ->get()->getResultArray();

    // --- Fill missing days using PHP ---
    $postMap = array_column($postsFromDb, 'cnt', 'f_created');
    $pageMap = array_column($pagesFromDb, 'cnt', 'f_created');

    $finalPostCounts = [];
    $finalPageCounts = [];

    $endDate   = new \DateTime();
    $startDate = (new \DateTime())->sub(new \DateInterval("P{$daysToSubtract}D"));
    $interval  = new \DateInterval('P1D');
    $period    = new \DatePeriod($startDate, $interval, (clone $endDate)->add($interval));

    foreach ($period as $date) {
        $formattedDate = $date->format('l, d M Y');

        $finalPostCounts[] = [
            'label' => $formattedDate,
            'cnt'   => $postMap[$formattedDate] ?? '0'
        ];
        $finalPageCounts[] = [
            'label' => $formattedDate,
            'cnt'   => $pageMap[$formattedDate] ?? '0'
        ];
    }

    return [
        'Post Published'  => $finalPostCounts,
        'pages Published' => $finalPageCounts
    ];
}

/**
 * Formats an array of data for chart consumption.
 *
 * Allows customization of keys, limit, reversal, and output wrapping.
 *
 * @param array  $arr          Input data
 * @param string $labelKey     Key to use for labels
 * @param string $cntKey       Key to use for count
 * @param int    $limit        Max entries to include
 * @param bool   $reverse      Whether to reverse the array
 * @param string $encapsulate  Optional wrapper key for output
 * @return array               Chart-ready formatted data
 */
public function formatForChart(
    array $arr,
    string $labelKey,
    string $cntKey,
    int $limit = 0,
    bool $reverse = false,
    string $encapsulate = ''
    ): array {

    if (!is_array($arr) || !isset($arr[0][$labelKey], $arr[0][$cntKey])) {
        return $encapsulate ? [$encapsulate => []] : [];
    }

    $result = array_map(static function ($row) use ($labelKey, $cntKey) {
        return [
            'label' => $row[$labelKey] ?? 'Unknown',
            'cnt'   => (string)($row[$cntKey] ?? '0')
        ];
    }, $arr);

    if ($reverse) {
        $result = array_reverse($result);
    }

    if ($limit > 0) {
        $result = array_slice($result, 0, $limit);
    }

    return $encapsulate ? [$encapsulate => $result] : $result;
}

/**
 * Retrieves the trending posts based on hits recorded in the stats_trending table.
 *
 * Returns posts ordered by the number of hits in the last defined period,
 * including basic post information such as title, subtitle, hits, words,
 * and formatted creation date.
 *
 * @param int $limit The maximum number of posts to return.
 * @return array The list of trending posts with post details and trending hit counts.
 */
public function getTrendingPosts(int $limit = 20) {
    return $this->db->table('stats_trending s')
                    ->select('COUNT(s.post_id) AS trending_hits')
                    ->select('p.id, p.title, p.subtitle, p.hits, p.words')
                    ->select("DATE_FORMAT(p.created, '%d %b %Y') AS f_created", false)
                    ->join('posts p', 'p.id = s.post_id', 'left')
                    ->where('p.status', 1)
                    ->where('s.created >', 'DATE_SUB(NOW(), INTERVAL 10000 HOUR)', false)
                    ->groupBy('s.post_id')
                    ->orderBy('trending_hits', 'DESC')
                    ->limit($limit)
                    ->get()
                    ->getResultArray();
}

} // ─── End of Class ───

