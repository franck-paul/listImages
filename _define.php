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

if (!defined('DC_RC_PATH')) {return;}

$this->registerModule(
    "listImages",               // Name
    "List images from entries", // Description
    "Kozlika, Franck Paul",     // Author
    '1.13',                     // Version
                                // Properties
    [
        'requires'    => [['core', '2.16']], // Dependencies
        'permissions' => 'contentadmin',
        'type'        => 'plugin',
        'support'     => 'http://forum.dotclear.org/viewforum.php?id=16',
        'details'     => 'http://plugins.dotaddict.org/dc2/details/listImages'
    ]
);
