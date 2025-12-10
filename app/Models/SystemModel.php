<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * ****************************************************
 * System Model — VerdinCMS 2026 Edition
 * ****************************************************
 *
 * Handles low-level system operations such as file cleanup,
 * versioning, maintenance tasks, and internal utilities.
 *
 * Version : VerdinCMS 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Notes:
 * - Optimized for safe background tasks and housekeeping routines.
 * - Fully compatible with CodeIgniter 4.x and PHP 8.3.
 *
 * ****************************************************
 */

class SystemModel extends Model {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

/**
 * Identifies orphaned image filenames.
 *
 * Compares image files on disk with those used in the database
 * (from both photo fields and embedded <img> tags in post/page bodies).
 *
 * @return array  Filenames (without extension) of unused images
 */
public function getOrphanPhotos(): array {
    $picsPath = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;

    // 1. Get all .webp image filenames on the server (without extension)
    $serverPics = glob($picsPath . '*.webp');
    $serverPics = array_map(fn($pic) => pathinfo($pic, PATHINFO_FILENAME), $serverPics);
    $serverPics = array_unique($serverPics);

    // 2. Get post photos (photo field + from body)
    $postPhotos     = array_unique($this->dbGetColumn('posts', 'photo', 'photo != ""'));
    $postBodies     = $this->dbGetColumn('posts', 'body', 'body LIKE "%<img%"');
    $postPhotosBody = [];

    foreach ($postBodies as $html) {
        foreach ($this->findPicsInHTML($html) as $src) {
            $postPhotosBody[] = pathinfo($src, PATHINFO_FILENAME);
        }
    }

    $postPhotosBody = array_unique($postPhotosBody);

    // 3. Get page photos (photo field + from body)
    $pagePhotos     = array_unique($this->dbGetColumn('pages', 'photo', 'photo != ""'));
    $pageBodies     = $this->dbGetColumn('pages', 'body', 'body LIKE "%<img%"');
    $pagePhotosBody = [];

    foreach ($pageBodies as $html) {
        foreach ($this->findPicsInHTML($html) as $src) {
            $pagePhotosBody[] = pathinfo($src, PATHINFO_FILENAME);
        }
    }

    $pagePhotosBody = array_unique($pagePhotosBody);

    // 4. Merge all used photos and remove duplicates
    $usedPhotos = array_unique(array_merge(
        $postPhotos,
        $postPhotosBody,
        $pagePhotos,
        $pagePhotosBody
    ));

    // 5. Return all photos on server that aren't used
    return array_diff($serverPics, $usedPhotos);
}

/**
 * Retrieves a single column of values from a database table.
 *
 * Optionally applies a WHERE clause to filter results.
 *
 * @param string $table   Table name
 * @param string $column  Column name to fetch
 * @param string $where   Optional WHERE condition
 * @return array          Flat array of column values
 */
private function dbGetColumn(string $table, string $column, string $where = ''): array {
    $builder = $this->db->table($table)->select($column);
    if ($where !== '') {
        $builder->where($where);
    }
    return array_column($builder->get()->getResultArray(), $column);
}

/**
 * Extracts image filenames from <img src="..."> tags in HTML.
 *
 * Returns only the basename (filename without path).
 *
 * @param string $html  HTML content to parse
 * @return array        List of image filenames
 */
private function findPicsInHTML($html) {
    $img_array = array();
    $doc = new \DOMDocument();
    @$doc->loadHTML($html);
    $tags = $doc->getElementsByTagName('img');

    foreach ($tags as $tag) {
       $path = $tag->getAttribute('src');
       array_push($img_array,basename($path));
    }
    return $img_array;
}

/**
 * Generates a complete SEO-friendly sitemap.xml file.
 *
 * Includes homepage, topics, pages, and posts with dynamic lastmod, priority, and changefreq values.
 *
 * @return void
 */
public function generateSitemap(): void {
    // --- SEO Change Frequencies ---
    $changeFreq = [
        'homepage' => 'daily',    // Homepage content updates frequently
        'topics'   => 'weekly',   // Topics may change with new posts
        'posts'    => 'weekly',   // Posts may be edited or refreshed
        'pages'    => 'monthly',  // Static pages change less frequently
    ];
    // --- SEO Priorities ---
    $priority = [
        'homepage' => '1.0', // Homepage: most important, updated often
        'topics'   => '0.8', // Category/topic listing pages
        'posts'    => '0.7', // Individual blog posts
        'pages'    => '0.6', // Static pages (about, contact, etc.)
    ];

    // Fetch content
    $posts  = $this->getSitemapData('posts');
    $pages  = $this->getSitemapData('pages');
    $topics = $this->getSitemapData('topics');

    $sitemapPath = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'sitemap.xml';
    $sitemapFile = fopen($sitemapPath, 'w') or die("Unable to open file!");

    $sm  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $sm .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Homepage
    $sm .= "
    <url>
        <loc>" . base_url() . "</loc>
        <lastmod>" . date('c') . "</lastmod>
        <changefreq>{$changeFreq['homepage']}</changefreq>
        <priority>{$priority['homepage']}</priority>
    </url>\n";

    // Topics
    foreach ($topics as $topic) {
        $sm .= "
    <url>
        <loc>" . site_url('topic/' . $topic['slug']) . "</loc>
        <lastmod>" . date('c') . "</lastmod>
        <changefreq>{$changeFreq['topics']}</changefreq>
        <priority>{$priority['topics']}</priority>
    </url>\n";
    }

    // Pages
    foreach ($pages as $page) {
        $sm .= "
    <url>
        <loc>" . site_url($page['s_slug'] . '/' . $page['slug']) . "</loc>
        <lastmod>" . date('c', strtotime($page['created'])) . "</lastmod>
        <changefreq>{$changeFreq['pages']}</changefreq>
        <priority>{$priority['pages']}</priority>
    </url>\n";
    }

    // Posts
    foreach ($posts as $post) {
        $sm .= "
    <url>
        <loc>" . site_url('post/' . $post['id']) . "</loc>
        <lastmod>" . date('c', strtotime($post['created'])) . "</lastmod>
        <changefreq>{$changeFreq['posts']}</changefreq>
        <priority>{$priority['posts']}</priority>
    </url>\n";
    }

    $sm .= '</urlset>';

    // Write plain XML
    fwrite($sitemapFile, $sm);
    fclose($sitemapFile);

    // Also create gzipped version
    $gzippedContent = gzencode($sm, 9); // Max compression
    file_put_contents(ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'sitemap.xml.gz', $gzippedContent);
}

/**
 * Fetches data for posts, pages, or topics for the sitemap.
 *
 * @param string $type 'posts', 'pages', or 'topics'
 * @return array
 */
private function getSitemapData(string $type): array {
    switch ($type) {
        case 'posts':
            return $this->db->table('posts p')
                            ->select('p.id, p.created')
                            ->where('p.status', 1)
                            ->where('p.accessibility', 0)
                            ->orderBy('p.created', 'DESC')
                            ->get()
                            ->getResultArray();

        case 'pages':
            return $this->db->table('pages p')
                            ->select('p.id, p.slug, p.created, s.slug AS s_slug')
                            ->join('sections s', 's.id = p.section_id', 'inner')
                            ->where('p.status', 1)
                            ->orderBy('p.created', 'DESC')
                            ->get()
                            ->getResultArray();

        case 'topics':
            return $this->db->table('topics t')
                            ->select('t.slug')
                            ->selectCount('p.topic_id', 'count')
                            ->join('posts p', 'p.topic_id = t.id', 'left')
                            ->where('p.status', 1)
                            ->groupBy('t.id')
                            ->having('count >', 0)
                            ->get()
                            ->getResultArray();

        default:
            return [];
    }
}

/**
 * Subscribe a user to the newsletter.
 *
 * Validates and sanitizes the provided email address,
 * checks for duplicates, generates a confirmation token,
 * and inserts a new record into the `newsletter` table.
 *
 * @param string $email User's email address.
 * @return array ['success' => bool, 'message' => string]
 */
public function subscribe(string $email): array {
    $email = trim(strtolower($email));

    // Validate email format
    if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            'success' => false,
            'message' => 'Μη έγκυρη διεύθυνση email.'
        ];
    }

    // Check if already subscribed
    $exists = $this->db->table('newsletter')
                       ->where('email', $email)
                       ->countAllResults();

    if ($exists > 0) {
        return [
            'success' => false,
            'message' => 'Αυτό το email είναι ήδη εγγεγραμμένο.'
        ];
    }

    // Generate confirmation token
    $token = bin2hex(random_bytes(16)); // 32-character secure token

    // Insert into DB
    $inserted = $this->db->table('newsletter')->insert([
        'email' => $email,
        'confirmation_token' => $token,
        'subscribed_at' => date('Y-m-d H:i:s'),
        'confirmed' => 0,
        'unsubscribed' => 0
    ]);

    if (! $inserted) {
        return [
            'success' => false,
            'message' => 'Η εγγραφή απέτυχε. Προσπάθησε ξανά.'
        ];
    }

    // TODO: Send confirmation email
    // e.g. $this->sendConfirmationEmail($email, $token);

    return [
        'success' => true,
        'message' => 'Ευχαριστούμε για την εγγραφή! Έλεγξε το email σου για επιβεβαίωση.'
    ];
}



} // ─── End of Class ───