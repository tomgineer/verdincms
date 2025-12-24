<?php namespace App\Controllers;
use App\Models\DashboardModel;
use App\Models\SystemModel;
use App\Models\AnalyticsModel;
use App\Models\EditContentModel;
use App\Models\ContentModel;
use CodeIgniter\API\ResponseTrait;

class Admin extends BaseController {

    private $dash;
    private $analytics;
    private $edit;
    private $content;

	use ResponseTrait;

    public function __construct() {
        $this->content = new ContentModel();
    }

/**
 * Displays the edit form for a specific content item of a given type.
 *
 * Only users with tier 9 or higher access can access this method.
 * Loads relevant data such as post content, user lists, user groups, and related topics,
 * and passes them to the `edit/edit` view for rendering.
 *
 * @param string $type The type of content to edit (e.g., 'post', 'page').
 * @param int    $id   The ID of the content item to edit.
 *
 * @return \CodeIgniter\HTTP\RedirectResponse|\CodeIgniter\HTTP\ResponseInterface
 *         A redirect to the homepage if access is denied,
 *         otherwise the rendered edit view with all necessary data.
 */
public function edit(string $type, int|string $id) {
    if (tier() < 9) {return redirect()->to('/');}
    $this->edit = new EditContentModel;

    $data = [
        'title'        => "Edit " . ucfirst($type) . ": {$id}",
        'type'         => $type,
        'statusLabels' => [1 => 'Published', 2 => 'Draft', 3 => 'Deleted'],
        'statusColors' => [1 => 'success', 2 => 'warning', 3 => 'error'],
        'post'         => $this->edit->getContent($type, $id),
        'users'        => $this->edit->getUsers(),
        'user_groups'  => $this->edit->getUserGroups(),
        'topics'       => $this->edit->getTopics(),
        'sections'     => $this->edit->getSections(),
    ];

    return view('admin/edit/edit',$data);
}

/**
 * Displays a list of unpublished posts for moderation.
 *
 * Handles either "drafts" (status 2) or "review" (posts flagged for review).
 * Only accessible to users with tier >= 9.
 *
 * @param string $type Either 'drafts' or 'review'
 * @return \CodeIgniter\HTTP\RedirectResponse|string Rendered view or redirect
 */
public function moderate(string $type) {
    // Access check
    if (tier() < 9 || !in_array($type, ['drafts', 'review'])) {
        return redirect()->to('/');
    }

    // Get Page
    $page = $this->request->getGet('page') ?? 1;
    $page = ctype_digit($page) ? (int) $page : 1;

    // Fetch posts based on moderation type
    $post_data = $type === 'drafts'
        ? $this->content->getPosts(status: 2, pagination: true, page: $page)
        : $this->content->getPosts(review: true, pagination: true, page: $page);

    // Smarter descriptions
    $descriptions = [
        'drafts' => 'Unpublished or Deleted',
        'review' => 'Awaiting Editorial Review'
    ];

    $data = [
        'site_title' => ucwords($type),
        'post_data'  => $post_data,
        'stats' => [[
            'title' => ucfirst($type),
            'value' => $this->content->countContent($type),
            'desc'  => $descriptions[$type] ?? 'Pending'
        ]]
    ];

    // Render view
    return view('frontend/pages/archive', $data);
}

/**
 * Loads the dashboard view and its dynamic content based on the given path.
 *
 * Supports multiple dashboard sections such as home, info, review, subjects,
 * logs, blocks, and settings. Each section loads the required models and data
 * into the $data array before rendering the main dashboard view.
 *
 * @param string ...$segments Optional URI segments determining the dashboard path.
 * @return \CodeIgniter\HTTP\Response|string The rendered dashboard view or redirect.
 */
public function dashboard(...$segments) {
    if (tier() < 10) {
        return redirect()->to('/');
    }

    $path = implode('/', $segments);
    $this->dash = new DashboardModel();

    $data = [
        'path'  => $path,
        'title' => 'Dashboard',
    ];

    switch ($path) {
        case '':
            $this->analytics = new AnalyticsModel();

            $data = [
                ...$data,
                'path'             => 'home/home',
                'useChartJS'       => true,
                'chart_visitors'   => $this->analytics->getVisitorAndHitStats(14, true),
                'posting_activity' => $this->analytics->getDailyCreationCounts(),
            ];
            break;

        case 'info/info':
            $data = [
                ...$data,
                'info'          => $this->dash->getSystemAndDatabaseInfo(),
                'php_info'      => $this->dash->getPhpInfo(),
                'gd_info'       => gd_info(),
                'session_data'  => session()->get(),
            ];
            break;

        case 'review/review':
            $data = [
                ...$data,
                'posts' => $this->dash->needReview('post'),
                'pages' => $this->dash->needReview('page'),
            ];
            break;

        case 'subjects/subjects':
            $data = [
                ...$data,
                'useCKEditor' => true,
                'topics'      => $this->dash->getSubjects('topics'),
                'sections'    => $this->dash->getSubjects('sections'),
            ];
            break;

        case 'latest/latest':
            $data = [
                ...$data,
                'posts' => $this->dash->getLatestContent('post', 10),
                'pages' => $this->dash->getLatestContent('page', 10),
            ];
            break;

        case 'accounts/accounts':
            $data = [
                ...$data,
                'users'       => $this->dash->getUserData(),
            ];
            break;

        case 'newsletter/newsletter':
            $data = [
                ...$data,
                'useCKEditor'        => true,
                'subscribers'        => $this->dash->getSubscribers(),
                'newsletter_content' => $this->dash->buildWeeklyNewsletterHtml(),
            ];
            break;

        case 'logs/logs':
            $data = [
                ...$data,
                'crons'  => $this->dash->getCronLog(10),
                'hits'   => $this->dash->getHitsEntries(20),
                'errors' => $this->dash->getErrorLogs(),
            ];
            break;

        case 'archive/archive':
            $data = [
                ...$data,
                'posts' => $this->dash->getArchivedContent('post'),
                'pages' => $this->dash->getArchivedContent('page'),
            ];
            break;

        case 'trash/trash':
            $data = [
                ...$data,
                'photos'   => (new SystemModel())->getOrphanPhotos(),
                'content'  => [
                    'posts' => $this->dash->getArchivedContent('post', 3),
                    'pages' => $this->dash->getArchivedContent('page', 3),
                ],
                'accounts' => [
                    'users' => $this->dash->getUserData('0'),
                ],
            ];
            break;

        case 'blocks/blocks':
            $data = [
                ...$data,
                'useCKEditor'  => true,
                'blocks'       => $this->dash->getBlocks(),
                'block_groups' => $this->dash->getBlockGroups(),
            ];
            break;

        case 'settings/settings':
            $data = [
                ...$data,
                'settings' => $this->dash->getSettings(),
            ];
            break;

        case 'sort/sort':
            $data = [
                ...$data,
                'tables' => $this->dash->getSortTables(),
            ];
            break;

        default:
            return redirect()->to('/');
    }

    return view('admin/dashboard/dashboard', $data);
}


/**
 * Displays various analytics dashboards based on the URL path segment.
 *
 * This method dynamically loads analytics views depending on the provided
 * path (e.g., 'visitors', 'countries', 'browsers', etc.). It initializes
 * either the DashboardModel or AnalyticsModel as needed and prepares
 * the corresponding data for rendering in the "analytics/analytics" view.
 *
 * Access is restricted to users with tier level 10 or above.
 *
 * @param string ...$segments One or more optional URL segments used to determine the analytics section to display.
 *
 * @return \CodeIgniter\HTTP\RedirectResponse|\CodeIgniter\HTTP\ResponseInterface
 *     Redirects to homepage if unauthorized or path is invalid, otherwise returns the analytics view with data.
 */
public function analytics(...$segments) {
    if (tier() < 10) {return redirect()->to('/');}
    $path = implode('/', $segments);
    $data = [
        'path'  => $path,
        'title' => 'Analytics'
    ];

    $this->dash = new DashboardModel();

    switch ($path) {
        case '':
            $data['path']  = 'home';
            $this->analytics = new AnalyticsModel();
            $data['live']  = $this->analytics->getLiveData();
            $data['stats'] = $this->analytics->getOverviewData();
            break;
        case 'visitors':
            $data['useChartJS'] = true;
            $data['traffic'] = $this->dash->getVisitorAndHitStatsData();
            break;
        case 'countries':
            $data['useChartJS'] = true;
            $data['traffic'] = $this->dash->getCountryAndBrowserStatsData('country');
            break;
        case 'browsers':
            $data['useChartJS'] = true;
            $data['traffic'] = $this->dash->getCountryAndBrowserStatsData('browser');
            break;
        case 'popular':
            $this->analytics = new AnalyticsModel();
            $data['posts'] = $this->analytics->getPopularContent('post');
            $data['pages'] = $this->analytics->getPopularContent('page');
            break;
        case 'subjects':
            $this->analytics = new AnalyticsModel();
            $data['stats'] = $this->analytics->getTopTopicsAndSections();
            break;
        case 'hourly':
            $data['useChartJS'] = true;
            $data['hourly'] = $this->dash->getHourlyAnalyticsData();
            break;
        case 'trending':
            $this->analytics = new AnalyticsModel();
            $data['trending'] = $this->analytics->getTrendingPosts();
            break;
        default:
            return redirect()->to('/');
            break;
    }

    return view('admin/analytics/analytics',$data);
}

/**
 * Displays the mobile analytics dashboard.
 *
 * Loads and passes live analytics data to the "analytics/mobile" view,
 * including visitor statistics, hit data, country breakdown, and an overview.
 * Access is restricted to users with tier level 10 or above.
 *
 * @return \CodeIgniter\HTTP\RedirectResponse|\CodeIgniter\HTTP\ResponseInterface
 *     Redirects to homepage if unauthorized, or returns the analytics view with data.
 */
public function mobileAnalytics() {
    if (tier() < 10) {return redirect()->to('/');}
    $this->analytics = new AnalyticsModel();

    $data = [
        'title'           => 'Mobile Analytics',
        'live'            => $this->analytics->getLiveData(),
        'visitorsAndHits' => $this->analytics->getVisitorAndHitStats(10),
        'countries'       => $this->analytics->getStatsCountries(10),
        'overview'        => $this->analytics->getOverviewData(),
    ];
    return view('admin/analytics/mobile',$data);
}

} // ─── End of Class ───


