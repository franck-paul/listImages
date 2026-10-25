<?php

/**
 * @brief listImages, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul contact@open-time.net
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\listImages;

use Dotclear\App;
use Dotclear\Helper\Html\Html;
use Dotclear\Plugin\widgets\WidgetsElement;

class FrontendWidgets
{
    // Code de traitement du widget
    // ----------------------------

    public static function renderWidget(WidgetsElement $widgetsElement): string
    {
        $params = [];
        // Si l'affichage du widget est désactivé, on ressort
        if ($widgetsElement->isOffline()) {
            return '';
        }

        // Si l'affichage du widget est demandé sur la page d'accueil uniquement et qu'on y est pas, on ressort
        if (!$widgetsElement->checkHomeOnly(App::url()->getType())) {
            return '';
        }

        // Mise en place des paramètres de recherche par défaut
        $params['no_content'] = false;

        // Récupération de la limite du nb de billets dans lesquels rechercher des images
        $limit = is_numeric($limit = $widgetsElement->get('limit')) ? abs((int) $limit) : 0;
        if ($limit > 0) {
            $params['limit'] = $limit;
        }

        // Récupération de la ou des catégories spécifiées
        $category = is_string($category = $widgetsElement->get('category')) ? $category : '';
        if ($category !== '') {
            $params['cat_url'] = explode(',', $category);
        }

        // Récupération de l'indicateur de billet sélectionné
        $selected = is_numeric($selected = $widgetsElement->get('selected')) && (bool) $selected;
        if ($selected) {
            $params['post_selected'] = '1';
        }

        // Recherche des billets correspondants
        $rs = App::blog()->getPosts($params);

        // Récupération des options d'affichage des images
        $size     = is_string($size = $widgetsElement->get('size')) ? $size : '';
        $html_tag = is_string($html_tag = $widgetsElement->get('html_tag')) ? $html_tag : '';
        $link     = is_string($link = $widgetsElement->get('link')) ? $link : '';
        $exif     = 0;
        $legend   = is_string($legend = $widgetsElement->get('legend')) ? $legend : '';
        $bubble   = is_string($bubble = $widgetsElement->get('bubble')) ? $bubble : '';
        $from     = is_string($from = $widgetsElement->get('from')) ? $from : '';
        $start    = is_numeric($start = $widgetsElement->get('start')) ? abs((int) $start) : 0;
        $length   = is_numeric($length = $widgetsElement->get('length')) ? abs((int) $length) : 0;
        $class    = $widgetsElement->getClass();
        $alt      = is_string($alt = $widgetsElement->get('alt')) ? $alt : '';
        $img_dim  = is_string($img_dim = $widgetsElement->get('img_dim')) ? $img_dim : '';
        $def_size = is_string($def_size = $widgetsElement->get('def_size')) ? $def_size : '';

        // Début d'affichage
        $ret = ($widgetsElement->getTitle() !== '' ? $widgetsElement->renderTitle(Html::escapeHTML($widgetsElement->getTitle())) : '');
        $ret .= '<' . ($html_tag === 'li' ? 'ul' : 'div') . ' class="listimages-wrapper">';

        // Appel de la fonction de traitement pour chacun des billets
        while ($rs->fetch()) {
            $ret .= FrontendHelper::EntryImages(
                $size,
                $html_tag,
                $link,
                $exif,
                $legend,
                $bubble,
                $from,
                $start,
                $length,
                $class,
                $alt,
                $img_dim,
                $def_size,
                $rs
            );
        }

        // Fin d'affichage
        $ret .= '</' . ($html_tag === 'li' ? 'ul' : 'div') . '>' . "\n";

        return $widgetsElement->renderDiv($widgetsElement->getContentOnly(), 'listimages-widget ' . $widgetsElement->getClass(), '', $ret);
    }
}
