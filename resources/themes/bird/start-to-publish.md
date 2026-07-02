# Start To Publish

Objectif: sortir `theme-editor` comme un coeur reutilisable, copiable dans n'importe quel theme Azuriom, avec une integration minimale et des composants partages.

Regle de lecture:
- `(fait)` = deja present et valide dans l'etat actuel du repo.
- `(a faire)` = travail encore necessaire avant une vraie publication du coeur.

## 1) Coeur portable

- [x] Extraire le runtime commun dans `theme-editor/` avec `block-registry.php`, `editor-config.php`, `init-context.php` et `rules.php`. (fait)
- [x] Centraliser la definition des blocs, des vues et des regles dans un registre unique. (fait)
- [x] Valider les blocs et leurs parametres cote serveur. (fait)
- [x] Versionner les assets runtime du theme-editor pour eviter les soucis de cache. (fait)
- [x] Garder les marqueurs DOM `data-te-*` comme contrat d'integration. (fait)

## 2) Integration theme

- [x] Injecter le coeur via `@include('theme-editor.partials.mount')`. (fait)
- [x] Charger le contexte theme-editor une seule fois via `mount` et supprimer les includes redondants dans les layouts. (fait)
- [x] Ramener l'usage courant a une seule adaptation minimale dans `resources/themes/<theme>/views/layouts/base.blade.php`. (fait)
- [x] Garder `@stack('styles')` dans le `<head>`. (fait)
- [x] Garder `@stack('footer-scripts')` avant `</body>`. (fait)
- [x] Conserver un conteneur de contenu avec `data-te-block-container`. (fait)

## 3) Composants reutilisables

- [x] Isoler les partials d'edition dans `views/theme-editor/partials`. (fait)
- [x] Isoler les composants Blade reutilisables dans `views/theme-editor/components`. (fait)
- [x] Declarer les blocs renderables dans `views/theme-editor/blocks`. (fait)
- [x] Centraliser le rendu commun des blocs dans un partial reutilisable. (fait)
- [x] Fournir un offcanvas d'administration pour l'edition live. (fait)
- [x] Detacher les blocs de demo propres a Bird du coeur generic quand ils ne sont pas utiles ailleurs. (fait)

## 4) Stabilite produit

- [x] Mitiger le risque XSS sur la preview de la barre d'annonce. (fait)
- [x] Stabiliser la cle de route utilisee pour la persistence des blocs. (fait)
- [x] Limiter la charge images en admin. (fait)
- [x] Ajouter le drag-and-drop pour le page builder. (fait)
- [x] Ajouter import/export de presets JSON. (fait)
- [x] Ajouter undo/redo. (fait)
- [x] Externaliser tous les labels statiques de l'UI en i18n. (fait)

## 5) Packaging de publication

- [x] Retirer le bundle legacy `views/theme-editor/assets/*`. (fait)
- [x] Retirer les sources de build et artefacts dupliques du package distribue. (fait)
- [x] Eliminer `node_modules` et caches du package livrable via l'export slim. (fait)
- [x] Garder uniquement les fichiers runtime necessaires dans le theme publie. (fait)
- [x] Ajouter un export script pour generer un package slim du theme-editor. (fait)
- [x] Ajouter des regles `export-ignore` pour les sources de build dans les archives Git. (fait)
- [x] Externaliser les presets de route dans `views/theme-editor/registry/default-blocks.php`. (fait)
- [ ] Verifier qu'un theme externe peut se contenter de pull le coeur et brancher son propre catalogue.

## 6) Verification avant push

- [x] Smoke-test de l'export slim vers `/private/tmp` sans sources de build. (fait)
- [ ] Tester l'activation du coeur sur un second theme Azuriom.
- [ ] Verifier l'edition des blocs, la sauvegarde et le reload.
- [ ] Verifier le rendu home et les autres pages.
- [x] Ajouter une checklist de publication finale pour le git du coeur. (fait)

## 7) Definition de done

Le coeur est publie quand:
- un theme externe peut recuperer `theme-editor` par pull,
- une modification minimale dans le layout suffit pour l'activer,
- les composants reutilisables fonctionnent sans code Bird specifique,
- le package distribue ne contient plus de sources de build inutiles,
- le flux de sauvegarde et de rendu est valide sur au moins deux themes.

## 8) Checklist de publication

- [ ] Tester l'activation du coeur sur un second theme Azuriom.
- [ ] Verifier l'edition des blocs, la sauvegarde et le reload.
- [ ] Verifier le rendu home et les autres pages.
- [ ] Verifier que `page_content` reste fonctionnel sur les pages dynamiques.
- [ ] Controler le contenu de l'export slim avant diffusion.
- [ ] Verifier qu'aucun `node_modules` ni artefact de build ne reste dans le package publie.
- [ ] Confirmer que les assets runtime restent versions apres export.
- [ ] Verifier que le theme externe peut brancher son propre catalogue de blocs sans patch du coeur.
- [ ] Rediger la note de release finale avec le perimetre exact du coeur publie.

## 9) Points a garder apres publication

- Garder les blocs de demo propres a Bird hors du coeur generic tant qu'ils ne sont pas reutiles ailleurs.
- Laisser `next_features.md` servir de backlog d'evolution du page builder.
- Ne pas reintroduire de sources de build dans le package livrable sans raison explicite.
- Garder la checklist de verification comme gate avant toute nouvelle publication du coeur.

## 10) Procedure de sortie

- [ ] Repasser la checklist de publication avec le diff final sous les yeux.
- [ ] Regenerer l'export slim depuis l'etat exact qui sera publie.
- [ ] Comparer le contenu exporte avec le theme source pour verifier l'absence de bruit.
- [ ] Tester l'activation sur un theme secondaire propre.
- [ ] Tester la sauvegarde d'un jeu de blocs puis le reload de la page.
- [ ] Tester au moins une page home et une page hors home.
- [ ] Verifier que le coeur charge sans customisation Bird specifique restante.
- [ ] Preparer la note de release avec le perimetre exact, les limites et les points connus.
