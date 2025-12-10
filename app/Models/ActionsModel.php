<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\SystemModel;
use App\Libraries\OpenAIService;

/**
 * ****************************************************
 * Actions Model — VerdinCMS 2026 Edition
 * ****************************************************
 *
 * Responsible for managing all database operations related to actions,
 * including creation, updates, and internal system maintenance routines.
 *
 * Version : VerdinCMS 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Notes:
 * - Optimized and refactored for the 2025 application architecture.
 * - Fully compatible with CodeIgniter 4.x and PHP 8.3.
 *
 * ****************************************************
 */

class ActionsModel extends Model {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

/**
 * Executes a system-defined action by name.
 *
 * Used for maintenance tasks, testing sessions, cleanup operations,
 * and utilities such as cache clearing or cron triggers.
 *
 * @param string $action  The action identifier to run
 * @return array          Status and result metadata
 */
 public function runAction($action) {
    $status = null;

    try {
        switch ($action) {
            case 'incrementVersion':
                $this->updateVersion();
                cache()->clean();
                break;
            case 'generateRobots':
                $this->genRobotsTxt();
                break;
            case 'photosToPlaceholders':
                $this->photosToPlaceholders();
                break;
            case 'resetTrending':
                $this->db->table('stats_trending')->set('created', 'NOW()', false)->update();
                break;
            case 'emptyCronLog':
                $this->db->table('cron_log')->truncate();
                break;
            case 'clearErrorLogFiles':
                array_map('unlink', glob(WRITEPATH . 'logs/*.log'));
                break;
            case 'clearCache':
                cache()->clean();
                break;
            case 'runCron':
                $this->runCron();
                break;
            case 'testMember':
                session()->set(['firstname'=>'Test','lastname'=>'Member','tier'=>1]);
                $status = 'redirect';
                break;
            case 'testWriter':
                session()->set(['firstname'=>'Test','lastname'=>'Writer','tier'=>9]);
                $status = 'redirect';
                break;
            case 'removeDeletedUsers':
                $this->db->table('users')->where('status', 0)->delete();
                break;
            case 'removeDeletedPosts':
                $this->db->table('posts')->where('status', 3)->delete();
                break;
            case 'removeDeletedPages':
                $this->db->table('pages')->where('status', 3)->delete();
                break;
            case 'removeOrphanPhotos':
                $this->removeOrphanPhotos();
                break;
            case 'clearSessionFiles':
                $this->deleteOldSessionFiles();
                break;
            case 'generateSitemap':
                (new SystemModel())->generateSitemap();
                break;
            case 'updateTopicsPostCount':
               $this->updateTopicsPostCount();
                break;
            case 'systemMaintenance':
               $this->systemMaintenance();
                break;
            case 'optimizeStatsTables':
               $this->optimizeStatsTables();
                break;
            case 'updatePopularContent':
               $this->updatePopularContent();
                break;
            case 'removeOrphanBlockImages':
               $this->removeOrphanBlockImages();
                break;
            case 'removeOrphanAvatars':
               $this->removeOrphanAvatars();
                break;
            default:
                break;
        }

        return [
            'status' => $status ?? 'Completed',
            'action' => $action
        ];
    } catch (\Throwable $th) {
        return [
            'status'  => 'error',
            'message' => $th->getMessage(),
            'file'    => $th->getFile(),
            'line'    => $th->getLine()
        ];
    }
}

/**
 * Increments the system version by 1 on the patch segment (e.g., 7.1.31 → 7.1.32).
 *
 * @return bool True on success, false on failure
 */
function updateVersion(): bool {
    $path = ROOTPATH . 'config/settings.json';

    if (!is_file($path)) {
        return false;
    }

    $json = file_get_contents($path);
    $settings = json_decode($json, true);

    if (!isset($settings['system']['version'])) {
        return false;
    }

    $version = $settings['system']['version'];
    $segments = explode('.', $version);

    // Ensure it has at least 3 segments (major.minor.patch)
    while (count($segments) < 3) {
        $segments[] = '0';
    }

    // Increment the patch segment
    $segments[2] = (string)((int)$segments[2] + 1);

    $settings['system']['version'] = implode('.', $segments);

    // Encode JSON with pretty-print and write it back
    $encoded = json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    return file_put_contents($path, $encoded) !== false;
}


/**
 * Generates or overwrites the robots.txt file.
 *
 * Allows whitelisted bots and links to the sitemap.xml.
 * Blocks all others.
 * Outputs the file in the public directory.
 *
 * @return void
 */
private function genRobotsTxt(): void {
    $robotsPath = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'robots.txt';
    $robotsFile = fopen($robotsPath, 'w') or die('Unable to open file!');
    $base = base_url();

    $content  = "# Allow all bots\n";
    $content .= "User-agent: *\n";
    $content .= "Allow: /\n\n";

    $content .= "# Sitemap Links\n";
    $content .= "Sitemap: {$base}sitemap.xml\n";
    $content .= "Sitemap: {$base}sitemap.xml.gz\n";

    fwrite($robotsFile, $content);
    fclose($robotsFile);
}

/**
 * Sets a placeholder image for all posts and pages.
 *
 * Uses the first available .webp image in the public/images directory.
 * If no images are found, the photo field is reset to an empty string.
 *
 * @return void
 */
private function photosToPlaceholders():void {
    $images_path = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;

    // Find all .webp files in the directory
    $webp_files = glob($images_path . '*.webp');

    // Set the photo field for posts
    if (!empty($webp_files)) {
        $first_webp_file = $webp_files[0];
        $filename = pathinfo($first_webp_file, PATHINFO_FILENAME); // Get filename without extension
        $this->db->table('posts')->update(['photo' => $filename]);
        $this->db->table('pages')->update(['photo' => $filename]);
    } else {
        // Reset photo field for posts and pages
        $this->db->table('posts')->update(['photo' => '']);
        $this->db->table('pages')->update(['photo' => '']);
    }
}

/**
 * Deletes orphaned image files from the public/images directories.
 *
 * Removes full-size, thumbnail (tn), and extra-small (xs) versions
 * of images that are no longer referenced in posts or pages.
 *
 * @return void
 */
private function removeOrphanPhotos():void {
    $pics_path    = ROOTPATH.'public'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR;
    $pics_tn_path = $pics_path.'tn'.DIRECTORY_SEPARATOR;
    $pics_xs_path = $pics_path.'xs'.DIRECTORY_SEPARATOR;

    $orphanPhotos = (new SystemModel())->getOrphanPhotos();
    foreach ($orphanPhotos as $pic) {
        array_map('unlink', glob($pics_path . $pic . '.*'));
        array_map('unlink', glob($pics_tn_path . $pic .'.*'));
        array_map('unlink', glob($pics_xs_path . $pic .'.*'));
    }
}

/**
 * Deletes session files older than a given number of days.
 *
 * @param int $days  Number of days to keep (default: 2)
 * @return void
 */
private function deleteOldSessionFiles($days = 2): void {
    $session_path = ROOTPATH . 'writable' . DIRECTORY_SEPARATOR . 'session' . DIRECTORY_SEPARATOR;
    $files        = glob($session_path . '*');
    $now          = time();

    foreach ($files as $file) {
        if (is_file($file) && ($now - filemtime($file) >= 60 * 60 * 24 * $days)) {
            unlink($file);
        }
    }
}

/**
 * Updates the post count for each topic in the database.
 *
 * Counts the number of posts associated with each topic and
 * updates the 'posts' field in the 'topics' table using batch update.
 *
 * @return void
 */
private function updateTopicsPostCount():void {
    $updateData = $this->db->table('topics t')
                           ->select('t.id, COUNT(p.topic_id) AS posts')
                           ->join('posts p', 't.id = p.topic_id', 'left')
                           ->groupBy('t.id')
                           ->get()
                           ->getResultArray();

    if (!empty($updateData)) {
        $this->db->table('topics')->updateBatch($updateData, 'id');
    }
}

/**
 * Executes core system maintenance operations.
 *
 * This includes scheduled cleanup tasks such as:
 * - Running the cron job
 * - Removing orphaned photos, and users
 * - Deleting soft-deleted posts and pages
 *
 * Intended for internal use, typically run manually or via background processes.
 *
 * @return void
 */
private function systemMaintenance(): void {
    // Run all cron-based maintenance tasks
    $this->runCron();

    // Delete orphaned photos not referenced in posts/pages
    $this->removeOrphanPhotos();

    // Delete orphaned photos not referenced in blocks
    $this->removeOrphanBlockImages();

    // Delete orphaned avatars not referenced in users
    $this->removeOrphanAvatars();

    // Remove soft-deleted users
    $this->db->table('users')->where('status', 0)->delete();

    // Remove soft-deleted posts and pages
    $this->db->table('posts')->where('status', 3)->delete();
    $this->db->table('pages')->where('status', 3)->delete();

    // Clear Cache
    cache()->clean();
}

/**
 * Runs scheduled system maintenance tasks (cron).
 *
 * This includes:
 * - Optimizing analytics-related tables
 * - Regenerating the sitemap
 * - Updating popular content metrics
 * - Recounting posts per topic
 * - Clearing the cron log
 * - Deleting expired session files
 * - Logging the cron execution
 *
 * @param string $type  Identifier for the cron trigger type (default: 'Manualy')
 * @return void
 */
public function runCron(string $type = 'Manualy'): void {

    if (is_cli()) {
        $this->applyTimezone(); // Only apply timezone in CLI context
    }

    // Optimize stats and trending tables
    $this->optimizeStatsTables();

    // Regenerate sitemap.xml and sitemap.xml.gz
    (new SystemModel())->generateSitemap();

    // Update popular post metrics in stats_popular
    $this->updatePopularContent();

    // Refresh post counts in topics table
    $this->updateTopicsPostCount();

    // Delete cron log entries older than 2 weeks
    $this->db->table('cron_log')->where('created <', 'NOW() - INTERVAL 14 DAY', false)->delete();

    // Delete old session files
    $this->deleteOldSessionFiles();

    // Log successful cron run
    $this->db->table('cron_log')->insert(['type' => $type, 'log' => 'Success']);
}

private function applyTimezone(): void {
    $tz = new \DateTimeZone(config('App')->appTimezone);
    $now = new \DateTime('now', $tz);
    $offsetFormatted = sprintf('%+03d:00', $tz->getOffset($now) / 3600);
    $this->db->query("SET time_zone = '{$offsetFormatted}'");
}

/**
 * Deletes old records from the stats and stats_trending tables.
 *
 * - Removes stats older than the given number of days.
 * - Removes stats_trending entries older than the given number of hours.
 *
 * @param int $days   Number of days to keep in stats table (default: 45)
 * @param int $hours  Number of hours to keep in stats_trending table (default: 6)
 * @return void
 */
private function optimizeStatsTables(int $days = 45, int $hours = 6): void {
    // Delete old stats
    $this->db->table('stats')
             ->where("created <", "CURDATE() - INTERVAL {$days} DAY", false)
             ->delete();

    // Delete old trending stats
    $this->db->table('stats_trending')
             ->where("created <", "NOW() - INTERVAL {$hours} HOUR", false)
             ->delete();
}

/**
 * Rebuilds the stats_popular table based on recent post performance.
 *
 * Calculates average hits per day for posts within a specific age range
 * (between $threshold and $days old), and stores the top $limit entries
 * in the stats_popular table for use in analytics or recommendations.
 *
 * @param int $days      Maximum age of posts in days to include (default: 90)
 * @param int $threshold Minimum age of posts in days to exclude very recent ones (default: 7)
 * @param int $limit     Maximum number of top-performing posts to store (default: 100)
 * @return void
 */
private function updatePopularContent(int $days = 365, int $threshold = 7, int $limit = 100): void {
    // Get posts within date range and calculate hits per day
    $posts = $this->db->table('posts p')
                      ->select([
                          'p.id AS post_id',
                          'p.hits / DATEDIFF(CURRENT_DATE, p.created) AS hits_per_day'
                      ], false)
                      ->where('p.status', 1)
                      ->where('p.accessibility', 0)
                      ->where('p.unlisted', 0)
                      ->where("DATEDIFF(CURRENT_DATE, p.created) >=", $threshold, false)
                      ->where("DATEDIFF(CURRENT_DATE, p.created) <=", $days, false)
                      ->orderBy('hits_per_day', 'DESC')
                      ->limit($limit)
                      ->get()
                      ->getResultArray();

    // Clear and repopulate the stats_popular table
    $builder = $this->db->table('stats_popular');
    $builder->truncate();

    if (!empty($posts)) {
        $builder->insertBatch($posts);
    }
}

/**
 * Removes orphan block images from the filesystem.
 *
 * This function compares the block images stored on the server with the image and background
 * fields currently used in the database (blocks table). Any images (including all extensions)
 * that are not referenced are considered orphaned and will be deleted. Thumbnail versions
 * (located in the "tn" subfolder) are also removed if orphaned.
 *
 * @return void
 */
private function removeOrphanBlockImages(): void {
    $pics_path = FCPATH . 'images' . DIRECTORY_SEPARATOR . 'blocks' . DIRECTORY_SEPARATOR;
    $pics_tn_path = $pics_path . 'tn' . DIRECTORY_SEPARATOR;

    // Photos on Server
    $server_pics = glob($pics_path . '*');
    $server_pics = array_map(fn($pic) => pathinfo($pic, PATHINFO_BASENAME), $server_pics);
    $server_pics = array_unique($server_pics);

    // Block images from DB
    $block_pics_data = $this->db->table('blocks')
                                ->select('image, background')
                                ->where('image !=', '')
                                ->orWhere('background !=', '')
                                ->get()->getResultArray();
    $images = array_column($block_pics_data, 'image');
    $backgrounds = array_column($block_pics_data, 'background');
    $block_pics = array_unique(array_filter(array_merge($images, $backgrounds)));

    // Remove Unused Pics
    $orphanPhotos = array_diff($server_pics, $block_pics);

    try {
        foreach ($orphanPhotos as $pic) {
            $base_name = pathinfo($pic, PATHINFO_FILENAME);

            // Delete all matching files in main and tn folders
            array_map('unlink', array_filter(glob($pics_path . $base_name . '.*'), 'is_file'));
            array_map('unlink', array_filter(glob($pics_tn_path . $base_name . '.*'), 'is_file'));
        }
    } catch (\Throwable $e) {
        log_message('error', 'An error occurred while deleting unused block images: ' . $e->getMessage());
    }
}

/**
 * Removes orphan avatar images from the filesystem.
 *
 * This function checks the avatars stored on the server and compares them to the avatars
 * currently used in the database (users table). Any avatar files (including all extensions)
 * that are not associated with a user are considered orphaned and will be deleted.
 * Thumbnail versions (located in the "tn" subfolder) are also removed if orphaned.
 *
 * @return void
 */
private function removeOrphanAvatars(): void {
    $pics_path = FCPATH . 'images' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR;
    $pics_tn_path = $pics_path . 'tn' . DIRECTORY_SEPARATOR;

    // Photos on Server
    $server_pics = glob($pics_path . '*');
    $server_pics = array_map(fn($pic) => pathinfo($pic, PATHINFO_BASENAME), $server_pics);
    $server_pics = array_unique($server_pics);

    // Avatar Pics from DB
    $avatar_pics_data = $this->db->table('users')
                                 ->select('avatar')
                                 ->where('avatar !=', '')
                                 ->get()->getResultArray();
    $avatar_pics = array_unique(array_filter(array_column($avatar_pics_data, 'avatar')));

    // Remove Unused Pics
    $orphanPhotos = array_diff($server_pics, $avatar_pics);

    try {
        foreach ($orphanPhotos as $pic) {
            $base_name = pathinfo($pic, PATHINFO_FILENAME);

            // Delete all matching files in main and tn folders
            array_map('unlink', array_filter(glob($pics_path . $base_name . '.*'), 'is_file'));
            array_map('unlink', array_filter(glob($pics_tn_path . $base_name . '.*'), 'is_file'));
        }
    } catch (\Throwable $e) { // better to catch all errors, not only Exception
        log_message('error', 'An error occurred while deleting unused avatar pics: ' . $e->getMessage());
    }
}

/**
 * Sanitizes and formats a string response:
 * - Removes HTML tags and Markdown links
 * - Cleans up whitespace and empty parentheses
 * - Converts into formatted paragraphs
 *
 * @param string|null $str  The input string to sanitize.
 * @return string           Cleaned and HTML-formatted response.
 */
private function sanitizeResponse(?string $str): string {
    if ($str === null || trim($str) === '') {
        return '';
    }

    // Remove all HTML tags
    $str = strip_tags($str);

    // Remove Markdown-style links: [text](url)
    $str = preg_replace('/\[[^\]]*]\([^)]+\)/', '', $str);

    // Remove empty parentheses and surrounding space
    $str = preg_replace('/\s*\(\s*\)/', '', $str);

    // Normalize whitespace
    $str = trim(preg_replace('/\s+/', ' ', $str));

    return $this->splitParagraph($str, 3);
}

/**
 * Splits a paragraph into a specified number of parts, each ending at the nearest sentence-ending punctuation
 * (., !, or ?), and wraps each part in a <p> tag.
 *
 * If no punctuation is found or the number of parts is less than 2, the entire text is returned in a single <p>.
 *
 * @param string $text   The input paragraph to split.
 * @param int    $parts  The number of paragraph chunks to create (minimum 1).
 *
 * @return string        HTML string with each part wrapped in <p> tags.
 */
function splitParagraph(string $text, int $parts = 2): string {
    preg_match_all('/[.!?]/', $text, $m, PREG_OFFSET_CAPTURE);
    if ($parts < 2 || !$m[0]) return "<p>" . trim($text) . "</p>";

    $len = strlen($text);
    $pos = array_map(fn($x) => $x[1] + 1, $m[0]);
    $cuts = [];

    for ($i = 1; $i < $parts; $i++) {
        $target = $len * $i / $parts;
        $cuts[] = array_reduce($pos, fn($c, $p) =>
            (!$c || abs($p - $target) < abs($c - $target)) && !in_array($p, $cuts) ? $p : $c);
    }

    sort($cuts);
    $out = [];
    $start = 0;

    foreach ($cuts as $cut) {
        $out[] = "<p>" . trim(substr($text, $start, $cut - $start)) . "</p>";
        $start = $cut;
    }

    $out[] = "<p>" . trim(substr($text, $start)) . "</p>";
    return implode('', $out);
}

} // ─── End of Class ───