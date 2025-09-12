<?php
use App\Libraries\SystemCore;

/**
 * ****************************************************
 * Verdin Helper — Voralis Core 2026 Edition
 * ****************************************************
 *
 * Provides a collection of globally available utility functions
 * used throughout the VerdinCMS system, including path helpers,
 * date/time utilities, and content formatting tools.
 *
 * Version : Voralis Core 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Notes:
 * - Designed for simplicity and global availability.
 * - Functions are optimized for reusability and readability.
 * - Fully compatible with CodeIgniter 4.x and PHP 8.3.
 *
 * ****************************************************
 */

if (!function_exists('path')) {
    /**
     * Returns a base path for assets like CSS, JS, images, etc.
    *
    * @param string $type Valid options: css, js, gfx, img, img_tn, blocks, blocks_tn, avatar, assets
    * @return string
    */
    function path(string $type): string {
        return match ($type) {
            'css'        => base_url('css/'),
            'js'         => base_url('js/'),
            'gfx'        => base_url('gfx/'),
            'img'        => base_url('images/'),
            'img_tn'     => base_url('images/tn/'),
            'img_xs'     => base_url('images/xs/'),
            'blocks'     => base_url('images/blocks/'),
            'blocks_tn'  => base_url('images/blocks/tn/'),
            'avatar'     => base_url('images/avatars/tn/'),
            'assets'     => base_url('assets/'),
            'audio'      => base_url('audio/'),
            default      => base_url(),
        };
    }
 }

// Backward-compatible wrappers
if (!function_exists('path_css')) {
    function path_css() { return path('css'); }
}
if (!function_exists('path_js')) {
    function path_js() { return path('js'); }
}
if (!function_exists('path_gfx')) {
    function path_gfx() { return path('gfx'); }
}
if (!function_exists('path_img')) {
    function path_img() { return path('img'); }
}
if (!function_exists('path_img_tn')) {
    function path_img_tn() { return path('img_tn'); }
}
if (!function_exists('path_img_xs')) {
    function path_img_xs() { return path('img_xs'); }
}
if (!function_exists('path_blocks')) {
    function path_blocks() { return path('blocks'); }
}
if (!function_exists('path_blocks_tn')) {
    function path_blocks_tn() { return path('blocks_tn'); }
}
if (!function_exists('path_avatar')) {
    function path_avatar() { return path('avatar'); }
}
if (!function_exists('path_assets')) {
    function path_assets() { return path('assets'); }
}
if (!function_exists('path_audio')) {
    function path_audio() { return path('audio'); }
}

// SVG
if (!function_exists('svg')) {
    function svg($id) { return '#'.$id;}
}

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

// Number Format
if(!function_exists('nf')) {
	function nf($number) { return number_format($number,0,'.',','); }
}

// Read Time
if(!function_exists('read_time')) {
    function read_time($words) {
        return is_numeric($words) ? number_format((int) $words / 150, 1, '.', ',') : '0';
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

// Database Timestamp
if (!function_exists('db_now')) {
    function db_now(): string {
        $db = db_connect();
        return $db->query('SELECT NOW() AS db_now')->getRow('db_now');
    }
}

// Blocks
if(!function_exists('block')) {
    function block($arr, $group, $alias, $element) {
        return $arr[$group][$alias][0][$element] ?? '';
    }
}

// Is Mobile
if (!function_exists('is_mobile')) {
    function is_mobile(): bool {
        $agent = \Config\Services::request()->getUserAgent();
        return $agent && $agent->isMobile();
    }
}

// Empty Image
if(!function_exists('empty_img')) {
	function empty_img() {
		return 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=';
	}
}

// Module Exists
if(!function_exists('module_exists')) {
	function module_exists($module) {
        return file_exists(APPPATH.'Views/modules/'.$module.'.php');
	}
}

// QR Code Exists
if (!function_exists('qr_code_exists')) {
    function qr_code_exists($postId) {
        $filePath = FCPATH . 'images' . DIRECTORY_SEPARATOR . 'qrcodes' . DIRECTORY_SEPARATOR . 'post_' . $postId . '.svg';

        if (!file_exists($filePath)) {
            // Create the QR code if it doesn't exist
            (new SystemCore())->createQrCode($postId);
        }

        return file_exists($filePath); // Return true if it now exists
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

