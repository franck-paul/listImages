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
declare(strict_types=1);

if (isset($this) && is_object($this) && method_exists($this, 'registerModule') && isset($this->id) && is_string($this->id)) {
    $this->registerModule(
        'listImages',
        'List images from entries',
        'Kozlika, Franck Paul',
        '10.0',
        [
            'date'     => '2026-11-08T10:16:24+0100',
            'requires' => [
                ['core', '2.40'],
                ['TemplateHelper'],
            ],
            'permissions' => 'My',
            'type'        => 'plugin',

            'details'    => 'https://open-time.net/?q=listImages',
            'support'    => 'https://github.com/franck-paul/listImages',
            'repository' => 'https://raw.githubusercontent.com/franck-paul/listImages/main/dcstore.xml',
            'license'    => 'gpl2',
        ]
    );
}
