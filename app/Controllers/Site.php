<?php namespace App\Controllers;
use App\Models\StatsModel;
use App\Models\SystemModel;

class Site extends BaseController {

    private $stats;

    function __construct() {
        $this->stats    = new StatsModel();
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
    $shouldCache = setting('caching') == 1 && !session('logged_in');

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
        // 'ai'             => $this->content->getAiPosts(['pythia'])
    ]);

    // Render the view
    $output = view('site/front', $data);

    // Store in cache if applicable (Cached is enabled && !logged_in)
    if ($shouldCache) {
        cache()->save($cacheName, $output, CACHE_TIMEOUT); // 1 Hour
    }

    echo $output;

    $this->stats->trackVisitor();
}

/**
 * Displays a single post by ID.
 *
 * Behavior:
 * - Caches content per post and user tier if enabled.
 * - Blocks access if the post is unpublished and the user is below tier 9.
 *
 * @param int|string $id The post ID.
 * @return \CodeIgniter\HTTP\RedirectResponse|void
 */
public function post(int|string $id) {
    // Get user tier
    $tier = tier();

    // Cache settings (cache per post AND per tier)
    $cacheName   = "post_{$id}_tier_{$tier}";
    $shouldCache = setting('caching') == 1 && !session('logged_in');

    // Serve from cache if available
    if ($shouldCache && ($cachedView = cache($cacheName))) {
        echo $cachedView;
        $this->stats->trackVisitor($id);
        return;
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
    $data = array_merge($this->data, [
        'post'      => $postData,
        'related'   => $this->content->getRelatedPosts(id: $id, topic_id: $postData['topic_id']),
        'can_edit'  => $tier >= 10 || ($tier == 9 && $postData['user_id'] == session('user_id')),
        'highlight' => $postData['highlight'] == '1',
        // 'ai'        => $this->content->getAiPosts(['invention', 'history'])
    ]);

    // Render the view
    $output = view('site/post', $data);

    // Store in cache if applicable (cache different versions per tier)
    if ($shouldCache) {
        cache()->save($cacheName, $output, CACHE_TIMEOUT); // 1 Hour
    }

    echo $output;
    $this->stats->trackVisitor($id);
}

/**
 * Renders a printable version of the post.
 *
 * Restrictions:
 * - Only available if the post exists and the user is authorized.
 *
 * @param int|string $id The post ID.
 * @return \CodeIgniter\HTTP\RedirectResponse|void
 */
public function print(int|string $id) {
    $postData = $this->content->getSinglePost($id);

	// Members Only or Post does not Exist
	if ( empty($postData) ) {
       return redirect()->to('/');
    }

	// Not a Writer or higher & Not Published
	if ( tier() < 9 && $postData['status'] !=1 ) {
		return redirect()->to('/');
	}

    // Construct the data array
    $data = array_merge($this->data, [
        'post' => $postData
    ]);

	echo view('site/print',$data);
	$this->stats->trackVisitor($id);
}

/**
 * Displays a single static page by its slug.
 *
 * Behavior:
 * - Caches content by slug if enabled.
 * - Blocks access if unpublished and user is below tier 9.
 *
 * @param string $slug The page slug.
 * @return \CodeIgniter\HTTP\RedirectResponse|void
 */
public function page(string $slug) {
    // Fetch page ID early
    $id = $this->content->getIdFromSlug($slug, 'pages');

    // Cache settings (cache per page slug)
    $cacheName   = "page_{$slug}";
    $shouldCache = setting('caching') == 1 && !session('logged_in');

    // Serve from cache if available
    if ($shouldCache && ($cachedView = cache($cacheName))) {
        echo $cachedView;
        $this->stats->trackVisitor($id, 'page'); // Ensure ID is correctly passed
        return;
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
    $data = array_merge($this->data, [
        'related'   => $this->content->getPages(amount: setting('no_related'), exclude: $id, section_id: $pageData['section_id']),
        'page'      => $pageData,
        'can_edit'  => tier() >= 10,
        'highlight' => $pageData['highlight'] == '1',
        'featured'  => $this->content->getPosts(amount: 10, featured: true),
    ]);

    // Render the view
    $output = view('site/page', $data);

    // Store in cache if applicable (cache by page slug)
    if ($shouldCache) {
        cache()->save($cacheName, $output, CACHE_TIMEOUT);
    }

    echo $output;
    $this->stats->trackVisitor($id, 'page'); // Ensure ID is passed
}

/**
 * Displays a topic-based listing of posts.
 *
 * - Retrieves topic ID by slug.
 * - Shows posts under that topic with pagination.
 *
 * @param string $slug The topic slug.
 * @return \CodeIgniter\HTTP\RedirectResponse|void
 */
public function topic(string $slug) {
    // Get Page
    $page = $this->request->getGet('page') ?? 1;
    $page = ctype_digit($page) ? (int) $page : 1;

    // Cache settings
    $cacheKey    = 'topic_' . $slug . '_page_' . $page;
    $shouldCache = setting('caching') == 1 && !session('logged_in');

    // Serve from cache if available
    if ($shouldCache && ($cachedView = cache($cacheKey))) {
        echo $cachedView;
        $this->stats->trackVisitor();
        return;
    }

    // Get topic ID
    $topic_id = $this->content->getIdFromSlug($slug, 'topics');

    if (empty($topic_id)) {
        return redirect()->to('/');
    }

    // Prepare data
    $data = array_merge($this->data, [
        'site_title' => $this->content->getTitleFromId($topic_id, 'topics'),
        'post_data'  => $this->content->getPosts(topic_id: $topic_id, pagination: true, page: $page),
        'trending'   => $this->content->getRankingPosts(amount: 10, type: 'trending'),
        // 'ai'         => $this->content->getAiPosts(['invention', 'history'], true)
    ]);

    // Render view
    $output = view('site/list', $data);

    // Store in cache if applicable
    if ($shouldCache) {
        cache()->save($cacheKey, $output, CACHE_TIMEOUT);
    }

    echo $output;

    $this->stats->trackVisitor();
}


/**
 * Displays posts written by a specific author.
 *
 * - Retrieves user ID by handle.
 * - Supports pagination.
 *
 * @param string $handle The author's handle.
 * @return \CodeIgniter\HTTP\RedirectResponse|void
 */
public function author(string $handle) {
    // Get Page
    $page = $this->request->getGet('page') ?? 1;
    $page = ctype_digit($page) ? (int) $page : 1;

    // Cache settings
    $cacheKey    = 'author_' . $handle . '_page_' . $page;
    $shouldCache = setting('caching') == 1 && !session('logged_in');

    // Serve from cache if available
    if ($shouldCache && ($cachedView = cache($cacheKey))) {
        echo $cachedView;
        $this->stats->trackVisitor();
        return;
    }

    // Get user ID
    $user_id = $this->content->getIdFromHandle($handle);

    if (empty($user_id)) {
        return redirect()->to('/');
    }

    // Prepare data
    $data = array_merge($this->data, [
        'site_title' => $this->content->getFullnameFromId($user_id, true),
        'post_data'  => $this->content->getPosts(user_id: $user_id, pagination: true, page: $page),
        // 'ai'        => $this->content->getAiPosts(['invention', 'history'], true)
    ]);

    // Render view
    $output = view('site/list', $data);

    // Store in cache if applicable
    if ($shouldCache) {
        cache()->save($cacheKey, $output, CACHE_TIMEOUT);
    }

    echo $output;

    $this->stats->trackVisitor();
}

/**
 * Displays ranked posts by type (popular or trending).
 *
 * - Only allows valid types.
 * - Supports pagination.
 *
 * @param string $type The ranking type: 'popular' or 'trending'.
 * @return \CodeIgniter\HTTP\RedirectResponse|void
 */
public function ranking(string $type) {
    if (!in_array($type, ['popular', 'trending'])) {
        return redirect()->to('/');
    }

    // Cache settings
    $cacheKey    = 'ranking_' . $type;
    $shouldCache = setting('caching') == 1 && !session('logged_in');

    // Serve from cache if available
    if ($shouldCache && ($cachedView = cache($cacheKey))) {
        echo $cachedView;
        $this->stats->trackVisitor();
        return;
    }

    // Prepare data
    $data = [
        ...$this->data,
        'site_title' => ucfirst($type),
        'post_data'  => $this->content->getRankingPosts(type: $type),
        'ranked'     => true,
        // 'ai'         => $this->content->getAiPosts(['invention', 'history'], true),
    ];

    // Render view
    $output = view('site/list', $data);

    // Store in cache if applicable
    if ($shouldCache) {
        cache()->save($cacheKey, $output, CACHE_TIMEOUT);
    }

    echo $output;

    $this->stats->trackVisitor();
}

/**
 * Displays featured posts only.
 *
 * - Supports pagination.
 * - Uses the "Post.featured" language key for title.
 *
 * @return void
 */
public function featured() {
    // Cache settings
    $cacheName   = 'featured_posts';
    $shouldCache = setting('caching') == 1 && !session('logged_in');

    // Serve from cache if available
    if ($shouldCache && ($cachedView = cache($cacheName))) {
        echo $cachedView;
        $this->stats->trackVisitor();
        return;
    }

    // Fetch data
    $data = array_merge($this->data, [
        'site_title' => 'Featured',
        'post_data'  => $this->content->getPosts(featured: true),
        'trending'   => $this->content->getRankingPosts(amount: 10, type: 'trending'),
        // 'ai'         => $this->content->getAiPosts(['invention', 'history'], true),
    ]);

    // Render the view
    $output = view('site/list', $data);

    // Store in cache if applicable
    if ($shouldCache) {
        cache()->save($cacheName, $output, CACHE_TIMEOUT);
    }

    echo $output;

    $this->stats->trackVisitor();
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
 * Displays the botshield page to deter or block unwanted bot traffic.
 *
 * @return \CodeIgniter\View\View
 */
public function botshield() {
    return view('site/botshield');
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
        $routes->get('topic/' . $topic['slug'], 'Site::topic/' . $topic['slug']);
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
    $routes->get('preview/(:segment)', 'Site::page/$1');

    // Dynamically add the other section routes
    foreach ($sections as $section) {
        $routes->get($section['slug'].'/(:segment)', 'Site::page/$1');
    }
}

} // ─── End of Class ───
