<?php namespace App\Controllers;
use App\Models\ContentModel;

class Site extends BaseController {

    private ContentModel $content;

    function __construct() {
        $this->content = new ContentModel();
    }

/**
 * Renders the front page of the site.
 *
 * Caching:
 * - Cached for guests outside development.
 *
 * Data Includes:
 * - Featured posts, latest updates, trending, and popular posts.
 *
 * Tracks:
 * - Frontpage visitor statistics.
 *
 * @return string
 */
public function index() {
    // Get Page
    $page = $this->request->getGet('page') ?? 1;
    $page = ctype_digit($page) ? (int) $page : 1;

    // Cache settings
    $cacheName   = 'frontpage' . '_page_' . $page;

    // Serve from cache if available
    if (!session('logged_in') && !isDev() && ($cachedView = cache($cacheName))) {
        return $cachedView;
    }

    // Fetch Data
    $latest_updates = $this->content->getPosts(pagination: true, page: $page);
    $latestPosts    = $latest_updates['posts'];
    $halfCount      = (int) ceil(count($latestPosts) / 2);

    $data = [
        'pagination' => $latest_updates['pagination'],
        'topPosts'   => array_slice($latestPosts, 0, $halfCount),
        'restPosts'  => array_slice($latestPosts, $halfCount),
        'pageNo'     => $page
    ];

    // Render the view
    $output = theme_view('frontend/pages/home', $data);

    // Store in cache if applicable (!logged_in)
    if (!session('logged_in') && !isDev()) {
        cache()->save($cacheName, $output, setting("cache.lifetime")); // 1 Hour
    }

    return $output;
}

/**
 * Displays a single post by ID.
 *
 * Behavior:
 * - Caches content per post and user tier for guests outside development.
 * - Blocks access if the post is unpublished and the user is below tier 9.
 *
 * @param int|string $id The post ID.
 * @return \CodeIgniter\HTTP\RedirectResponse|string
 */
public function post(int|string $id) {
    // Get user tier
    $tier = tier();

    // Cache settings (cache per post AND per tier)
    $cacheName   = "post_{$id}_tier_{$tier}";

    // Serve from cache if available
    if (!session('logged_in') && !isDev() && ($cachedView = cache($cacheName))) {
        return $cachedView;
    }

    // Fetch post data, ensuring it respects the user's tier
    $postData = $this->content->getSinglePost($id);

    // Post does not exist or user is not allowed to access it
    if (empty($postData)) {
        return redirect()->to('/');
    }

    // Not a Writer or higher & Not Published
    if ($tier < 9 && $postData['status'] != 1) {
        return redirect()->to('/');
    }

    // Construct the data array
    $data = [
        'post'      => $postData,
        'can_edit'  => $tier >= 10 || ($tier == 9 && $postData['user_id'] == session('user_id')),
        'highlight_js' => $postData['highlight'] == '1',
    ];

    // Render the view
    $output = theme_view('frontend/pages/post', $data);

    // Store in cache if applicable (cache different versions per tier)
    if (!session('logged_in') && !isDev()) {
        cache()->save($cacheName, $output, setting("cache.lifetime")); // 1 Hour
    }

    return $output;
}

/**
 * Displays a single static page by its slug.
 *
 * Behavior:
 * - Caches content by slug for guests outside development.
 * - Blocks access if unpublished and user is below tier 9.
 *
 * @param string $slug The page slug.
 * @return \CodeIgniter\HTTP\RedirectResponse|string
 */
public function page(string $slug) {
    // Fetch page ID early
    // Cache settings (cache per page slug)
    $cacheName   = "page_{$slug}";

    // Serve from cache if available
    if (!session('logged_in') && !isDev() && ($cachedView = cache($cacheName))) {
        return $cachedView;
    }

    // Fetch page data
    $pageData = $this->content->getSinglePage(slug: $slug);

    // No page available
    if (empty($pageData)) {
        return redirect()->to('/');
    }

    // Not an Administrator & Not Published
    if (tier() < 9 && $pageData['status'] != 1) {
        return redirect()->to('/');
    }

    // Construct the data array
    $data = [
        'page'      => $pageData,
        'can_edit'  => tier() >= 10,
        'highlight_js' => $pageData['highlight'] == '1',
    ];

    // Render the view
    $output = theme_view('frontend/pages/page', $data);

    // Store in cache if applicable (cache by page slug)
    if (!session('logged_in') && !isDev()) {
        cache()->save($cacheName, $output, setting("cache.lifetime"));
    }

    return $output;
}

/**
 * Displays a topic-based listing of posts.
 *
 * - Retrieves topic ID by slug.
 * - Shows posts under that topic with pagination.
 *
 * @param string $slug The topic slug.
 * @return \CodeIgniter\HTTP\RedirectResponse|string
 */
public function topic(string $slug) {
    // Get Page
    $page = $this->request->getGet('page') ?? 1;
    $page = ctype_digit($page) ? (int) $page : 1;

    // Cache settings
    $cacheKey    = 'topic_' . $slug . '_page_' . $page;

    // Serve from cache if available
    if (!session('logged_in') && !isDev() && ($cachedView = cache($cacheKey))) {
        return $cachedView;
    }

    // Get topic ID
    $topic_id = $this->content->getIdFromSlug($slug, 'topics');

    if (empty($topic_id)) {
        return redirect()->to('/');
    }

    // Prepare data
    $topic = $this->content->getTopicDetails($topic_id);
    $data = [
        'site_title' => $topic['title'] ?? '',
        'site_desc' => $topic['description'] ?? '',
        'post_data'  => $this->content->getPosts(topic_id: $topic_id, pagination: true, page: $page)
    ];

    // Render view
    $output = theme_view('frontend/pages/archive', $data);

    // Store in cache if applicable
    if (!session('logged_in') && !isDev()) {
        cache()->save($cacheKey, $output, setting("cache.lifetime"));
    }

    return $output;
}


/**
 * Displays posts written by a specific author.
 *
 * - Retrieves user ID by handle.
 * - Supports pagination.
 *
 * @param string $handle The author's handle.
 * @return \CodeIgniter\HTTP\RedirectResponse|string
 */
public function author(string $handle) {
    // Get Page
    $page = $this->request->getGet('page') ?? 1;
    $page = ctype_digit($page) ? (int) $page : 1;

    // Cache settings
    $cacheKey    = 'author_' . $handle . '_page_' . $page;

    // Serve from cache if available
    if (!session('logged_in') && !isDev() && ($cachedView = cache($cacheKey))) {
        return $cachedView;
    }

    // Get user ID
    $user_id = $this->content->getIdFromHandle($handle);

    if (empty($user_id)) {
        return redirect()->to('/');
    }

    // Prepare data
    $data = [
        'site_title' => $this->content->getFullnameFromId($user_id, true),
        'post_data'  => $this->content->getPosts(user_id: $user_id, pagination: true, page: $page)
    ];

    // Render view
    $output = theme_view('frontend/pages/archive', $data);

    // Store in cache if applicable
    if (!session('logged_in') && !isDev()) {
        cache()->save($cacheKey, $output, setting("cache.lifetime"));
    }

    return $output;
}

/**
 * Displays ranked posts by type (popular or trending).
 *
 * - Only allows valid types.
 * - Supports pagination.
 *
 * @param string $type The ranking type: 'popular' or 'trending'.
 * @return \CodeIgniter\HTTP\RedirectResponse|string
 */
public function ranking(string $type) {
    if (!in_array($type, ['popular', 'trending'])) {
        return redirect()->to('/');
    }

    // Cache settings
    $cacheKey    = 'ranking_' . $type;

    // Serve from cache if available
    if (!session('logged_in') && !isDev() && ($cachedView = cache($cacheKey))) {
        return $cachedView;
    }

    // Prepare data
    $data = [
        'site_title'   => ucfirst($type),
        'post_data'    => $this->content->getRankingPosts(type: $type),
        'hideTrending' => $type === 'trending',
        'hidePopular'  => $type === 'popular',
    ];

    // Render view
    $output = theme_view('frontend/pages/archive', $data);

    // Store in cache if applicable
    if (!session('logged_in') && !isDev()) {
        cache()->save($cacheKey, $output, setting("cache.lifetime"));
    }

    return $output;
}

/**
 * Displays featured posts only.
 *
 * - Supports pagination.
 * - Uses the "Post.featured" language key for title.
 *
 * @return string
 */
public function featured() {
    // Get Page
    $page = $this->request->getGet('page') ?? 1;
    $page = ctype_digit((string) $page) ? (int) $page : 1;

    // Cache settings
    $cacheName   = 'featured_posts_page_' . $page;

    // Serve from cache if available
    if (!session('logged_in') && !isDev() && ($cachedView = cache($cacheName))) {
        return $cachedView;
    }

    // Fetch data
    $data = [
        'site_title' => 'Featured',
        'post_data'  => $this->content->getPosts(featured: true, pagination: true, page: $page)
    ];

    // Render the view
    $output = theme_view('frontend/pages/archive', $data);

    // Store in cache if applicable
    if (!session('logged_in') && !isDev()) {
        cache()->save($cacheName, $output, setting("cache.lifetime"));
    }

    return $output;
}

/**
 * Handles 404 errors by redirecting to the homepage.
 *
 * @return \CodeIgniter\HTTP\RedirectResponse
 */
public function handle404() {
    return redirect()->to('/');
}

/**
 * Registers dynamic routes for each topic based on their slug.
 *
 * Used internally to map topic slugs to their corresponding controller actions.
 * Each route maps a topic slug (except ID 1) to: `Site::topic/{slug}`
 *
 * Example:
 *     example.com/technology → Site::topic('technology')
 *
 * @return void
 */
public function setupTopicRoutes() {
    $db = \Config\Database::connect();
    $topics = $db->table('topics')->select('slug')->where('id!=',1)->get()->getResultArray();
    $routes = service('routes');

    foreach ($topics as $topic) {
        $routes->get('topic/' . $topic['slug'], 'Site::topic/' . $topic['slug'], ['filter' => 'trackVisitor']);
    }
}

/**
 * Registers dynamic routes for pages under each section based on their slug.
 *
 * This maps URLs of the form `/section-slug/{page-slug}` to the `Site::page()` method,
 * passing the `{page-slug}` as a parameter.
 *
 * Skips the section with ID 1.
 *
 * Example:
 *     example.com/information/about → Site::page('about')
 *
 * @return void
 */
public function setupPageRoutes() {
    $db = \Config\Database::connect();
    $sections = $db->table('sections')->select('slug')->where('id!=',1)->get()->getResultArray();
    $routes = service('routes');

    // Manually add the 'preview' section
    $routes->get('preview/(:segment)', 'Site::page/$1', ['filter' => 'trackPageVisitor']);

    // Dynamically add the other section routes
    foreach ($sections as $section) {
        $routes->get($section['slug'].'/(:segment)', 'Site::page/$1', ['filter' => 'trackPageVisitor']);
    }
}

} // ─── End of Class ───



