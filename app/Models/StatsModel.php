<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * ****************************************************
 * Stats Model — VerdinCMS 2026 Edition
 * ****************************************************
 *
 * Responsible for recording, retrieving, and analyzing
 * visitor and usage statistics across the VerdinCMS platform.
 *
 * Version : VerdinCMS 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Notes:
 * - Supports IPv4 and IPv6 geolocation lookups.
 * - Caches location data to improve performance.
 * - Compatible with CodeIgniter 4.x and PHP 8.3.
 *
 * ****************************************************
 */

class StatsModel extends Model {

    // protected $db;

    // public function __construct() {
    //     $this->db = \Config\Database::connect();
    // }

/**
 * Tracks a visitor interaction with a specific post or page.
 *
 * This method performs geolocation testing, validates tracking conditions,
 * and updates hit counters and statistics accordingly.
 *
 * @param int    $id   The ID of the content being tracked (e.g., post or page).
 * @param string $type The type of content ('post' or 'page'). Defaults to 'post'.
 *
 * @return void
 *
 * @throws \Exception If an invalid type is provided.
 */
public function trackVisitor(int $id = 0, string $type = 'post'): void {
    if (!in_array($type, ['post', 'page'], true)) {
        log_message('error', "Invalid type passed to trackVisitor: {$type}");
        return;
    }

    $this->incrementHitCount($type, $id);
    $this->trackStats($type, $id);
}

/**
 * Increments the hit count for a specific post or page.
 *
 * Updates the 'hits' column in the appropriate table.
 *
 * @param string $type Either 'post' or 'page'.
 * @param int    $id   The ID of the content to increment.
 *
 * @return void
 */
private function incrementHitCount(string $type, int $id): void {
    $table = $type === 'page' ? 'pages' : 'posts';
    $this->db->table($table)
             ->set('hits', 'hits + 1', false)
             ->where('id', $id)
             ->update();
}

/**
 * Tracks detailed visitor statistics for a given content item.
 *
 * Collects user agent, IP, geolocation, platform, browser, and device type,
 * and stores this data into the stats system. Also registers the post for trending calculations.
 *
 * @param string $type The content type being tracked ('post' or 'page').
 * @param int    $id   The content ID (relevant for posts).
 *
 * @return void
 */
private function trackStats(string $type, int $id): void {
    $request = service('request');
    $agent   = $request->getUserAgent();

    $ip          = $request->getIPAddress() ?? '0.0.0.0';
    $isMobile    = (int) $agent->isMobile();
    $postId      = $type === 'post' ? $id : 0;
    $fingerprint = $this->generateFingerprint($agent, $ip);

    try {
        $this->insertOrUpdateStats([
            'ip'            => $ip,
            'fingerprint'   => $fingerprint,
            'os'            => $agent->getPlatform(),
            'browser'       => $agent->getBrowser(),
            'browser_ver'   => $agent->getVersion(),
            'country'       => 'Unknown',
            'country_code'  => 'XX',
            'is_mobile'     => $isMobile,
        ]);
    } catch (\Throwable $e) {
        log_message('error', 'Visitor tracking error: ' . $e->getMessage());
        return;
    }

    if ($postId > 0) {
        $this->registerTrendingPost($postId);
    }
}

/**
 * Generates a unique fingerprint for the visitor based on their user agent and IP address.
 *
 * This helps identify repeat visits while maintaining user privacy.
 *
 * @param \CodeIgniter\HTTP\UserAgent $agent The user agent object from the request.
 * @param string                      $ip     The visitor's IP address.
 *
 * @return string A 32-character MD5 hash fingerprint.
 */
private function generateFingerprint(\CodeIgniter\HTTP\UserAgent $agent, string $ip): string {
    return substr(md5($agent->getAgentString() . $ip), 0, 32);
}

/**
 * Inserts a new stats record or updates an existing one based on IP and fingerprint.
 *
 * Uses MySQL's `ON DUPLICATE KEY UPDATE` to increment the hit count and update the timestamp.
 *
 * @param array $data An associative array containing keys:
 *                    - ip
 *                    - fingerprint
 *                    - os
 *                    - browser
 *                    - browser_ver
 *                    - country
 *                    - country_code
 *                    - is_mobile
 *
 * @return void
 */
private function insertOrUpdateStats(array $data): void {
    $sql = "
        INSERT INTO stats (
            ip, fingerprint, os, browser, browser_ver,
            country, country_code, is_mobile
        ) VALUES (
            :ip:, :fingerprint:, :os:, :browser:, :browser_ver:,
            :country:, :country_code:, :is_mobile:
        )
        ON DUPLICATE KEY UPDATE
            hits = hits + 1,
            updated = NOW()
        ";

    $this->db->query($sql, $data);
}

/**
 * Registers a post as trending by inserting its ID into the stats_trending table.
 *
 * Errors are caught and logged without interrupting the user experience.
 *
 * @param int $postId The ID of the post to mark as trending.
 *
 * @return void
 */
private function registerTrendingPost(int $postId): void {
    try {
        $this->db->table('stats_trending')->insert(['post_id' => $postId]);
    } catch (\Throwable $e) {
        log_message('error', 'Trending insert error: ' . $e->getMessage());
    }
}

} // ─── End of Class ───

