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

    public static function renderWidget(WidgetsElement $w): string
    {
        $params = [];
        // Si l'affichage du widget est désactivé, on ressort
        if ($w->offline) {
            return '';
        }

        // Si l'affichage du widget est demandé sur la page d'accueil uniquement et qu'on y est pas, on ressort
        if (($w->homeonly == 1 && !App::url()->isHome(App::url()->getType())) || ($w->homeonly == 2 && App::url()->isHome(App::url()->getType()))) {
            return '';
        }

        // Mise en place des paramètres de recherche par défaut
        $params['no_content'] = false;

        // Récupération de la limite du nb de billets dans lesquels rechercher des images
        $limit = is_numeric($limit = $w->get('limit')) ? abs((int) $limit) : 0;
        if ($limit > 0) {
            $params['limit'] = $limit;
        }

        // Récupération de la ou des catégories spécifiées
        $category = is_string($category = $w->get('category')) ? $category : '';
        if ($category !== '') {
            $params['cat_url'] = explode(',', $category);
        }

        // Récupération de l'indicateur de billet sélectionné
        $selected = is_numeric($selected = $w->get('selected')) && (bool) $selected;
        if ($selected) {
            $params['post_selected'] = '1';
        }

        // Recherche des billets correspondants
        $rs = App::blog()->getPosts($params);

        // Récupération des options d'affichage des images
        $size     = is_string($size = $w->get('size')) ? $size : '';
        $html_tag = is_string($html_tag = $w->get('html_tag')) ? $html_tag : '';
        $link     = is_string($link = $w->get('link')) ? $link : '';
        $exif     = 0;
        $legend   = is_string($legend = $w->get('legend')) ? $legend : '';
        $bubble   = is_string($bubble = $w->get('bubble')) ? $bubble : '';
        $from     = is_string($from = $w->get('from')) ? $from : '';
        $start    = is_numeric($start = $w->get('start')) ? abs((int) $start) : 0;
        $length   = is_numeric($length = $w->get('length')) ? abs((int) $length) : 0;
        $class    = $w->class;
        $alt      = is_string($alt = $w->get('alt')) ? $alt : '';
        $img_dim  = is_string($img_dim = $w->get('img_dim')) ? $img_dim : '';
        $def_size = is_string($def_size = $w->get('def_size')) ? $def_size : '';

        // Début d'affichage
        $ret = ($w->title ? $w->renderTitle(Html::escapeHTML($w->title)) : '');
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

        return $w->renderDiv((bool) $w->content_only, 'listimages-widget ' . $w->class, '', $ret);
    }
}
