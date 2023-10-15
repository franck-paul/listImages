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

use dcCore;

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
        if (($w->homeonly == 1 && !dcCore::app()->url->isHome(dcCore::app()->url->type)) || ($w->homeonly == 2 && dcCore::app()->url->isHome(dcCore::app()->url->type))) {
            return '';
        }

        // Mise en place des paramètres de recherche par défaut
        $params['no_content'] = false;

        // Récupération de la limite du nb de billets dans lesquels rechercher des images
        $params['limit'] = abs((int) $w->limit);

        // Récupération de la ou des catégories spécifiées
        if ($w->category != '') {
            $category          = $w->category;
            $params['cat_url'] = explode(',', $category);
        }

        // Récupération de l'indicateur de billet sélectionné
        if ($w->selected == '1') {
            $params['post_selected'] = '1';
        }

        // Recherche des billets correspondants
        $rs = dcCore::app()->blog->getPosts($params);

        // Récupération des options d'affichage des images
        $size     = $w->size;
        $html_tag = $w->html_tag;
        $link     = $w->link;
        $exif     = 0;
        $legend   = $w->legend;
        $bubble   = $w->bubble;
        $from     = $w->from;
        $start    = abs((int) $w->start);
        $length   = abs((int) $w->length);
        $class    = $w->class;
        $alt      = $w->alt;
        $img_dim  = $w->img_dim;
        $def_size = $w->def_size;

        // Début d'affichage
        $ret = ($w->title ? $w->renderTitle(Html::escapeHTML($w->title)) : '');
        $ret .= '<' . ($html_tag == 'li' ? 'ul' : 'div') . ' class="listimages-wrapper">';

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
        $ret .= '</' . ($html_tag == 'li' ? 'ul' : 'div') . '>' . "\n";

        return $w->renderDiv((bool) $w->content_only, 'listimages-widget ' . $w->class, '', $ret);
    }
}
