<?php namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\SystemCore;

/**
 * ****************************************************
 * Content Model — VerdinCMS 2026 Edition
 * ****************************************************
 *
 * Handles all database operations related to content,
 * including pages, posts, topics, and associated metadata.
 * Supports querying, filtering, and grouping logic used
 * across public and administrative interfaces.
 *
 * Version : VerdinCMS 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Notes:
 * - Optimized for scalable content retrieval and SEO features.
 * - Fully compatible with CodeIgniter 4.x and PHP 8.3.
 *
 * ****************************************************
 */

class ContentModel extends Model {

    protected $db;

    public function __construct() {
        $this->db   = \Config\Database::connect();
    }

/**
 * Fetches posts with optional filtering, sorting, and pagination.
 *
 * @param int $amount       Number of posts per page
 * @param int $topic_id     Optional topic ID to filter by
 * @param int $user_id      Optional user ID to filter by
 * @param int $page         Page number for pagination
 * @param bool $pagination  Whether to include pagination logic
 * @param bool $featured    Whether to fetch only featured posts
 * @param bool $unlisted    Whether to include unlisted posts
 * @return array            ['posts' => array, 'pagination' => array (optional)]
 */
public function getPosts(
    int $amount = MAX_POSTS,
    int $topic_id = 0,
    int $user_id = 0,
    int $page = 1,
    int $status = 1,
    bool $pagination = false,
    bool $featured = false,
    bool $unlisted = true,
    bool $review = false
) : array {
    $tier = tier(); // Access level of the current session user
    $builder = $this->db->table('posts p');
    $builder->join('users u', 'u.id = p.user_id');
    $builder->join('topics t', 't.id = p.topic_id');

    // Basic post fields
    $builder->select('p.id, p.title, p.photo');
    $builder->select('DATE_FORMAT(p.created, "%b %d, %Y") AS f_created', false);
    $builder->select('CONCAT(u.first_name, " ", u.last_name) AS author', false);
    $builder->select('u.author AS author_handle');
    $builder->select('t.title AS topic, t.slug AS topic_slug');

    // Filter by status; limit visibility to current user's tier if status is public
    $review ? $builder->whereIn('p.status', [1, 2]) : $builder->where('p.status', $status);
    if ($status === 1) $builder->where('p.accessibility <=', $tier);

    // Apply optional filters
    if ($topic_id) $builder->where('p.topic_id', $topic_id);
    if ($user_id)  $builder->where('p.user_id', $user_id);
    if ($featured) $builder->where('p.featured', 1);
    if ($unlisted) $builder->where('p.unlisted !=', 1);
    if ($review)   $builder->where('p.review', 1);

    // Apply sorting
    $featured ? $builder->orderBy('RAND()') : $builder->orderBy('p.created', 'DESC');

    // Handle pagination
    if ( $pagination ) {
        $totalRecordsQuery = clone $builder;
        $totalRecords = $totalRecordsQuery->countAllResults(false);
        $totalPages = (int) ceil($totalRecords / $amount);
        $offset = ($page > 1) ? ($page - 1) * $amount : 0;
        $builder->limit($amount, $offset);

        $postData['pagination'] = [
            'page'         => $page,
            'older_exists' => $page < $totalPages,
            'newer_exists' => $page > 1
        ];

    } else {
        $builder->limit($amount); // fallback limit if not paginating
    }

    // Fetch and return posts
    $postData['posts'] = $builder->get()->getResultArray();
    return $postData;
}

/**
 * Gets related posts by topic, excluding the given post.
 * If not enough found, fills with posts from other topics.
 *
 * @param int $id        ID of the current post to exclude.
 * @param int $topic_id  Topic ID to prioritize.
 * @param int $amount    Max number of posts to return.
 *
 * @return array         List of related posts.
 */
public function getRelatedPosts(int $id, int $topic_id, int $amount = 10) {
    $tier = tier(); // Access level of the current session user

    $builder = $this->db->table('posts p')
                        ->join('users u', 'u.id = p.user_id')
                        ->join('topics t', 't.id = p.topic_id')
                        ->select('p.id, p.title')
                        ->select('DATE_FORMAT(p.created, "%b %d, %Y") AS f_created', false)
                        ->select('CONCAT(u.first_name, " ", u.last_name) AS author', false)
                        ->select('u.author AS author_handle')
                        ->select('t.title AS topic, t.slug AS topic_slug')
                        ->where('p.id !=', $id)
                        ->where('p.status', 1)
                        ->where('p.accessibility <=', $tier)
                        ->orderBy('RAND()');

    // Clone the builder before adding the topic-specific condition
    $clonedBuilder = clone $builder;

    // First try: same topic
    $result = $builder->where('p.topic_id', $topic_id)
                      ->limit($amount)
                      ->get()
                      ->getResultArray();

    $found = count($result);

    if ($found >= $amount) {
        return $result;
    }

    // Fallback: fetch from other topics, excluding already fetched IDs
    $existingIds = array_column($result, 'id');
    $remaining = $amount - $found;

    if (!empty($existingIds)) {
        $clonedBuilder->whereNotIn('p.id', $existingIds);
    }

    $fallback = $clonedBuilder->limit($remaining)->get()->getResultArray();

    return array_merge($result, $fallback);
}


/**
 * Retrieves a single post with author and topic details, formatted and filtered by access level.
 *
 * @param int $id The ID of the post to retrieve.
 * @return array|null The post data as an associative array, or null if not found or inaccessible.
 */
public function getSinglePost(int $id): ?array {
    $tier = tier();

    return $this->db->table('posts p')
                    ->select([
                        'p.*',
                        "DATE_FORMAT(p.created, '%b %d, %Y') as f_created",
                        'CONCAT(u.first_name, " ", u.last_name) as author',
                        't.id as topic_id',
                        't.title as topic',
                        't.slug as topic_slug',
                        'u.author as user_handle',
                        'u.avatar'
                    ])
                    ->join('users u', 'p.user_id = u.id')
                    ->join('topics t', 'p.topic_id = t.id')
                    ->where('p.id', $id)
                    ->where('p.accessibility <=', $tier)
                    ->get()->getRowArray();
}

/**
 * Retrieves ranked posts based on popularity or trending activity.
 *
 * @param int    $amount     Number of posts to retrieve (defaults to all).
 * @param string $type       Type of ranking ('popular' or 'trending').
 * @param int    $page       Current page number for pagination.
 * @param bool   $pagination Whether to apply pagination.
 *
 * @return array Ranked posts and pagination metadata (if applicable).
 */
public function getRankingPosts(
    int $amount = MAX_POSTS,
    string $type = 'popular',
    int $page = 1,
    bool $pagination = true
): array {
    $tier = tier();
    $builder = $this->db->table('posts p');

    // Select core fields
    $builder->select('p.id, p.title, p.subtitle, p.photo')
            ->select('DATE_FORMAT(p.created, "%b %d, %Y") AS f_created', false)
            ->select('CONCAT(u.first_name, " ", u.last_name) AS author', false)
            ->select('u.author AS author_handle')
            ->select('t.title AS topic, t.slug AS topic_slug')
            ->where('p.status', 1)
            ->where('p.accessibility <=', $tier)
            ->join('users u', 'u.id = p.user_id')
            ->join('topics t', 't.id = p.topic_id');

    // Apply ranking logic
    switch ($type) {
        case 'popular':
            $builder->join('stats_popular s', 's.post_id = p.id', 'inner');
            if ($pagination) {
                $totalRecordsQuery = clone $builder;
            }
            $builder->orderBy('s.hits_per_day', 'DESC');
            break;
        case 'trending':
            $hours = setting('trending_range') ?? 24;
            $builder->join('stats_trending s', 's.post_id = p.id', 'inner')
                    ->where('s.created >=', "DATE_SUB(NOW(), INTERVAL {$hours} HOUR)", false)
                    ->groupBy('s.post_id');
            if ($pagination) {
                $totalRecordsQuery = clone $builder;
            }
            $builder->orderBy('COUNT(s.id)', 'DESC');
            break;
    }

    // Apply limit and offset
    $offset = ($page - 1) * $amount;
    $builder->limit($amount, $offset);

    $postData['posts'] = $builder->get()->getResultArray();

    // If trending and empty, extend the trending range
    if ( $type==='trending' && empty($postData['posts']) ) {
        $this->db->table('settings')->where('setting', 'trending_range')->update(['value' => '720']);
    }

    // Add pagination metadata
    if ( $pagination ) {
        $totalRecords = $totalRecordsQuery->countAllResults();

        // Prepare response data
        $postData = array_merge($postData, [
            'post_cur_min' => min(($page - 1) * $amount + 1, $totalRecords),
            'post_cur_max' => min($page * $amount, $totalRecords),
            'post_max'     => $totalRecords,
            'page_cur'     => $page,
            'page_max'     => max(ceil($totalRecords / $amount), 1),
            'prev'         => $page - 1,
            'next'         => $page + 1
        ]);
    }

    return $postData;
}

/**
 * Retrieves all public pages grouped by their section.
 *
 * Queries the `pages` and `sections` tables for active, public-facing pages
 * and organizes them into groups based on their section titles.
 *
 * @return array An associative array of pages grouped by section title.
 */
public function getPagesList(): array {
    $tier = tier();
    $results = $this->db->table('pages p')
                        ->select('s.title AS section, s.slug AS s_slug, p.label, p.slug, p.icon')
                        ->join('sections s', 's.id = p.section_id', 'inner')
                        ->where('p.status', 1)
                        ->where('p.accessibility', 0)
                        ->where('s.id !=', 1)
                        ->orderBy('s.position ASC, p.position ASC')
                        ->get()->getResultArray();
    $core = new SystemCore();
    $grouped_results =  $core->arrayGroupBy($results, 'section');

    return $grouped_results;
}

/**
 * Returns featured pages and topics for menu display.
 *
 * Pages:
 * - Active, public, featured, and not in section ID 1
 * - Includes label, slug, and section slug (s_slug)
 *
 * Topics:
 * - Featured only
 * - Includes title and slug
 *
 * @return array{pages: array<int, array{label: string, slug: string, s_slug: string}>, topics: array<int, array{title: string, slug: string}>}|null
 */
public function getMenuItems(): ?array {
    $pages = $this->db->table('pages p')
                      ->select('p.label, p.slug, s.slug AS s_slug')
                      ->join('sections s', 's.id = p.section_id', 'inner')
                      ->where('p.status', 1)
                      ->where('p.accessibility', 0)
                      ->where('p.featured', 1)
                      ->where('s.id !=', 1)
                      ->orderBy('p.position ASC')
                      ->get()->getResultArray();

    $topics = $this->db->table('topics')
                       ->select('title, slug')
                       ->where('featured', 1)
                       ->orderBy('position ASC')
                       ->get()->getResultArray();

    return compact('pages', 'topics');

}

/**
 * Retrieves a list of pages based on filters like section, featured status, or exclusion.
 *
 * @param bool        $featured    Whether to include only featured pages.
 * @param string|null $section     The slug of the section to filter by (optional).
 * @param int         $section_id  The numeric ID of the section to filter by.
 * @param int         $amount      The number of results to return.
 * @param int         $exclude     A page ID to exclude from the results.
 *
 * @return array Returns an array of pages with section and formatted date.
 */
public function getPages(
    bool $featured = false,
    string $section = null,
    int $section_id = 0,
    int $amount = PHP_INT_MAX,
    int $exclude = 0
): ?array {
    $builder = $this->db->table('pages p');

    $builder->select('p.title, p.subtitle, p.photo, p.label, p.slug, s.slug AS s_slug')
            ->select('DATE_FORMAT(p.created, "%b %d, %Y") AS f_created', false)
            ->join('sections s', 's.id = p.section_id')
            ->where('p.status', 1)
            ->where('p.accessibility', 0)
            ->where('s.id !=', 1);

    if ($section)    $builder->where('s.slug', $section);
    if ($section_id) $builder->where('s.id', $section_id);
    if ($exclude)    $builder->where('p.id !=', $exclude);

    if ($featured) {
        $builder->where('p.featured', 1)
                ->orderBy('p.position', 'ASC');
    }

    // Order & Limit
    $builder->orderBy('p.created', 'DESC')
            ->limit($amount);

    return $builder->get()->getResultArray();
}

/**
 * Retrieves a single page's full information by its slug.
 *
 * @param string $slug The slug of the page to retrieve.
 * @return array|null The page data if found, or null if not.
 */
public function getSinglePage(string $slug): ?array {
    $id = $this->getIdFromSlug($slug, 'pages');

    if ( empty($id) ) return null;

    return $this->db->table('pages p')
                    ->select('p.*, DATE_FORMAT(p.created, "%b %d, %Y") AS formatted_date', false)
                    ->select('CONCAT(u.first_name, " ", u.last_name) AS author, u.author as user_handle')
                    ->select('s.title AS section, s.id AS section_id, s.slug AS s_slug')
                    ->join('users u', 'u.id = p.user_id')
                    ->join('sections s', 's.id = p.section_id')
                    ->where('p.id', $id)
                    ->get()->getRowArray();
}

/**
 * Retrieves the ID of a record by its slug from a given table.
 *
 * @param string $slug  The slug to search for.
 * @param string $table The database table to search in.
 * @return int|null     The ID if found, or null if not found.
 */
public function getIdFromSlug(string $slug, string $table): ?int {
    return $this->db->table($table)
                    ->select('id')
                    ->where('slug', $slug)
                    ->get()
                    ->getRow()
                    ->id ?? null;
}

/**
 * Retrieves the title of a record by its ID from a given table.
 *
 * @param int    $id    The record ID.
 * @param string $table The database table to query.
 * @return string|null  The title if found, or null if not found.
 */
public function getTitleFromId(int $id, string $table): ?string {
    return $this->db->table($table)
                    ->select('title')
                    ->where('id', $id)
                    ->get()
                    ->getRow()
                    ->title ?? null;
}

/**
 * Retrieves a user's ID by their handle (author field).
 *
 * @param string $handle The author handle.
 * @return int|null      The user ID if found, or null if not found.
 */
public function getIdFromHandle(string $handle): ?int {
    return $this->db->table('users')
                    ->select('id')
                    ->where('author', $handle)
                    ->get()
                    ->getRow()
                    ->id ?? null;
}

/**
 * Retrieves a user's name by their ID.
 *
 * @param int  $userId        The user's ID.
 * @param bool $showFullName  Whether to return full name (first + last). Defaults to false.
 * @return string|null        The name if found, or null if not found.
 */
public function getFullnameFromId(int $userId, bool $showFullName = false): ?string {
    $select = $showFullName
        ? 'CONCAT(first_name, " ", last_name) AS fullname'
        : 'first_name AS fullname';

    return $this->db->table('users')
                    ->select($select, false)
                    ->where('id', $userId)
                    ->get()->getRow()
                    ->fullname ?? null;
}

/**
 * Retrieves and groups blocks by group and alias.
 *
 * @param array $groups An array of block group names to filter by.
 * @return array Grouped array of blocks by group and alias.
 */
public function getBlocks(array $groups = []): array {
    if (empty($groups)) return [];

    $builder = $this->db->table('blocks b')
                        ->select('b.*, g.title AS block_group')
                        ->join('block_groups g', 'g.id = b.block_group_id', 'left')
                        ->whereIn('g.title', $groups)
                        ->orderBy('g.title', 'ASC')
                        ->orderBy('b.alias', 'ASC');

    $results = $builder->get()->getResultArray();

    // Group by block_group (which is now coming from block_groups.title)
    $core = new SystemCore();
    return $core->arrayGroupBy($results, 'block_group', 'alias');
}

/**
 * Retrieves a list of active social media links from the settings table,
 * including an additional static contact link at the end.
 *
 * @return array The list of social media settings, each with a 'setting' and 'value' key.
 */
public function getSocialsList(): array {

    $results = $this->db->table('settings s')
                        ->select('s.setting, s.value')
                        ->join('setting_groups g', 'g.id = s.setting_group_id', 'inner')
                        ->where('g.title', 'social_media')
                        ->where('s.value !=', '')
                        ->orderBy('s.position', 'ASC')
                        ->get()->getResultArray();

    // Append a static contact link
    $results[] = [
        'setting' => 'contact',
        'value'   => site_url('info/contact'),
    ];

    return $results;
}

/**
 * Retrieves a list of active topics with at least one post,
 * excluding the default or placeholder topic with ID 1.
 *
 * @return array List of topics with their title, slug, and post count.
 */
public function getTopicsList(): ?array {
    return $this->db->table('topics')
                    ->select('title, slug, posts')
                    ->where('id !=', 1)
                    ->where('posts !=', 0)
                    ->orderBy('position', 'ASC')
                    ->get()->getResultArray();
}

/**
 * Retrieves the latest post for each given alias.
 *
 * For each alias in the provided array, this method returns the most recent
 * associated post from the ai_posts table, joined with its corresponding prompt.
 * The result is an associative array keyed by alias, each containing the post body
 * and a formatted creation date.
 *
 * @param array $aliases An array of alias strings to fetch the latest posts for.
 * @param bool $random If true, returns a random post for each alias instead of the latest.
 *
 * @return array|null An associative array of posts keyed by alias, or null if no aliases provided.
 */
public function getAiPosts(array $aliases, bool $random = false): ?array {
    if (empty($aliases)) {
        return null;
    }

    $result = [];
    $emptyArr = ['body' => '', 'f_updated' => ''];

    foreach ($aliases as $alias) {
        $builder = $this->db->table('ai_posts p')
                            ->join('ai_prompts pr', 'p.prompt_id = pr.id')
                            ->select('p.body')
                            ->select('DATE_FORMAT(p.created, "%b %d, %Y - %H:%i") AS f_updated', false)
                            ->where('pr.alias', $alias)
                            ->limit(1);

        $random ? $builder->orderBy('RAND()') : $builder->orderBy('p.created', 'DESC');
        $row = $builder->get()->getRowArray();

        // If we found a row and $random is true, override the date
        if ($row && $random) {
            $row['f_updated'] = 'από το αρχείο';
        }

        $result[$alias] = $row ?: $emptyArr;
    }

    return $result;
}

/**
 * Get the total count of posts, pages, and AI posts.
 *
 * If `$public` is `true`, it counts only the posts and pages with a `status` of 1 (public).
 * If `$public` is `false`, it counts all entries in the tables regardless of their `status`.
 * The `ai_posts` table is always counted regardless of the `status` condition as it does not have a `status` field.
 *
 * @param bool $public Whether to count only public posts and pages. Defaults to `false`.
 *
 * @return int The total count of posts, pages, and AI posts based on the condition.
 */
public function getTotalPosts(bool $public = false): int {
    $tables = ['posts', 'pages', 'ai_posts'];
    $total = 0;

    foreach ($tables as $table) {
        if ($public && in_array($table, ['posts', 'pages'])) {
            $total += $this->db->table($table)->where('status', '1')->countAllResults();
        } else {
            $total += $this->db->table($table)->countAll();
        }
    }

    return $total;
}


} // ─── End of Class ───