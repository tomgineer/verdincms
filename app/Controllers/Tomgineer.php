<?php namespace App\Controllers;
use App\Models\StatsModel;

class Tomgineer extends BaseController {

    protected StatsModel $stats;

    public function __construct() {
        $this->stats     = new StatsModel();
    }

/**
 * Renders the front page of the site.
 *
 * Caching:
 * - Cached if caching is enabled and the user is not logged in.
 *
 * Data Includes:
 * - Featured posts, latest updates, trending, and popular posts.
 *
 * Tracks:
 * - Frontpage visitor statistics.
 *
 * @return void
 */
public function index() {
    // Get Page
    $page = $this->request->getGet('page') ?? 1;
    $page = ctype_digit($page) ? (int) $page : 1;

    // Cache settings
    $cacheName   = 'frontpage' . '_page_' . $page;
    $shouldCache = setting('cache.enabled') === true && !session('logged_in');

    // Serve from cache if available
    if ($shouldCache && ($cachedView = cache($cacheName))) {
        echo $cachedView;
        $this->stats->trackVisitor();
        return;
    }

    // Fetch Data ONLY when needed
    $data = array_merge($this->data, [
        'latest_updates' => $this->content->getPosts(pagination: true, page: $page, amount: 20),
        'featured'       => $this->content->getPosts(amount: 10, featured: true),
        'trending'       => $this->content->getRankingPosts(amount: 10, type: 'trending'),
        'popular'        => $this->content->getRankingPosts(amount: 10, type: 'popular'),
    ]);

    // Render the view
    $output = view('tomgineer/front', $data);

    // Store in cache if applicable (Cached is enabled && !logged_in)
    if ($shouldCache) {
        cache()->save($cacheName, $output, setting("cache.lifetime")); // 1 Hour
    }

    echo $output;

    $this->stats->trackVisitor();
}


} // ─── End of Class ───
