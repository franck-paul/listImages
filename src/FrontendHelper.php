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

use Dotclear\App;
use Dotclear\Database\MetaRecord;
use Dotclear\Helper\File\Path;
use Dotclear\Helper\Html\Html;

class FrontendHelper
{
    // Code utilisé par la balise compilée
    // -----------------------------------

    /**
     * List of searchable extensions
     *
     * @var        array<int, string>
     */
    private static array $extensions = [
        'jpg', 'jpeg', 'gif','png','svg','webp','avif',
    ];

    /**
     * Fonction de génération de la liste des images ciblées par la balise template
     *
     * @param      string           $size      The thumb size
     * @param      string           $html_tag  The html tag
     * @param      string           $link      The link
     * @param      int              $exif      The exif
     * @param      string           $legend    The legend
     * @param      string           $bubble    The bubble
     * @param      string           $from      The from
     * @param      int              $start     The start
     * @param      int              $length    The length
     * @param      string           $class     The class
     * @param      string           $alt       The alternate
     * @param      string           $img_dim   The image dim
     * @param      string           $def_size  The definition size
     * @param      null|MetaRecord  $rs        { parameter_description }
     */
    public static function EntryImages(
        string $size,
        string $html_tag,
        string $link,
        int $exif,
        string $legend,
        string $bubble,
        string $from,
        int $start,
        int $length,
        string $class,
        string $alt,
        string $img_dim,
        string $def_size,
        ?MetaRecord $rs = null
    ): string {
        // Contrôle des valeurs fournies et définition de la valeur par défaut pour les attributs
        $media = App::media();
        $sizes = implode('|', array_keys($media->getThumbSizes()));
        if (!preg_match('/^' . $sizes . '|o' . '$/', $size)) {
            $size = 't';
        }

        if (!preg_match('/^span|li|div|none$/', $html_tag)) {
            $html_tag = 'span';
        }

        if (!preg_match('/^entry|image|none$/', $link)) {
            $link = 'image';
        }

        if (!preg_match('/^entry|image|none$/', $legend)) {
            $legend = 'none';
        }

        if (!preg_match('/^entry|image|none$/', $bubble)) {
            $bubble = 'image';
        }

        if (!preg_match('/^excerpt|content|full$/', $from)) {
            $from = 'full';
        }

        if (!preg_match('/^none|inherit$/', $alt)) {
            $alt = 'inherit';
        }

        if (!preg_match('/^sq|o|none$/', $def_size)) {
            $def_size = 'o';
        }

        $start  = ($start > 0 ? $start - 1 : 0);
        $length = (max($length, 0));

        // Récupération de l'URL du dossier public
        $p_url = App::blog()->settings()->system->public_url;
        // Récupération du chemin du dossier public
        $p_root = App::blog()->publicPath();

        // Contruction du pattern de recherche de la source des images dans les balises img
        // -> à noter que seules les images locales sont traitées
        $p_site       = (string) preg_replace('#^(.+?//.+?)/(.*)$#', '$1', (string) App::blog()->url());
        $pattern_path = '(?:' . preg_quote($p_site, '/') . ')?' . preg_quote((string) $p_url, '/');
        $pattern_src  = sprintf('/src="%s(.*?\.(?:' . implode('|', self::$extensions) . '))"/msui', $pattern_path);

        // Buffer de retour
        $res = '';

        // Si aucune liste de billet n'est fournie en paramètre, on utilise le contexte courant
        if (is_null($rs)) {
            $rs = App::frontend()->context()->posts;
        }

        if (is_null($rs)) {
            return '';
        }

        if (!$rs->isEmpty()) {
            // Recherche dans le contenu du billet
            $subject = ($from !== 'content' ? $rs->post_excerpt_xhtml : '') . ($from !== 'excerpt' ? $rs->post_content_xhtml : '');

            if (preg_match_all('/<img(.*?)\/\>/msu', $subject, $m) > 0) {
                // Récupération du nombre d'images trouvées
                $img_count = count($m[0]);

                // Contrôle des possibilités par rapport aux début demandé
                if (($img_count - $start) > 0) {
                    // Au moins une image est disponible, calcul du nombre d'image à lister
                    if ($length === 0) {
                        $length = $img_count;
                    }

                    $length = min($img_count, $start + $length);

                    for ($idx = $start; $idx < $length; ++$idx) {
                        // Récupération de la source de l'image dans le contenu (attribut src de la balise img)
                        $i = (preg_match($pattern_src, $m[1][$idx], $src) ? $src[1] : '');
                        if ($i !== '') {
                            // Recherche de l'image au format demandé
                            $orientation = '';
                            $dim         = [];
                            if (($src_img = self::ContentImageLookup($p_root, $i, $size, $orientation, $dim, $sizes, $def_size)) !== false) {
                                // L'image existe, on construit son URL
                                $src_img = $p_url . (dirname($i) !== '/' ? dirname($i) : '') . '/' . $src_img;
                                // Recherche alt et title
                                $img_alt    = (preg_match('/alt="(.*?)"/msu', $m[1][$idx], $alt_value) ? $alt_value[1] : '');
                                $img_title  = (preg_match('/title="(.*?)"/msu', $m[1][$idx], $title_value) ? $title_value[1] : '');
                                $img_legend = '';
                                if ($legend !== 'none') {
                                    // Une légende est requise
                                    if ($legend === 'image') {
                                        // On utilise les attributs de la balise image
                                        if ($img_title !== '' || $img_alt !== '') {
                                            // On utilise l'attribut title s'il existe sinon l'attribut alt s'il existe
                                            $img_legend = ($img_title !== '' ? $img_title : $img_alt);
                                        } else {
                                            // Aucune légende n'est possible pour l'image
                                            $img_legend = '';
                                        }
                                    } else {
                                        // On utilise le titre du billet
                                        $img_legend = $rs->post_title;
                                        // La légende est liée au billet
                                        $img_legend = '<a class="link_entry" href="' . $rs->getURL() . '" title="' . sprintf(__('Go to entry %s'), $img_legend) . '">' . $img_legend . '</a>';
                                    }
                                }

                                if ($bubble !== 'none') {
                                    // Un titre d'image est requis
                                    if ($bubble === 'image') {
                                        // Le titre est déjà positionné
                                    } else {
                                        // On utilise le titre du billet
                                        $img_title = Html::escapeHTML($rs->post_title);
                                    }
                                } else {
                                    // Pas de titre sur l'image
                                    $img_title = '';
                                }

                                // Ouverture div englobante si en div et légende requise (et existante)
                                if ($legend !== 'none' && $html_tag === 'div') {
                                    $res .= '<div class="outer_' . $orientation . '">';
                                    $res .= "\n";
                                }

                                // Ouverture balise
                                if ($html_tag !== 'none') {
                                    // Début de la balise englobante
                                    $res .= '<' . $html_tag . ' class="' . $orientation . '">';

                                    if ($link !== 'none') {
                                        // Si un lien est requis
                                        if ($link === 'image') {
                                            // Lien vers l'image originale
                                            $href       = self::ContentImageLookup($p_root, $i, 'o', $orientation, $dim, $sizes, 'o');
                                            $href       = $p_url . (dirname($i) !== '/' ? dirname($i) : '') . '/' . $href;
                                            $href_title = match ($bubble) {
                                                'entry' => Html::escapeHTML($rs->post_title),
                                                // default also stands for 'image'
                                                default => $img_alt,
                                            };
                                        } else {
                                            // Lien vers le billet d'origine
                                            $href       = $rs->getURL();
                                            $href_title = Html::escapeHTML($rs->post_title);
                                        }

                                        $res .= '<a class="link_' . $link . '" href="' . $href . '" title="' . $href_title . '">';
                                    }
                                }

                                // Gestion option alt : inherit / none
                                if ($alt === 'none') {
                                    $img_alt = '';
                                }

                                // Mise en place de l'image
                                $res .= '<img src="' . $src_img . '" ';
                                // Rajout de la classe si indiquée
                                if ($class !== '') {
                                    $res .= 'class="' . Html::escapeHTML($class) . '" ';
                                }

                                // Mise en place des dimensions de l'image si pas explicitement exclu
                                if ($img_dim !== 'none' && is_array($dim) && count($dim) >= 1) {
                                    $res .= 'width="' . $dim[0] . '" height="' . $dim[1] . '" ';
                                }

                                $res .= 'alt="' . $img_alt . '" ' . ($img_title == '' ? '' : 'title="' . $img_title . '" ') . '>';
                                if ($html_tag !== 'none') {
                                    // Fin de la balise englobante
                                    if ($link !== 'none') {
                                        // Fermeture du lien requis
                                        $res .= '</a>';
                                    }

                                    if ($legend !== 'none' && $html_tag === 'div') {
                                        // Fermeture balise
                                        $res .= '</' . $html_tag . '>';
                                        $res .= "\n";
                                    }

                                    // Une légende est requise
                                    if ($legend !== 'none' && $img_legend !== '') {
                                        if ($html_tag === 'div') {
                                            $res .= '<p class="legend">' . $img_legend . '</p>';
                                        } else {
                                            $res .= '<br><span class="legend">' . $img_legend . '</span>';
                                        }
                                    }

                                    // Fermeture div englobante si en div et légende requise (et existante)
                                    if ($legend !== 'none' && $html_tag === 'div') {
                                        $res .= '</div>';
                                        $res .= "\n";
                                    } else {
                                        // Fermeture balise
                                        $res .= '</' . $html_tag . '>';
                                        $res .= "\n";
                                    }
                                }
                            } elseif ($length < $img_count) {
                                // L'image au format demandé n'a pas été trouvée, on cherchera une image de plus pour tenter de satisfaire la demande
                                ++$length;
                            }
                        } elseif ($length < $img_count) {
                            // L'image ne comporte pas de source locale, on cherchera une image de plus pour tenter de satisfaire la demande
                            ++$length;
                        }
                    }
                }
            }
        }

        if ($res !== '' && $res !== '0') {
            return $res;
        }

        return '';
    }

