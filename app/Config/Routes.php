<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Site::index');
//$routes->set404Override('App\Controllers\Site::handle404');

/**
 * --------------------------------------------------------------------
 * Custom Routes
 * --------------------------------------------------------------------
 */

//  (:any) -> will match all characters from that point to the end of the URI. This may include multiple URI segments.
//  (:segment) -> will match any character except for a forward slash (/) restricting the result to a single segment.
//  (:num) -> will match any integer.
//  (:alpha) -> will match any string of alphabetic characters
//  (:alphanum) -> will match any string of alphabetic characters or integers, or any combination of the two.
//  (:hash) -> is the same as (:segment), but can be used to easily see which routes use hashed ids.

/******************************************************************************
 * SITE
 *****************************************************************************/
$routes->get('post/(:num)', 'Site::post/$1');
$routes->get('print/(:num)', 'Site::print/$1');
$routes->get('author/(:alpha)', 'Site::author/$1');
$routes->get('ranking/(:alpha)', 'Site::ranking/$1');
$routes->match(['GET','POST'],'search', 'Site::search');
$routes->get('featured', 'Site::featured');
$routes->get('botshield', 'Site::botshield');

/******************************************************************************
 * USERS
 *****************************************************************************/
$routes->post('users/login', 'Users::login');
$routes->get('users/logout', 'Users::logout');
$routes->get('login', 'Users::login_page');

/******************************************************************************
 * CRON
 *****************************************************************************/
$routes->cli('cron/doWork', 'Cron::doWork');
$routes->cli('cron/doWorkAll', 'Cron::doWorkAll'); // Legacy
$routes->cli('cron/ai', 'Cron::ai');

/******************************************************************************
 * AJAX
 *****************************************************************************/
// Edit Content
$routes->post('ajax/uploadContentPhoto', 'Ajax::uploadContentPhoto');
$routes->post('ajax/uploadInlinePhoto', 'Ajax::uploadInlinePhoto');
$routes->post('ajax/saveContent', 'Ajax::saveContent');
$routes->post('ajax/checkPhotoExists', 'Ajax::checkPhotoExists');

// Dashboard
$routes->get('ajax/get_dashboard_page/(:any)', 'Ajax::get_dashboard_page/$1');
$routes->post('ajax/run_action/(:segment)', 'Ajax::run_action/$1');
$routes->post('ajax/update_setting', 'Ajax::update_setting');

// Modals
$routes->match(['GET', 'POST'], 'ajax/modalFillSelect', 'Ajax::modalFillSelect');
$routes->match(['GET', 'POST'], 'ajax/modalFillForm', 'Ajax::modalFillForm');
$routes->match(['GET', 'POST'], 'ajax/modalSaveForm', 'Ajax::modalSaveForm');

/******************************************************************************
 * ADMIN
 *****************************************************************************/
$routes->match(['GET','POST'], 'admin/edit/(:alpha)/(:alphanum)', 'Admin::edit/$1/$2');
$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('admin/dashboard/(:any)', 'Admin::dashboard/$1');
$routes->get('admin/analytics', 'Admin::analytics');
$routes->get('admin/mobile-analytics', 'Admin::mobileAnalytics');
$routes->get('admin/analytics/(:any)', 'Admin::analytics/$1');
$routes->get('admin/moderate/(:alpha)', 'Admin::moderate/$1');

/******************************************************************************
 * TOPICS & PAGES INIT
 *****************************************************************************/
$siteController = new \App\Controllers\Site();
$siteController->setupTopicRoutes();
$siteController->setupPageRoutes();