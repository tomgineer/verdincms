<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\StatsModel;

/**
 * ****************************************************
 * BotRedirectFilter — VerdinCMS 2026 Edition
 * ****************************************************
 *
 * A request-level filter for detecting and redirecting unwanted bots
 * based on user agent strings and geographic IP location.
 *
 * Version : VerdinCMS 2026
 * Author  : Tom Papatolis
 * GitHub  : https://github.com/tomgineer/verdincms
 * License : MIT
 *
 * Features
 * --------
 * • Allows known search and social media bots via User-Agent whitelist
 * • Blocks suspicious bots using keyword heuristics
 * • Redirects unidentified bots to a honeypot endpoint (e.g. /botshield)
 * • Optionally blocks traffic from specific countries based on IP geolocation
 *
 * Notes
 * -----
 * - Automatically disabled in development and CLI environments
 * - Depends on StatsModel::getIpLocation() for IP geolocation
 *
 * ****************************************************
 */

class BotRedirectFilter implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null) {
        return;

        // Skip all logic if in development environment
        if (ENVIRONMENT === 'development') {
            return; // Allow request
        }

        // Skip for CLI requests (e.g., from cron jobs)
        if ($request->isCLI()) {
            return; // skip the filter
        }

        $agent = $request->getUserAgent()->getAgentString() ?? '';

        // Redirect if User-Agent is empty
        if (empty($agent)) {
            return redirect()->to(site_url('botshield'));
        }

        // Whitelist Bots
        $allowedBots = [
            'Googlebot',
            'Bingbot',
            'facebookexternalhit',
            'Twitterbot',
            'LinkedInBot',
            'Pinterestbot',
            'WhatsApp',
            'TelegramBot',
        ];

        foreach ($allowedBots as $allowedBot) {
            if (stripos($agent, $allowedBot) !== false) {
                return; // Allow request
            }
        }

        // Bot detection by User-Agent keywords
        $botSignatures = [
            'bot', 'crawl', 'slurp', 'spider', 'curl', 'wget', 'python', 'ai', 'scrapy', 'httpclient', 'libwww'
        ];

        foreach ($botSignatures as $bot) {
            if (stripos($agent, $bot) !== false) {
                return redirect()->to(site_url('botshield'));
            }
        }

        // Country check using cached IP location
        // if (setting('system.ip2location') === true) {
        //     $ip = $request->getIPAddress();
        //     $statsModel = new StatsModel();
        //     $geo = $statsModel->getIpLocation($ip);

        //     $blockedCountries = [
        //         'China',
        //         'Russian Federation',
        //         'Ukraine',
        //         'India',
        //         'Brazil',
        //         'Indonesia',
        //         'Vietnam',
        //         'Pakistan',
        //         'Iran',
        //         'Bangladesh',
        //         'Nigeria',
        //         'Israel',
        //         'Lithuania',
        //         'Kazakhstan',
        //     ];

        //     if (in_array($geo['country'], $blockedCountries, true)) {
        //         return redirect()->to('https://www.google.com');
        //     }
        // }

        // No return = continue normally
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
        // Nothing needed after
    }
}
