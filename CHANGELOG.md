# Changelog

## 10.0 — 2026-11-08

- DC 2.40+
- Use getter methods rather than widget properties as far as possible
- Cope with RTL
- Enforces some verification before registering module

## 9.0 — 2026-08-03

- To soon for that!
- Avoid using magic methods for user preferences and blog settings (2.39+)
- Use MetaRecord::strField(), MetaRecord::intField() and MetaRecord::boolField() whenever is possible

## 8.1 — 2026-04-05

- DA -&gt; DC

## 8.0 — 2025-09-07

- DC 2.36 compliance

## 7.1 — 2025-06-01

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 7.0 — 2025-03-31

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 6.0 — 2025-03-31

- Use TemplateHelper for template blocks/values DC 2.34+

## 5.7 — 2025-03-09

- Cope with img tag no finishing with /&gt; but with &gt;

## 5.6 — 2025-02-26

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.5 — 2025-02-08

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.4 — 2024-08-28

- Cope with thumbnail prefix (code refactoring), 2.30+

## 5.1 — 2023-10-27

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.0 — 2023-10-24

- Avoid magic method as far as possible
- Add Avif image format support
- 2.28 compliance

## 4.0 — 2023-08-25

- Dotclear 2.27 compliance, PHP 8.1+

## 3.1.1 — 2023-06-27

- Add local static $init variable

## 3.1 — 2023-06-15

- Add void Install.php

## 3.0.1 — 2023-05-23

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 3.0 — 2023-05-23

- Switch to namespace
- Prepare 2.26

## 2.0 — 2022-11-30

- Dotclear 2.24 compliance

## 1.13 — 2022-08-13

- Update default branch in _define.php for alternative repository
- Add alternative repository

## 1.12 — 2020-03-12

- Not too fast dude!
- Add SVG and WEBP image format support, adapt widget code
- Cope with new static home page mode (2.16+)
- short notation for array (array() → [])

## 1.11 — 2015-05-02

- Various enhancements (thank's brol)

## 1.10 — 2014-09-25

- img_dim attribute should be set with "none" to exclude img dimensions, any other value or without this attribute, the dimension will be included.
- img_dim attribute not correctly coped : fixed
- No more px in img size attributes, thanks amalgame
- Add widget class on every widget, see #1901
- New rendering method for widget title (2.7 min), next release will be 1.10

## 1.9.1 — 2013-10-18

- break; missing

## 1.9 — 2013-10-17

- content_only and class widget param at the end of list
- new _define.php
- new icons
- No more $GLOBALS at top level, and various
- Tuning href title of link, post or original image.
- Bugfix
- various (next release will be 1.8)

## 1.8 — 2013-09-18

- New def_size attribut

## 1.7.2 — 2013-09-09

- Cope with new png thumbnails
- Fixes usage of $core global var.

## 1.7.1 — 2013-04-04

- Add "on all pages except on home" option for widget
- Cope with disappeared media

## 1.7 — 2012-12-11

- Widget may now be displayed without inclusive div

## 1.6.1 — 2012-11-30

- Bugfix

## 1.6 — 2012-11-29

- 1.6
- Add class to links
- Add missing files
- Revert to original name and desc in define.php of plugins. Localized versions are not required here.

## 1.5.2 — 2012-03-28

- Initial commit with 1.5.2 version
