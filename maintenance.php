<?php

/**
 * Fansoro Maintenance Plugin
 *
 * (c) Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (Config::get('plugins.maintenance.enabled')) {
    Action::add('before_page_rendered', function () {

        Config::set('system.theme', 'maintenance');

        $template = Template::factory(THEMES_PATH . '/maintenance/');

        Response::status(503);
        Request::setHeaders('Status: 503 Service Temporarily Unavailable');
        Request::setHeaders('Retry-After: 3600');
        $template->display('maintenance.tpl');
        Request::shutdown();

    });
}
