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
    '5.6',
    [
        'date'        => '2025-02-26T16:08:11+0100',
        'requires'    => [['core', '2.30']],
        'permissions' => 'My',
        'type'        => 'plugin',

        'details'    => 'https://open-time.net/?q=listImages',
        'support'    => 'https://github.com/franck-paul/listImages',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/listImages/main/dcstore.xml',
    ]
);
