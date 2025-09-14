<?php namespace App\Controllers;
use App\Models\DashboardModel;
use App\Models\ActionsModel;
use App\Models\SystemModel;
use App\Models\AnalyticsModel;
use App\Models\EditContentModel;
use App\Libraries\SystemCore;
use CodeIgniter\API\ResponseTrait;

class Admin extends BaseController {

    private $dash;
    private $analytics;
    private $system;
    private $edit;

	use ResponseTrait;

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

    $data = array_merge($this->data, [
        'title'        => "Edit " . ucfirst($type) . ": {$id}",
        'type'         => $type,
        'statusLabels' => [1 => 'Published', 2 => 'Draft', 3 => 'Deleted'],
        'statusColors' => [1 => 'success', 2 => 'warning', 3 => 'error'],
        'post'         => $this->edit->getContent($type, $id),
        'users'        => $this->edit->getUsers(),
        'user_groups'  => $this->edit->getUserGroups(),
        'topics'       => $this->edit->getTopics(),
        'sections'     => $this->edit->getSections(),
    ]);

    return view('edit/edit',$data);
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

    $data = [...$this->data,
        'site_title' => ucwords($type),
        'post_data'  => $post_data,
        'stats' => [[
            'title' => ucfirst($type),
            'value' => $this->content->countContent($type),
            'desc'  => $descriptions[$type] ?? 'Pending'
        ]]
    ];

    // Render view
    return view('site/list', $data);
}

/**
 * Displays various administrative dashboard views based on URL path segments.
 *
 * Depending on the provided segments, this method loads analytics, system info,
 * content management, user accounts, logs, settings, and other backend tools.
 * It uses `DashboardModel`, `AnalyticsModel`, and `SystemModel` to gather and
 * merge relevant data before rendering the appropriate dashboard view.
 *
 * Access is restricted to users with tier level 10 or higher.
 *
 * Supported paths include:
 * - Home: visitor charts, admin links, content activity
 * - Info: system overview, PHP info, session data
 * - Review: posts or pages needing approval
 * - Subjects: topic and section management with modal editing
 * - Latest: recently created posts/pages
 * - Accounts: user management with form and file handling
 * - Logs: cron, hits, error logs
 * - Archive: archived posts and pages
 * - Settings: application settings grouped for editing
 * - Trash: orphaned content, photos, or deleted accounts
 * - Blocks: reusable content blocks with modal editing
 *
 * @param string ...$segments One or more optional URL segments determining the dashboard section to show.
 *
 * @return \CodeIgniter\HTTP\RedirectResponse|\CodeIgniter\HTTP\ResponseInterface
 *     Redirects to homepage if unauthorized or path is invalid,
 *     otherwise returns the corresponding dashboard view with data.
 */
