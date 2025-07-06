<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use CodeIgniter\HotReloader\HotReloader;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', static function (): void {
    if (ENVIRONMENT !== 'testing') {
        if (ini_get('zlib.output_compression')) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static fn ($buffer) => $buffer);
    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (CI_DEBUG && ! is_cli()) {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        service('toolbar')->respond();
        // Hot Reload route - for framework use on the hot reloader.
        if (ENVIRONMENT === 'development') {
            service('routes')->get('__hot-reload', static function (): void {
                (new HotReloader())->run();
            });
        }
    }
});

/**
 * Sets the MySQL session time zone based on the current PHP time zone.
 *
 * This ensures that MySQL date/time functions (e.g. NOW()) reflect the same offset as PHP,
 * including proper adjustment for daylight saving time (DST) when applicable.
 *
 * Applied automatically on each request after the controller is constructed.
 */
Events::on('post_controller_constructor', function () {
    $appConfig = new \Config\App();
    $tz = new \DateTimeZone($appConfig->appTimezone);
    $now = new \DateTime('now', $tz);
    $offsetHours = $tz->getOffset($now) / 3600;
    $offsetFormatted = sprintf('%+03d:00', $offsetHours);
    $db = \Config\Database::connect();
    $db->query("SET time_zone = '{$offsetFormatted}'");
});
