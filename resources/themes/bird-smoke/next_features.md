# Theme Editor - Next Features

Ce document priorise les évolutions du `theme-editor` actuel du thème Bird.

## État d'avancement (2026-04-30)

- Fait: M1 portabilité route de sauvegarde, M2 registre central des blocs, M3 validation forte des params.
- Fait: couche d'adaptation portable `theme-editor/editor-config.php` + runtime JS configurable en `data-te-*` uniquement.
- Fait: point d'injection unique `views/theme-editor/partials/inject.blade.php` (intégration layout simplifiée).
- Fait: simplification ajout de blocs/règles avec `params[].rules` dans `theme-editor/block-registry.php`.
- Fait: mitigation R1 (XSS announce bar), R2 (stabilité clé route via `route uri`), R3 (limitation charge images), R6 (versioning assets éditeur).
- Fait: suppression du bundle legacy `views/theme-editor/assets/*`.
- Fait partiel: M4 UX page builder (duplication de bloc ajoutée).
- À faire: drag-and-drop, undo/redo, import/export, nettoyage packaging assets volumineux.

## 1) Manques actuels

### M1 - Portabilité incomplète (hardcode du thème) - Résolu

- Le save est maintenant multi-thème (résolution dynamique du thème cible).
- Une couche runtime portable `theme-editor/editor-config.php` supprime les hardcodes JS/CSS critiques.
- Un point d'injection unique (`views/theme-editor/partials/inject.blade.php`) simplifie l'activation dans d'autres thèmes.

### M2 - Source de vérité dispersée pour les blocs - Résolu

- Le registre `theme-editor/block-registry.php` reste la source centrale.
- Le rendu (`home.blade.php`) et la validation (`config/rules.php`) consomment ce registre.
- Impact résiduel faible: reste surtout la discipline de maintien des vues de blocs.

### M3 - Validation faible des `params` de blocs - Résolu

- Validation typée côté serveur par bloc/paramètre en place.
- Les clés inattendues sont rejetées explicitement.
- Les règles simples sont maintenant définies directement dans `params[].rules` du registre.

### M4 - UX Page Builder limitée

- Réordonnancement en boutons `↑/↓` uniquement (pas de drag-and-drop).

### M5 - Pas d’import/export de configuration

- Impossible d’exporter un preset complet (JSON) et de le réutiliser sur un autre environnement/thème.
- Impact: réplication manuelle lente.

### M6 - Assets/sources dupliqués dans le thème

- Présence de sources build incluant `node_modules` dans `views/theme-editor/resources/*`.
- Impact: poids inutile, maintenance plus fragile, risque de publier des artefacts non voulus.

## 2) Valeur ajoutée à implémenter (priorisée)

### P1 - Rendre le module réellement multi-thèmes

- Statut: majoritairement fait (adapter runtime + save multi-thème + doc d'intégration).
- Reste recommandé: extraire en package partagé si diffusion large hors Bird.

### P1 - Centraliser le schéma d’édition

- Statut: fait.
- Le registre unique décrit blocs, defaults, types, vue associée et règles de validation.

### P1 - Validation robuste côté serveur

- Statut: fait pour la validation par bloc + rejet des clés inconnues.
- Amélioration possible: enrichir encore le mapping d'erreurs UI par champ.

### P2 - Édition de page plus productive

- Ajouter drag-and-drop.

### P2 - Import/Export & presets

- Export JSON signé/versionné.
- Import avec migration de schéma (compatibilité ascendante).
- Presets enregistrables par thème.

### P2 - i18n complète de l’UI éditeur

- Externaliser tous les labels FR statiques des tabs/partials.
- Charger traductions par locale.

### P3 - Observabilité et fiabilité

- Journaliser les erreurs save côté client (et endpoint serveur si possible).
- Ajouter tests (unitaires + feature) sur:
  - sérialisation des blocs
  - validation
  - persistance `admin.themes.config`

### P3 - Pipeline assets propre

- Garder seulement les artefacts runtime nécessaires.
- Déplacer les sources build hors du package distribué.
- Ajouter contrôle CI de taille et de fichiers interdits.

## 3) Problèmes potentiels (à surveiller)

### R1 - Risque XSS sur la barre d’annonce

- Mitigé: la preview utilise désormais `textContent` (pas `innerHTML`).
- Risque résiduel: faible tant qu'aucun rendu HTML non filtré n'est réintroduit.

### R2 - Dérive des configs par route

- Les blocs sont stockés par clé route/path hashée.
- Sur des pages sans route nommée stable, risque de multiplication de clés.
- Effet: `config.json` qui grossit et devient difficile à maintenir.

### R3 - Coût de chargement en admin

- Mitigé partiellement: chargement limité (250 images récentes).
- Risque résiduel: payload encore élevé sur très grosses médiathèques.
- Suite recommandée: pagination/recherche asynchrone côté éditeur.

### R4 - Écart preview vs rendu réel

- Les templates injectés côté éditeur peuvent différer d’un rendu final dépendant de données serveur (plugins, collections, permissions).
- Mitigation: indiquer clairement les parties “preview simplifiée”.

### R5 - Couplage fort aux conventions `data-te-*`

- Le live-update dépend de marqueurs DOM spécifiques.
- Si un intégrateur modifie les templates sans préserver ces attributs, l’éditeur se dégrade silencieusement.
- Mitigation: lint/checklist automatique sur les vues de blocs.

### R6 - Cache front des assets éditeur

- Sans versioning explicite des fichiers `theme-editor/js|css`, des clients peuvent garder un JS obsolète après déploiement.
- Mitigation: hash de build ou query string versionnée.
