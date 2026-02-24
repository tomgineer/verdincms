<?php

/**
 * ****************************************************
 * Verdin Helper — VerdinCMS 2026 Edition
 * ****************************************************
 *
 * Provides a collection of globally available utility functions
 * used throughout the VerdinCMS system, including path helpers,
 * date/time utilities, and content formatting tools.
 *
 * Version : VerdinCMS 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * Portfolio: https://tompapatolis.com
 * License : MIT
 *
 * Notes:
 * - Designed for simplicity and global availability.
 * - Functions are optimized for reusability and readability.
 * - Fully compatible with CodeIgniter 4.x and PHP 8.3.
 *
 * ****************************************************
 */

// Tier
if(!function_exists('tier')) {
	function tier() { return session('tier') ?? 0; }
}

// Setting
if (!function_exists('setting')) {
    function setting($key) {
        static $settings;
        $settings ??= new \Config\Settings(); // Only created once per request
        return $settings->get($key); // or getSetting($key)
    }
}

// Route
if(!function_exists('get_route')) {
	function get_route() {
        $uri = service('uri', base_url());
        return $uri->getRoutePath();
	}
}

// Body Class
if ( ! function_exists('body_class')) {
    function body_class() {
        $router     = service('router');
        $controller = str_replace('\\App\\Controllers\\', '', $router->controllerName());
        return strtolower("{$controller}-{$router->methodName()}");
    }
}

// Is Admin
if ( ! function_exists('isAdmin')) {
    function isAdmin(): bool {
        $router     = service('router');
        $controller = strtolower(str_replace('\\App\\Controllers\\', '', $router->controllerName()));
        return $controller === 'admin';
    }
}

if (! function_exists('isDev')) {
	/**
	 * Determine whether the app runs in the development environment.
	 *
	 * @return bool `true` when `CI_ENVIRONMENT` equals `development`.
	 */
	function isDev(): bool {
		return strtolower((string) env('CI_ENVIRONMENT')) === 'development';
	}
}

// Blocks
if(!function_exists('block')) {
    function block($arr, $group, $alias, $element) {
        return $arr[$group][$alias][0][$element] ?? '';
    }
}

// Chart Data
if (!function_exists('chart_data')) {
    function chart_data($arr) {
        return htmlspecialchars(json_encode($arr), ENT_QUOTES, 'UTF-8');
    }
}

// Camelcase to Words
if (!function_exists('camelToWords')) {
    function camelToWords(string $input): string {
        if (trim($input) === '') {
            return '';
        }
        $spaced = preg_replace('/(?<!^)[A-Z]/', ' $0', $input);
        return ucwords($spaced);
    }
}

// Alternative Description for META
if (!function_exists('meta_description')) {

    function meta_description(?string $subtitle, string $body, int $maxWords = 100): string {
        $subtitle = trim($subtitle ?? '');

        if ($subtitle !== '') {
            return $subtitle;
        }

        // Remove entire content of unwanted tags (script, style, iframe, object, etc.)
        $body = preg_replace('#<(script|style|iframe|object|embed|noscript|video|table|figure)[^>]*>.*?</\1>#si', '', $body) ?? $body;

        // Remove comments like <!-- ... -->
        $body = preg_replace('/<!--.*?-->/s', '', $body);

        // Remove HTML tags and decode HTML entities
        $textOnly = strip_tags($body);
        $textOnly = html_entity_decode($textOnly, ENT_QUOTES | ENT_HTML5);

        // Break into words
        $words   = preg_split('/\s+/', $textOnly, -1, PREG_SPLIT_NO_EMPTY);
        $excerpt = implode(' ', array_slice($words, 0, $maxWords));

        // Append ellipsis if truncated
        if (count($words) > $maxWords) {
            $excerpt .= '...';
        }

        return $excerpt;
    }
}

// Version
if(!function_exists('ver')) {
	function ver() {
        $version = defined('VERDINCMS_VERSION') ? VERDINCMS_VERSION : 'dev';
        $build = setting('system.build');
        $build = is_numeric($build) ? (int) $build : 0;
        return $version . '-b' . $build;
    }
}
