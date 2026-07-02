# Guidelines - Theme `pagebuilder`

## 1) C'est quoi ce projet
Le thème `pagebuilder` est un thème Azuriom orienté édition visuelle avec GrapesJS.
Le but est de construire et personnaliser des pages directement dans le site, avec :
- une base de composants Bootstrap 5 (layout + composants UI standard),
- une bibliothèque de composants custom qui grandit progressivement,
- une édition "à la volée" sur la page visitée par l'admin.

## 2) Vision produit
Le thème doit devenir un "builder in-page" :
- un admin clique sur "Éditer cette page" depuis la page courante,
- GrapesJS s'ouvre en overlay sans changer d'écran,
- les composants se glissent/déposent en direct dans des zones éditables,
- la sauvegarde persiste par page et le rendu front est serveur-side.

## 3) Checkup rapide de l'existant
### Ce qui est déjà en place
- Intégration GrapesJS avec modules séparés (`gjs.init.js`, `gjs.blocks.js`, `gjs.components.js`, `gjs.theme.js`).
- Bouton admin d'édition et sauvegarde via `admin.themes.config`.
- Chargement des données builder + styles depuis `admin.themes.edit`.
- Rendu serveur des composants via Blade (`views/components/render/*`).
- Base de blocs Bootstrap: `container`, `row`, `col`, `text`, `button`.
- Panel de thème global (couleurs, typo, spacing, bordures, boutons).

### Écarts et points à corriger
- L'édition/rendu est centrée sur la homepage (`views/home.blade.php`) au lieu d'être réellement multi-pages.
- Stockage dans une seule clé `pagebuilder` sans scope route/page.
- Incohérence UI de fermeture: `closeBtn` masque `editorActions` alors que l'ID utilisé est `gpsActions`.
- `#gjs` est injecté globalement dans le layout, mais pas masqué inline par défaut.
- `Traits` et `RTE` sont initialisés mais vides.
- Le renderer `text` perd du formatage riche (gras/italique imbriqués) car il reconstruit surtout du texte.
- Dossier de preset de démo et fichiers dupliqués (`builder-2`) présents, ce qui ajoute de la dette technique.

## 4) Guidelines techniques
### Architecture
- Garder une séparation stricte des responsabilités.
- Utiliser `assets/js/gjs.*` pour le builder et ses plugins.
- Utiliser `views/components/render/*` pour le rendu front final.
- Utiliser `lang/*` pour tous les labels/traits/messages.
- Éviter toute logique métier lourde dans les Blade.

### Modèle de données
- Stocker par page et locale, pas en clé unique.
- Versionner les structures de composants (`schema_version`).
- Sauvegarder séparément `components`, `theme_tokens` et `metadata` (`updated_by`, `updated_at`, `route_key`).

### Contrat composant
- Chaque composant doit avoir un `type` stable (ex: `bs-button`, `custom-hero-server`).
- Chaque composant doit avoir un set de `traits` clairement défini.
- Chaque composant doit avoir un renderer Blade dédié.
- Chaque composant doit avoir une stratégie de migration si son schéma évolue.

### Sécurité
- Garder un rendu serveur whitelisté des balises/attributs.
- Valider et nettoyer les URLs (`href`, `target`) et styles inline.
- Restreindre strictement l'accès édition/sauvegarde aux admins.

### UX éditeur
- L'éditeur doit rester caché tant qu'il n'est pas ouvert.
- Offrir un mode "Edit this page" explicite avec feedback de statut.
- Préserver un fallback front propre si aucune config pagebuilder.

### Qualité
- Ajouter des tests minimaux de rendu Blade par type de composant.
- Ajouter des tests minimaux de sérialisation/désérialisation.
- Ajouter des tests minimaux sur la route de sauvegarde et les droits.
- Maintenir une convention de nommage homogène EN/FR côté labels.

## 5) Règles d'évolution (important)
- D'abord enrichir la base Bootstrap 5 avant de multiplier les composants custom.
- Chaque nouveau composant custom doit être livré avec block GrapesJS, type + traits, renderer Blade et exemples d'usage.
- Pas de merge sans validation sur mobile + desktop.
- Pas de régression sur le rendu public si l'éditeur est désactivé.

## 6) Résultat attendu
À terme, `pagebuilder` doit fonctionner comme un constructeur de pages Azuriom:
- contextuel à la page visitée,
- fiable au rendu public,
- extensible lot par lot avec des composants bootstrap puis custom métier.
