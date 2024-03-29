# listImages

[![Release](https://img.shields.io/github/v/release/franck-paul/listImages)](https://github.com/franck-paul/listImages/releases)
[![Date](https://img.shields.io/github/release-date/franck-paul/listImages)](https://github.com/franck-paul/listImages/releases)
[![Issues](https://img.shields.io/github/issues/franck-paul/listImages)](https://github.com/franck-paul/listImages/issues)
[![Dotaddict](https://img.shields.io/badge/dotaddict-official-green.svg)](https://plugins.dotaddict.org/dc2/details/listImages)
[![License](https://img.shields.io/github/license/franck-paul/listImages)](https://github.com/franck-paul/listImages/blob/master/LICENSE)

Plugin Dotclear 2

## UTILISATION

ATTENTION: ce plugin ne traite que les images en provenance du répertoire de médias du blog.

### Balise template

Ce plugin crée une seule balise template `{{tpl:EntryImages}}` à utiliser dans vos fichiers de contexte ou une page connexe. Elle peut recevoir plusieurs attributs.

Par défaut,

```html
{{tpl:EntryImages}}
```

est équivalent à

```html
{{tpl:EntryImages size="t" html_tag="span" link="image" from="full" legend="none" start="1" length="0" bubble="image" alt="inherit" img_dim="0" class="" def_size="o"}}
```

### Attributs

* **size**
  Taille des images affichées.
  Valeurs possibles : `sq` (square), `t` (thumbnail), `s` (small), `m` (medium), `o` (originale)
  Si le format choisi n'est pas présent dans le gestionnaire de médias, l'image est ignorée.

* **html_tag**
  Balisage html pour chaque item.
  Valeurs possibles : `span` (élément), `li` (élément de liste), `div` (boîte), `none` (aucune balise)
    Classe CSS : une classe `portrait` ou `landscape` sera ajoutée à cette balise en fonction du sens de l'image.
  Attention si vous choisissez `li`, pensez à placer en début et fin de boucle la balise html englobante (`ul` ou `ol`) ; si vous choisissez `span`, pensez à placer en début et fin de boucle la balise html englobante (`p`).

* **link**
  Cible du lien posé sur chaque image.
  Valeurs possibles : `entry` (billet d'origine), `image` (taille réelle), `none` (aucun lien)

* **from**
  Provenance des images au sein du billet.
  Valeurs possibles : `excerpt` (chapo), `content` (contenu), `full` (tout le billet)

* **legend**
  Ajout d'une légende.
  Valeurs possibles : `entry` (titre du billet d'origine avec lien), `image` (title s'il existe, sinon alt s'il existe, sinon légende vide), `none` (pas de légende)
  Si la valeur choisie pour **html_tag** est `div`, alors la légende est placée dans un `<p class="legend"></p>` et l'ensemble image + légende est placé dans un `<div class="outer_portrait|outer-landscape"></div>`.
  Si la valeur choisie pour **html_tag** est `span` ou `li`, alors la légende est précédée d'un retour à la ligne (`<br />`) et placée dans un `<span class="legend"></span>`.

* **bubble**
  Définit le titre positionné pour l'image.
  Valeurs possibles : `entry` (titre du billet d'origine), `image` (titre de l'image s'il existe), `none` (pas de titre)

* **start**
  Choix de la première image listée au sein du billet.
  Valeurs possibles : `1` à `n`
  Si cette valeur est supérieure au nombre total d'images dans le billet, aucune image n'est extraite.

* **length**
  Nombre d'images à extraire par billet.
  Valeurs possibles : `0` (toutes) à `n`
  Si cette valeur est supérieure au nombre total d'images dans le billet, toutes les images sont extraites.
  Si une image ne possède pas de miniature au format demandé elle ne sera pas décomptée.

* **class**
  Ajout d'une classe à la balise `<img />`

* **alt**
  Définition de l'attribut alt de la balise `<img />`
  Valeurs possibles : none (aucun), inherit (standard)

* **img_dim**
  Inclusion des dimensions de l'image en pixel (il s'agit des dimensions de l'image affichée)
  Valeurs possibles : none (non), autre chose que none (oui)

* **def_size**
  Indique l'image alternative à retourner si le format désiré n'est pas disponible : `sq` (square), `o` (originale), `none` (aucune)

----

## Exemples d'utilisation

Voici quelques exemples d'utilisation de la balise `{{tpl:EntryImages}}`

### Cas 1

Afficher toutes les images de la catégorie Photographies avec effet Lightbox[^1]

Par exemple pour créer rapidement un catalogue de toutes vos photographies (et seulement elles) publiées dans les billets d'une catégorie en particulier

```html
    <tpl:Entries category="Photographies" lastn="1000">
        <tpl:EntriesHeader>
            <div class="post entryimages">
            <p>
        </tpl:EntriesHeader>
            {{tpl:EntryImages}}
        <tpl:EntriesFooter>
            </p>
            </div>
            <!-- ajout recommandé si les images sont présentées en blocs flottants -->
            <hr class="clearer" />
        </tpl:EntriesFooter>
    </tpl:Entries>
```

### Cas 2

Afficher la première image de chaque billet au format small avec un lien vers le billet d'origine et le titre du billet en légende

Par exemple pour présenter un portfolio de réalisations ou des archives.

```html
    <tpl:Entries>
    <tpl:EntriesHeader>
        <div class="entryimages">
    </tpl:EntriesHeader>
        {{tpl:EntryImages size="s" html_tag="div" link="entry" legend="entry" length="1"}}
    <tpl:EntriesFooter>
        </div>
        <!-- ajout recommandé si les images sont présentées en blocs flottants -->
        <hr class="clearer" />
    </tpl:EntriesFooter>
    </tpl:Entries>
```

----

## Styler les entryimages

Classes générées par le plugin :

* `landscape` ou `portrait`
    Affectée à la balise html choisie pour chaque image (`span`, `li` ou `div`) en fonction du sens de l'image.

* `outer_landscape` ou `outer_portrait`
    Affectée à la div englobant l'image et la légende si l'on a choisi `div` pour l'attribut **html_tag** et `entry` ou `image` pour l'attribut **legend**.

* `legend`
    Affectée au `span` ou au `p` englobant la légende.

Recommandation :

Pour styler plus aisément les séries d'images générées par EntryImages, il est souhaitable d'affecter une classe au bloc les contenant toutes (ex. `class="entryimages"`).

### Exemple de styles pour le cas 1 ci-dessus

À ajouter à la fin du fichier <var>style.css</var> de votre thème.

```css
/* Styles pour EntryImages */
.post.entryimages span {
    padding: 0;
    margin: 0;
    display: block;
    float: left;
    }
.post.entryimages span.landscape a {
    display: block;
    padding: 21px 8px 20px 8px;
    background: #eee;
    border: 1px solid #DDD;
    border-right: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    margin: 4px;
    }
.post.entryimages span.portrait a {
    display: block;
    padding: 8px 21px 8px 20px;
    background: #eee;
    border: 1px solid #DDD;
    border-right: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    margin: 4px;
    }
.post.entryimages span a img {
    border: 1px solid #fff;
    }
.post.entryimages span a:hover {
    background: #ccc;
    }
.post.entryimages p {
    clear: both;
    padding-top: 2em;
    }
hr.clearer {
    height: 1px;
    font-size: 1px;
    color: #fff;
    background: transparent;
    border: none;
    clear: both;
    }
```

### Exemple de styles pour le cas 2 ci-dessus

À ajouter à la fin du fichier <var>style.css</var> de votre thème.

```css
/* Styles pour EntryImages */
.post.entryimages {
    margin: 2em 0;
    }
.post.entryimages img {
    border: 1px solid #fff;
    }
.outer_landscape, .outer_portrait {
    width: 260px;
    height: 280px;
    float: left;
    margin-right: 10px;
    margin-bottom: 10px;
    background: #f5f5f0;
    padding: 10px 0 8px;
    border: 1px solid #DDD;
    }
.outer_landscape div, .outer_landscape .legend, .outer_portrait div, .outer_portrait .legend {
    text-align: center;
    }
.legend {
    font-size: x-small;
    padding: 0 12px;
    margin: 0;
    }
hr.clearer {
    height: 1px;
    font-size: 1px;
    color: #fff;
    background: transparent;
    border: none;
    clear: both;
    }
```

[^1]: Si ce plugin est activé sur le blog
[^2]: Chaîne de caractères alphanumériques sans accents ni espaces ni caractères spéciaux
