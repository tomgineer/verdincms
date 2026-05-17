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
    $changeFreq = [
        'homepage' => 'daily',
        'topics'   => 'weekly',
        'posts'    => 'weekly',
        'pages'    => 'monthly',
    ];

    $priority = [
        'homepage' => '1.0',
        'topics'   => '0.8',
        'posts'    => '0.7',
        'pages'    => '0.6',
    ];

    $posts  = $this->getSitemapData('posts');
    $pages  = $this->getSitemapData('pages');
    $topics = $this->getSitemapData('topics');

    $lastmodDates = array_filter(array_merge(
        array_column($posts, 'lastmod'),
        array_column($pages, 'lastmod')
    ));
    $homepageLastmod = !empty($lastmodDates) ? max($lastmodDates) : date('Y-m-d H:i:s');

    $sm  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $sm .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    $sm .= $this->sitemapUrl(base_url(), $homepageLastmod, $changeFreq['homepage'], $priority['homepage']);

    foreach ($topics as $topic) {
        $sm .= $this->sitemapUrl(
            site_url('topic/' . $topic['slug']),
            $topic['lastmod'],
            $changeFreq['topics'],
            $priority['topics']
        );
    }

    foreach ($pages as $page) {
        $sm .= $this->sitemapUrl(
            site_url($page['s_slug'] . '/' . $page['slug']),
            $page['lastmod'],
            $changeFreq['pages'],
            $priority['pages']
        );
    }

    foreach ($posts as $post) {
        $sm .= $this->sitemapUrl(
            site_url('post/' . $post['id']),
            $post['lastmod'],
            $changeFreq['posts'],
            $priority['posts']
        );
    }

    $sm .= '</urlset>';

    $sitemapPath = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'sitemap.xml';
    if (file_put_contents($sitemapPath, $sm, LOCK_EX) === false) {
        throw new \RuntimeException('Unable to write sitemap.xml');
    }

    $gzippedContent = gzencode($sm, 9);
    if ($gzippedContent === false) {
        throw new \RuntimeException('Unable to compress sitemap.xml');
    }

    if (file_put_contents(ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'sitemap.xml.gz', $gzippedContent, LOCK_EX) === false) {
        throw new \RuntimeException('Unable to write sitemap.xml.gz');
    }
}

/**
 * Builds one escaped sitemap URL entry.
 */
private function sitemapUrl(string $url, ?string $lastmod, string $changefreq, string $priority): string {
    return "    <url>\n"
        . '        <loc>' . $this->sitemapEscape($url) . "</loc>\n"
        . '        <lastmod>' . $this->sitemapLastmod($lastmod) . "</lastmod>\n"
        . '        <changefreq>' . $this->sitemapEscape($changefreq) . "</changefreq>\n"
        . '        <priority>' . $this->sitemapEscape($priority) . "</priority>\n"
        . "    </url>\n";
}

/**
 * Formats database dates as W3C datetime values accepted by sitemaps.
 */
private function sitemapLastmod(?string $date): string {
    $timestamp = $date ? strtotime($date) : false;

    return date('c', $timestamp ?: time());
}

/**
 * Escapes text for XML nodes.
 */
private function sitemapEscape(string $value): string {
    return htmlspecialchars($value, ENT_XML1 | ENT_COMPAT, 'UTF-8');
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
                            ->select('p.id, p.created AS lastmod')
                            ->where('p.status', 1)
                            ->where('p.accessibility', 0)
                            ->where('p.unlisted !=', 1)
                            ->orderBy('p.created', 'DESC')
                            ->get()
                            ->getResultArray();

        case 'pages':
            return $this->db->table('pages p')
                            ->select('p.id, p.slug, p.created AS lastmod, s.slug AS s_slug')
                            ->join('sections s', 's.id = p.section_id', 'inner')
                            ->where('p.status', 1)
                            ->where('p.accessibility', 0)
                            ->where('s.id !=', 1)
                            ->orderBy('p.created', 'DESC')
                            ->get()
                            ->getResultArray();

        case 'topics':
            return $this->db->table('topics t')
                            ->select('t.slug')
                            ->selectCount('p.topic_id', 'count')
                            ->selectMax('p.created', 'lastmod')
                            ->join('posts p', 'p.topic_id = t.id AND p.status = 1 AND p.accessibility = 0 AND p.unlisted != 1', 'inner')
                            ->where('t.id !=', 1)
                            ->groupBy('t.id, t.slug')
                            ->having('count >', 0)
                            ->get()
                            ->getResultArray();

        default:
            return [];
    }
}

} // ─── End of Class ───