    /**
     * Fonction utilitaire de recherche d'une image selon un format spécifié (indique aussi l'orientation)
     *
     * @param      string                           $root      The root
     * @param      string                           $img       The image
     * @param      string                           $size      The requested size
     * @param      string                           $orientation      The image orientation
     * @param      array<int|string, mixed>|null    $dim       The image dimension if found
     * @param      string                           $sizes     The possible image sizes (pattern)
     * @param      string                           $def_size  The default size to provided if requested not found
     */
    private static function ContentImageLookup(
        string $root,
        string $img,
        string $size,
        string &$orientation,
        ?array &$dim,
        string $sizes,
        string $def_size = 'o'
    ): bool|string {
        // Init
        $media_info = false;
        $res        = false;

        // Récupération du nom et de l'extension de l'image source
        $info = Path::info($img);
        $base = $info['base'];

        if (!str_ends_with((string) $info['dirname'], '/')) {
            $info['dirname'] .= '/';
        }

        if (!str_ends_with($root, '/')) {
            $root .= '/';
        }

        // Suppression du suffixe rajouté pour la création des miniatures s'il existe dans le nom de l'image
        $thumb_prefix = App::media()->getThumbnailPrefix();

        // Exclude . (hidden files) and prefixed thumbnails (if thumb prefix is .)
        $pattern_prefix = $thumb_prefix !== '.' ? sprintf('(\.|%s)', preg_quote((string) $thumb_prefix)) : '\.';

        if (preg_match('/^' . $pattern_prefix . '(.+)_(' . $sizes . ')$/', (string) $base, $m)) {
            $base = $m[1];
        }

        if ($size !== 'o') {
            foreach (self::$extensions as $extension) {
                if (file_exists($root . $info['dirname'] . $thumb_prefix . $base . '_' . $size . '.' . $extension)) {
                    // Une miniature au format demandé a été trouvée
                    $res = $thumb_prefix . $base . '_' . $size . '.' . $extension;
                    //Récupération des dimensions de la miniature
                    $media_info = getimagesize($root . $info['dirname'] . $res);

                    break;
                }
            }
            if ($res === false && $thumb_prefix !== '.') {
                // Recherche avec . comme préfixe de miniature
                foreach (self::$extensions as $extension) {
                    if (file_exists($root . $info['dirname'] . '.' . $base . '_' . $size . '.' . $extension)) {
                        // Une miniature au format demandé a été trouvée
                        $res = '.' . $base . '_' . $size . '.' . $extension;
                        //Récupération des dimensions de la miniature
                        $media_info = getimagesize($root . $info['dirname'] . $res);

                        break;
                    }
                }
            }
        } else {
            // Recherche d'alternative
            if ($def_size === 'none') {
                // Pas d'alternative demandée
                return false;
            } elseif ($def_size === 'sq') {
                // Alternative square est demandée
                return self::ContentImageLookup($root, $img, 'sq', $orientation, $dim, $sizes, 'none');
            }

            // Recherche l'image originale
            $f = $root . $info['dirname'] . $base;
            if (file_exists($f . '.' . $info['extension'])) {
                $res = $base . '.' . $info['extension'];
            } else {
                foreach (self::$extensions as $extension) {
                    if (file_exists($f . '.' . $extension)) {
                        $info['extension'] = $extension;
                        $res               = $base . '.' . $extension;

                        break;
                    }
                }
            }

            // Récupération des dimensions de l'image originale
            if (file_exists($root . $info['dirname'] . $base . '.' . $info['extension'])) {
                $media_info = getimagesize($root . $info['dirname'] . $base . '.' . $info['extension']);
            } elseif (file_exists($root . $info['dirname'] . $base . '.' . strtoupper((string) $info['extension']))) {
                $media_info = getimagesize($root . $info['dirname'] . $base . '.' . strtoupper((string) $info['extension']));
            } else {
                // L'image originale n'est plus présente et accessible
                return false;
            }
        }

        if ($media_info !== false) {
            // Détermination de l'orientation de l'image
            $orientation = ($media_info[0] > $media_info[1] ? 'landscape' : 'portrait');
            if (!is_null($dim)) {
                $dim = $media_info;
            }

            if ($res) {
                return $res;
            }
        }

        return false;
    }
}
