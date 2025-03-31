<?php

/**
 * @brief listImages, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\listImages;

class FrontendTemplateCode
{
    /**
     * PHP code for tpl:EntryImages value
     */
    public static function EntryImages(
        string $_size_,
        string $_html_tag_,
        string $_link_,
        int $_exif_,
        string $_legend_,
        string $_bubble_,
        string $_from_,
        int $_start_,
        int $_length_,
        string $_class_,
        string $_alt_,
        string $_img_dim_,
        string $_def_size_
    ): void {
        echo \Dotclear\Plugin\listImages\FrontendHelper::EntryImages(
            $_size_,
            $_html_tag_,
            $_link_,
            $_exif_,
            $_legend_,
            $_bubble_,
            $_from_,
            $_start_,
            $_length_,
            $_class_,
            $_alt_,
            $_img_dim_,
            $_def_size_
        );
    }
}
