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
if (!defined('DC_RC_PATH')) {
    return;
}

$this->registerModule(
    'listImages',               // Name
    'List images from entries', // Description
    'Kozlika, Franck Paul',     // Author
    '1.13',
    [
        'requires'    => [['core', '2.24']], // Dependencies
        'permissions' => 'contentadmin',
        'type'        => 'plugin',

        'details'    => 'https://open-time.net/?q=listImages',       // Details URL
        'support'    => 'https://github.com/franck-paul/listImages', // Support URL
        'repository' => 'https://raw.githubusercontent.com/franck-paul/listImages/master/dcstore.xml',
    ]
);
