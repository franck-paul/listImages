<?php
/**
 * @brief listImages, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Kozlika, Franck Paul and contributors
 *
 * @copyright Kozlika, Franck Paul
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
$this->registerModule(
    'listImages',
    'List images from entries',
    'Kozlika, Franck Paul',
    '3.1.1',
    [
        'requires'    => [['core', '2.27'], ['php', '8.1']],
        'permissions' => dcCore::app()->auth->makePermissions([
            dcAuth::PERMISSION_CONTENT_ADMIN,
        ]),
        'type' => 'plugin',

        'details'    => 'https://open-time.net/?q=listImages',
        'support'    => 'https://github.com/franck-paul/listImages',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/listImages/master/dcstore.xml',
    ]
);
