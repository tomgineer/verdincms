<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Custom Models
 */

use App\Models\ContentModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $content;
    protected $data = [];
    protected $site_type = 'blog';

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['verdin', 'form'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Site Type
        $envSiteType = env('site.type');
        if (!empty($envSiteType)) {
            $this->site_type = $envSiteType;
        }
        service('renderer')->setVar('site_type', $this->site_type);

        // Preload any models, libraries, etc, here.
        $this->content = new ContentModel();

        // Define cache settings
        $shouldCache = setting('cache.enabled') === true && !session('logged_in');

        // Define cache keys with "arr_" prefix
        $cacheKeys = [
            'pages_list'         => 'arr_pages_list',
            'menu_items'         => 'arr_menu_items',
            'socials_list'       => 'arr_socials_list',
            'topics_list'        => 'arr_topics_list',
            'base_blocks'        => 'arr_base_blocks',
            'total_subscribers'  => 'arr_total_subscribers',
            'public_posts'       => 'arr_public_posts',
        ];

        // Fetch & cache data
        foreach ($cacheKeys as $key => $cacheKey) {
            if ($shouldCache && ($cachedData = cache($cacheKey))) {
                $this->data[$key] = $cachedData;
            } else {
                // Fetch fresh data
                switch ($key) {
                    case 'pages_list':
                        $this->data[$key] = $this->content->getPagesList();
                        break;
                    case 'menu_items':
                        $this->data[$key] = $this->content->getMenuItems();
                        break;
                    case 'socials_list':
                        $this->data[$key] = $this->content->getSocialsList();
                        break;
                    case 'topics_list':
                        $this->data[$key] = $this->content->getTopicsList();
                        break;
                    case 'base_blocks':
                        $this->data[$key] = $this->content->getBlocks(['footer', 'components']);
                        break;
                    case 'total_subscribers':
                        $this->data[$key] = $this->content->countSubscribers();
                        break;
                    case 'public_posts':
                        $this->data[$key] = $this->content->countContent('public');
                        break;
                }

                // Store in cache
                if ($shouldCache) {
                    cache()->save($cacheKey, $this->data[$key], setting("cache.lifetime"));
                }
            }
        }

        // E.g.: $this->session = \Config\Services::session();
    }
}
