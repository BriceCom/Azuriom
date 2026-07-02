# Next Features - Roadmap par lots

## Lot 0 - Stabilisation immédiate (priorité haute) (fait)
Objectif: fiabiliser l'existant avant d'élargir le périmètre.

- Corriger le bug de fermeture (`editorActions` vs `gpsActions`).
- Masquer `#gjs` par défaut tant que l'éditeur n'est pas ouvert.
- Nettoyer systématiquement les placeholders `data-gjs-placeholder` avant sauvegarde.
- Uniformiser la traduction des labels GrapesJS via `lang/fr` et `lang/en`.
- Retirer/archiver les artefacts de démo non utilisés (`builder-2`, preset local si non exploité).

## Lot 1 - Édition sur la page courante (MVP produit) (fait)
Objectif: coller à la vision "customisable à la volée".

- Ajouter un mode "Éditer cette page" sur toutes les pages éligibles (admin only).
- Introduire une zone éditable explicite dans les layouts (ex: `data-pagebuilder-slot`).
- Ouvrir GrapesJS en overlay contextuel, sans redirection vers une page d'admin séparée.
- Charger/sauvegarder le contenu de la route active au lieu d'une seule homepage globale.
- Conserver un fallback Blade si aucune donnée pagebuilder n'existe.

## Lot 2 - Modèle de stockage multi-pages (fait)
Objectif: structurer les données pour tenir dans le temps.

- Définir une clé de stockage par page (`route_name` ou `uri_hash`) et locale.
- Stocker `components`, `theme_tokens`, `metadata` dans une structure versionnée.
- Ajouter migration de compatibilité depuis l'ancienne clé unique `pagebuilder`.
- Prévoir rollback simple (dernier snapshot valide).
- Ajouter un endpoint de lecture léger pour précharger l'éditeur rapidement.

## Lot 3 - Kit Bootstrap 5 complet (fait)
Objectif: avoir une base solide avant les composants métier.

- Étendre la palette de blocs natifs: section, navbar, card, alert, badge, list-group, accordion, tabs, carousel.
- Ajouter des blocs formulaires: input, textarea, select, checkbox, radio, bouton submit.
- Exposer plus de traits responsive: display, spacing, flex, alignements, ordres, breakpoints.
- Garantir la cohérence avec le thème global (couleurs, typo, radius, spacing).

## Lot 3.1 - Correctifs UX éditeur + cohérence thème (fait)
Objectif: fiabiliser l'usage réel avant les composants custom.

- Retirer les blocs formulaires Bootstrap 5 (hors périmètre actuel).
- Bloquer les imbrications incohérentes (ex: carousel/tabs dans alert/tab-pane).
- Autoriser les imbrications utiles (ex: badge dans alert, tab-pane, card-body).
- Remplacer les labels/placeholder persistants par des aides visuelles éditeur-only (bordures hachurées + hints).
- Ajouter un bloc Image avec source depuis la médiathèque Azuriom (`Azuriom\\Models\\Image`).
- Améliorer le carousel avec 3 slides visuelles + contrôles gauche/droite non éditables.
- Supprimer les traits utilitaires custom (display/margin/etc.) pour revenir aux réglages natifs GrapesJS.
- Renforcer le panneau thème global pour piloter les couleurs Bootstrap light/dark et variables globales.

## Lot 4 - Composants custom v1 (ajout manuel progressif)
Objectif: enrichir la bibliothèque avec des briques orientées Azuriom.

- Définir un namespace de composants custom (`custom-*`).
- Composant pilote livré: `custom-highlight-shop` (article mis en avant Shop) (fait).
- Système de templates globaux header/footer (multi-templates + sélection active + édition dédiée) (fait).
- Livrer une première vague: `custom-hero-server`, `custom-server-status`, `custom-feature-grid`, `custom-cta-banner`, `custom-faq`.
- Pour chaque composant: block GrapesJS, traits, renderer Blade, i18n, exemple.
- Documenter le process d'ajout pour faciliter les futures contributions manuelles.

## Lot 5 - Composants de page Vote/Shop + harmonisation Bootstrap (fait)
Objectif: ajouter des briques métier simples, contextuelles, sans complexifier l'architecture.

- Ajouter une catégorie GrapesJS `Page components` visible uniquement selon la route active.
- Ajouter les composants Vote: bloc de vote, top votants, récompenses.
- Ajouter les composants Shop: sidebar, accueil shop, description catégorie, grille packages.
- Rendre ces composants côté serveur via des partials Blade dédiées, sans controller/model/migration dans le thème.
- Étendre le configurateur "Global Theme (Bootstrap)" avec réglages de base harmonisés (padding boutons, cards, tables, poids typo boutons).

## Lot 6 - Qualité, sécurité, perf
Objectif: sécuriser le passage en production.

- Validation serveur stricte des payloads GrapesJS.
- Sanitization des attributs et URLs à risque.
- Ajouter des tests fonctionnels minimaux sur l'édition/sauvegarde.
- Ajouter des tests fonctionnels minimaux sur le rendu front.
- Ajouter des tests fonctionnels minimaux sur les permissions admin.
- Optimiser le chargement JS/CSS de l'éditeur pour ne pas pénaliser les visiteurs.

## Lot 7 - Fonctionnalités avancées (après MVP)
Objectif: améliorer l'expérience éditoriale long terme.

- Autosave brouillon.
- Historique local des changements.
- Mode preview multi-breakpoints.
- Workflow brouillon/publication.
- Export/import JSON de pages.

## Définition de "done" pour un lot
- Le lot est terminé quand le front public reste stable.
- Le lot est terminé quand l'admin peut utiliser la fonctionnalité sans régression UI.
- Le lot est terminé quand les données sauvegardées restent compatibles avec le renderer serveur.
- Le lot est terminé quand la documentation du lot est à jour.
