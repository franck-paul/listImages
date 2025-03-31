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

use ArrayObject;
use Dotclear\Plugin\TemplateHelper\Code;

class FrontendTemplate
{
    /**
     * @param      array<string, mixed>|\ArrayObject<string, mixed>  $attr      The attribute
     *
     * Code de traitement de la balise
     * -------------------------------
     * Balise d'extraction des images des billets sélectionnés par la balise <tpl:Entries> dans laquelle elle est placée
     * Exemple :
     * {{tpl:EntryImages}} -> extraira toutes les images du billet courant et les retourne sous la forme d'une série de span
     * contenant l'image au format thumbnail liée vers l'image au format original
     * Attributs (optionnels) :
     * size :    sq, t (défaut), s, m, o (voir tailles de miniature du gestionnaire de médias)
     * html_tag : span (défaut), li, div, none
     * link : entry, image (défaut), none
     * from : excerpt, content, full (défaut)
     * legend : none (défaut), image, entry
     * bubble : none, image (défaut), entry
     * start : 1 (défaut) à n
     * length : 0 (défaut) à n, 0 = toutes
     * class : ajoutée à la balise <img>
     * alt : none, inherit (defaut)
     * img_dim : ajoute les dimensions de l'image
     * def_size : taille d'image à retourner par défaut -> sq, o (défaut), none
     * Non développés (pour l'instant, peut-être, chépô, etc) :
     * exif : 0 (défaut), 1
     */
    public static function EntryImages(array|ArrayObject $attr): string
    {
        return Code::getPHPCode(
            FrontendTemplateCode::EntryImages(...),
            [
                isset($attr['size']) ? trim((string) $attr['size']) : '',
                isset($attr['html_tag']) ? trim((string) $attr['html_tag']) : '',
                isset($attr['link']) ? trim((string) $attr['link']) : '',
                isset($attr['exif']) ? 1 : 0,
                isset($attr['legend']) ? trim((string) $attr['legend']) : '',
                isset($attr['bubble']) ? trim((string) $attr['bubble']) : '',
                isset($attr['from']) ? trim((string) $attr['from']) : '',
                isset($attr['start']) ? (int) $attr['start'] : 1,
                isset($attr['length']) ? (int) $attr['length'] : 0,
                isset($attr['class']) ? trim((string) $attr['class']) : '',
                isset($attr['alt']) ? trim((string) $attr['alt']) : 'inherit',
                isset($attr['img_dim']) ? trim((string) $attr['img_dim']) : 'none',
                isset($attr['def_size']) ? trim((string) $attr['def_size']) : '',
            ]
        );
    }
}