public function dashboard(...$segments) {
    if (tier() < 10) {return redirect()->to('/');}
    $path = implode('/', $segments);

    $data = array_merge($this->data, [
        'path'  => $path,
        'title' => 'Dashboard'
    ]);

    $this->dash = new DashboardModel();

    switch ($path) {
        case '';
            $this->analytics = new AnalyticsModel();
            $this->system    = new SystemModel();

            $data = array_merge($data, [
                'path'               => 'home/home',
                'useChartJS'         => true,
                'chart_visitors'     => $this->analytics->getVisitorAndHitStats(14, true),
                'posting_activity'   => $this->analytics->getDailyCreationCounts(),
                'actions'            => (new ActionsModel)->getActionsArray(),
                'admin_links'        => $this->dash->getAdminLinks(),
                'sortables'          => $this->dash->getSortablesArray(),
                'data_sort_pages'    => $this->system->sortBuilder('pages', 'title'),
                'data_sort_topics'   => $this->system->sortBuilder('topics', 'title'),
                'data_sort_sections' => $this->system->sortBuilder('sections', 'title'),
                'data_sort_settings' => $this->system->sortBuilder('setting_groups', 'title')
            ]);

            break;
        case 'info/overview':
            $data['info'] = $this->dash->getSystemAndDatabaseInfo();
            break;
        case 'info/environment':
            $data['php_info'] = $this->dash->getPhpInfo();
            $data['gd_info']  = gd_info();
            break;
        case 'info/session':
            $data['session_data'] = session()->get();
            break;
        case 'review/posts':
            $data['posts'] = $this->dash->needReview('post');
            break;
        case 'review/pages':
            $data['pages'] = $this->dash->needReview('page');
            break;
        case 'subjects/topics':
            $data = array_merge($data, [
                'useCKEditor' => true,
                'topics'      => $this->dash->getSubjects('topics'),
                'modal_data'  => (new SystemModel)->formBuilder(table: 'topics', hidden: ['id', 'position', 'posts'])
            ]);
            break;
        case 'subjects/sections':
            $data = array_merge($data, [
                'useCKEditor' => true,
                'sections'    => $this->dash->getSubjects('sections'),
                'modal_data'  => (new SystemModel)->formBuilder(table: 'sections', hidden: ['id', 'position'])
            ]);
            break;
        case 'latest/posts':
            $data['posts'] = $this->dash->getLatestContent('post', 10);
            break;
        case 'latest/pages':
            $data['pages'] = $this->dash->getLatestContent('page', 10);
            break;
        case 'accounts/users':
            $data = array_merge($data, [
                'users'       => $this->dash->getUserData(),
                'modal_data'  => (new SystemModel)->formBuilder(
                    table: 'users',
                    dropdowns: ['user_group_id' => ['user_groups', 'title']],
                    uploads: ['avatar' => 'public/images/avatars'],
                    hidden: ['id', 'password', 'standin_id', 'modified']
                )
            ]);

            break;
        case 'logs/cron':
            $data['crons'] = $this->dash->getCronLog(10);
            break;
        case 'logs/hits':
            $data['hits'] = $this->dash->getHitsEntries(20);
            break;
        case 'logs/error':
            $data['errors'] = $this->dash->getErrorLogs();
            break;
        case 'archive/archive':
            $data['posts'] = $this->dash->getArchivedContent('post');
            $data['pages'] = $this->dash->getArchivedContent('page');
            break;
        case 'settings/settings':
            $data = array_merge($data, [
                'settings'    => $this->dash->getSettings(),
                'modal_data'  => (new SystemModel)->formBuilder(
                    table: 'settings',
                    dropdowns: ['setting_group_id' => ['setting_groups', 'title']],
                    hidden: ['id', 'position']
                )
            ]);

            break;
        case 'trash/photos':
            $data['photos'] = (new SystemModel())->getOrphanPhotos();
            break;
        case 'trash/content':
            $data['content'] = [
                'posts' => $this->dash->getArchivedContent('post', 3),
                'pages' => $this->dash->getArchivedContent('page', 3)
            ];
            break;
        case 'trash/accounts':
            $data['accounts'] = [
                'users'   => $this->dash->getUserData('0')
            ];
            break;
        case 'blocks/blocks':
            $data = array_merge($data, [
                'useCKEditor' => true,
                'blocks'      => $this->dash->getBlocks(),
                'modal_data'  => (new SystemModel)->formBuilder(
                    table: 'blocks',
                    dropdowns: ['block_group_id' => ['block_groups', 'title']],
                    uploads: ['image' => 'public/images/blocks', 'background' => 'public/images/blocks'],
                    hidden: ['id']
                )
            ]);
            break;
        default:
            return redirect()->to('/');
            break;
    }

    return view('dashboard/dashboard', $data);
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
    $data = array_merge($this->data, [
        'path'  => $path,
        'title' => 'Analytics'
    ]);

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

    return view('analytics/analytics',$data);
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
    return view('analytics/mobile',$data);
}

} // ─── End of Class ───
