# SeoLite Next Features

## Lot 0 - Stabilisation critique (immédiat)
Objectif: corriger les erreurs qui faussent l’analyse ou cassent l’UX.

- Corriger l’extraction du texte analysé pour exclure l’UI SeoLite (`assets/js/utilities.js`).
- Corriger le bug de comptage des liens internes (`assets/js/module/recommendations.js`).
- Aligner les clés i18n keyword density entre JS et `messages.php`.
- Corriger le CSS invalide `&:hover`/`&:active`/`&:focus` (`assets/css/styles.css`).
- Sécuriser l’injection offcanvas si `#app` est absent.

Critères d’acceptation:
- score et recommandations stables après ouverture/fermeture de l’offcanvas
- aucune clé brute `seolite::messages.*` affichée
- aucune erreur JS console sur pages standard

## Lot 1 - Cohérence du moteur de score
Objectif: rendre les scores explicables et homogènes.

- Centraliser les seuils (title/meta/readability/images/headings) dans une config unique.
- Uniformiser la logique de lisibilité (éviter la duplication PHP/JS divergente).
- Ajouter un objet de résultat standard par section: `score`, `max`, `reasons`, `raw_metrics`.
- Documenter la pondération globale (100 points).

Critères d’acceptation:
- même entrée => même score entre exécutions
- chaque section expose la raison de sa note

## Lot 2 - i18n et robustesse front
Objectif: fiabiliser l’interface pour environnement multilingue.

- Passer le dictionnaire JS via `@json(...)` au lieu d’interpolations string.
- Ajouter `resources/lang/fr/messages.php` (parité minimale avec `en`).
- Retirer les textes anglais hardcodés dans les modules JS.
- Gérer proprement les caractères spéciaux/apostrophes dans traductions.

Critères d’acceptation:
- support EN/FR sans régression UI
- aucune rupture JS liée aux traductions

## Lot 3 - Analytics admin utiles
Objectif: faire de l’écran admin un vrai cockpit de priorisation.

- Ajouter filtres (date, score, lisibilité, contenu court).
- Ajouter tri par “impact SEO potentiel”.
- Afficher tendances (delta score) entre deux analyses.
- Préparer stockage des snapshots d’analyse par post (table dédiée).

Critères d’acceptation:
- un admin peut identifier rapidement les 10 contenus prioritaires
- les métriques sont comparables dans le temps

## Lot 4 - Couverture SEO élargie
Objectif: augmenter la valeur métier des recommandations.

- Vérifications robots/canonical/OG/Twitter cards complètes.
- Détection basique des problèmes de maillage interne.
- Vérification images lourdes + suggestions de conversion.
- Contrôles de base accessibilité SEO (alt, hiérarchie headings, title unique).

Critères d’acceptation:
- recommandations classées par sévérité et action
- réduction du bruit (moins de faux positifs)

## Lot 5 - Industrialisation
Objectif: rendre les releases prévisibles et maintenables.

- Ajouter tests unitaires sur helpers PHP (lisibilité/scoring).
- Ajouter checks CI (lint JS/PHP, format, tests).
- Nettoyer artefacts de repo plugin (zip, traces inutiles) pour release propre.
- Versionner avec changelog structuré.

Critères d’acceptation:
- pipeline verte avant publication
- release reproductible avec checklist

## Ordre recommandé
1. Lot 0
2. Lot 1
3. Lot 2
4. Lot 3
5. Lot 4
6. Lot 5
