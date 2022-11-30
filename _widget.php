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

class EntryImagesBehaviors
{
    public static function initWidgets($w)
    {
        $w
            ->create(
                'EntryImages',
                __('List entry images'),
                ['widgetEntryImages', 'EntryImages'],
                null,
                __('List entry images by listImages plugin')
            )

            // Titre du widget
            ->addTitle(__('Last images'))

            // Paramètres de recherche des billets
            ->setting('limit', __('Limit (empty means no limit):'), '3')
            ->setting('category', __('Category list:'), '', 'text')
            ->setting('selected', __('Selected posts'), 0, 'check')

            // Paramètres d'affichage
            ->setting(
                'size',
                __('Image size'),
                1,
                'combo',
                [
                    'thumbnail' => 't',
                    'square'    => 'sq',
                    'small'     => 's',
                    'medium'    => 'm',
                    'original'  => 'o',
                ]
            )
            ->setting(
                'def_size',
                __('Default image size'),
                1,
                'combo',
                [
                    'square'   => 'sq',
                    'original' => 'o',
                    'none'     => 'none',
                ]
            )
            ->setting(
                'html_tag',
                __('HTML tag'),
                1,
                'combo',
                [
                    'span' => 'span',
                    'list' => 'li',
                    'div'  => 'div',
                    'none' => 'none',
                ]
            )
            ->setting(
                'link',
                __('Image link'),
                1,
                'combo',
                [
                    'image' => 'image',
                    'entry' => 'entry',
                    'none'  => 'none',
                ]
            )
            ->setting(
                'from',
                __('Search image in'),
                1,
                'combo',
                [
                    __('content and excerpt') => 'full',
                    __('excerpt only')        => 'excerpt',
                    __('content only')        => 'content',
                ]
            )
            ->setting(
                'legend',
                __('Legend'),
                1,
                'combo',
                [
                    'none'  => 'none',
                    'image' => 'image',
                    'entry' => 'entry',
                ]
            )
            ->setting(
                'bubble',
                __('Image title'),
                1,
                'combo',
                [
                    'none'  => 'none',
                    'image' => 'image',
                    'entry' => 'entry',
                ]
            )

            ->setting(
                'alt',
                __('Alt attribute'),
                1,
                'combo',
                [
                    'inherit' => 'inherit',
                    'none'    => 'none',
                ]
            )
            ->setting('img_dim', __('Includes width and height of image'), 0, 'check')

            ->setting('start', __('Start from'), '1')
            ->setting('length', __('Number (empty or 0 = all)'), '0')

            ->addHomeOnly()
            ->addContentOnly()
            ->addClass()
            ->addOffline();
    }
}

dcCore::app()->addBehavior('initWidgets', [EntryImagesBehaviors::class, 'initWidgets']);
