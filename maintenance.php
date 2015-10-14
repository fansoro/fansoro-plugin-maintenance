<?php

/**
 * Morfy Maintenance Plugin
 *
 * (c) Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (Morfy::$plugins['maintenance']['enabled']) {
    Morfy::factory()->addAction('before_render', function () {

        Morfy::$site[theme] = 'maintenance';

        $fenom = Fenom::factory(
            THEMES_PATH . '/maintenance/',
            CACHE_PATH . '/fenom/',
            Morfy::$fenom
        );

        // Do global tag {$.site} for the template
        $fenom->addAccessorSmart('site', 'site_config', Fenom::ACCESSOR_PROPERTY);
        $fenom->site_config = static::$site;

        Response::status(503);
        Request::setHeaders('Status: 503 Service Temporarily Unavailable');
        Request::setHeaders('Retry-After: 3600');
        $fenom->display('maintenance.tpl');
        Request::shutdown();

    });
}
