# Use Theme Editor (Core + Surcouche thème)

Objectif: pouvoir copier le `theme-editor` dans un autre thème, faire un `@include(...)`, déclarer les blocs/options, et avoir un page-builder fonctionnel.

## 1) Séparation Core / Modifiable

Core stable:
- [theme-editor/block-registry.php](/Applications/MAMP/htdocs/azuriom_neuf/resources/themes/bird/theme-editor/block-registry.php)
- [theme-editor/editor-config.php](/Applications/MAMP/htdocs/azuriom_neuf/resources/themes/bird/theme-editor/editor-config.php)
- [theme-editor/init-context.php](/Applications/MAMP/htdocs/azuriom_neuf/resources/themes/bird/theme-editor/init-context.php)
- [views/theme-editor/resources/js/theme-editor/editor-core.js](/Applications/MAMP/htdocs/azuriom_neuf/resources/themes/bird/views/theme-editor/resources/js/theme-editor/editor-core.js)
- [views/theme-editor/forms/blocks/_generic.blade.php](/Applications/MAMP/htdocs/azuriom_neuf/resources/themes/bird/views/theme-editor/forms/blocks/_generic.blade.php)

Surcouche thème:
- Catalogue + options + règles: [views/theme-editor/registry/catalog.php](/Applications/MAMP/htdocs/azuriom_neuf/resources/themes/bird/views/theme-editor/registry/catalog.php)
- Vues blocs (Blade): `views/theme-editor/blocks/...`
- Handlers preview spécifiques (optionnel): [assets/js/theme-editor/editor-block-handlers.js](/Applications/MAMP/htdocs/azuriom_neuf/resources/themes/bird/assets/js/theme-editor/editor-block-handlers.js)

## 2) Intégration minimale (include)

Dans le layout principal:
1. Ajouter `@include('theme-editor.partials.mount')` en haut de `views/layouts/base.blade.php`.
2. Laisser `base.blade.php` rendre le contenu theme-editor via `theme-editor.partials.render-content`.
3. Garder `@stack('styles')` dans `<head>`.
4. Garder `@stack('footer-scripts')` avant `</body>`.

Le partial [mount.blade.php](/Applications/MAMP/htdocs/azuriom_neuf/resources/themes/bird/views/theme-editor/partials/mount.blade.php) charge automatiquement:
- init contexte
- styles runtime
- off-canvas + scripts éditeur
- variables partagées pour le rendu des blocs

## 3) Déclarer des blocs (sans toucher le core)

Tout se fait dans [registry/catalog.php](/Applications/MAMP/htdocs/azuriom_neuf/resources/themes/bird/views/theme-editor/registry/catalog.php):
- `catalog[]`: `id`, `label`, `default_params`, `params`
- `view_map`: mapping `id -> vue blade`
- `param_rules_overrides`: règles nested (`items.*`, etc.)
- `default_blocks_for_route`: blocs par défaut par route

Le core:
- auto-ajoute `aos` (sauf `header/footer/page_content`)
- auto-construit `param_rules` depuis `params[].rules`
- auto-découvre des vues dans `views/theme-editor/blocks/home/*.blade.php` si besoin

## 4) Contrat DOM des blocs

Attributs supportés par le core:
- `data-te-block`
- `data-te-param`
- `data-te-param-href`
- `data-te-param-image`
- `data-te-param-class`
- `data-te-param-list`
- `data-te-node`
- `data-te-block-container`

Le core met à jour génériquement les champs simples.
Pour une logique plus riche (header navbar, listes custom HTML, boutons serveur, etc.), ajouter un handler thème dans `editor-block-handlers.js`.

## 5) Formulaires d’édition de blocs

Le rendu formulaire est Blade-first:
- template injecté par bloc dans `offcanvas.blade.php`
- formulaire générique: `_generic.blade.php`
- JS: ouverture/fermeture modal, hydratation, sérialisation, save, live preview

Types supportés:
- `text`, `textarea`, `number`, `url`, `toggle`, `select`, `image`, `list`

## 6) Portage vers un nouveau thème

1. Copier:
- `theme-editor/`
- `views/theme-editor/`
- `assets/js/theme-editor/`

2. Dans le nouveau thème:
- brancher `@include('theme-editor.partials.mount')`
- créer `views/theme-editor/registry/catalog.php`
- créer les vues blocs référencées dans `view_map`
- optionnel: créer `assets/js/theme-editor/editor-block-handlers.js`

3. Vérifier:
- ouverture off-canvas admin
- ajout/édition/réordre blocs
- save + reload
- route home vs autres pages (présence `page_content`)

4. Publier:
- générer un export slim avec `tools/publish-theme-editor.php`
- vérifier que les archives Git ignorent `views/theme-editor/resources/`
