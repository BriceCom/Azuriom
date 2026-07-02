# SeoLite Guidelines

## 1) Objectif du plugin
SeoLite doit fournir une analyse SEO fiable, compréhensible et actionnable, sans perturber le front-office ni l’administration Azuriom.

## 2) Principes produit
- Prioriser la fiabilité des signaux avant d’ajouter de nouveaux indicateurs.
- Garder une UX simple: un score global + recommandations classées par priorité.
- Éviter les faux positifs: une recommandation doit être explicable et reproductible.

## 3) Architecture cible
- `src/`: logique backend Azuriom (providers, controllers, helpers).
- `resources/views/`: UI admin et composants offcanvas.
- `assets/js/module/`: 1 module = 1 responsabilité (métas, headings, images, lisibilité, etc.).
- `assets/js/utilities.js`: fonctions transverses uniquement (pas de logique métier spécifique).

## 4) Règles de code
- UTF-8 first: utiliser `mb_*` côté PHP pour compteurs caractères/mots multilingues.
- Éviter la duplication de logique de scoring (source unique des seuils).
- Pas de chaînes en dur dans les modules JS: passer par `trans(...)`.
- Supprimer les `console.log`/`console.debug` de production.
- Écrire du CSS valide navigateur (pas de syntaxe SCSS non compilée).

## 5) Règles i18n
- Convention de clés stable: `seolite::messages.<domaine>_<action>_<niveau>`.
- Une clé utilisée dans JS/PHP doit exister dans `resources/lang/*/messages.php`.
- Pour injecter les traductions dans JS: préférer `@json(...)` pour éviter les problèmes d’échappement.
- Limiter `{!! !!}` aux cas strictement nécessaires et maîtrisés.

## 6) Règles UX et accessibilité
- Chaque score de section doit afficher la valeur, le seuil attendu et la raison de la note.
- Chaque recommandation doit inclure une action concrète.
- Préserver navigation clavier et attributs ARIA des composants Bootstrap.

## 7) Règles de performance
- Les analyses front doivent être idempotentes et mises en cache quand possible.
- Éviter les scans DOM complets répétés.
- Exclure systématiquement l’UI SeoLite du texte analysé.
- Prévoir un mode de calcul asynchrone côté admin pour les listes volumineuses.

## 8) Règles de sécurité
- Ne jamais injecter du HTML utilisateur brut dans le DOM.
- Échapper toutes les interpolations JS provenant de traductions/DB.
- Vérifier les permissions avant tout affichage ou route d’administration.

## 9) Qualité et tests
- Minimum attendu pour chaque changement: test manuel front (page publique + admin), vérification i18n (aucune clé brute affichée), vérification score global stable après rechargement.
- Ajouter des tests unitaires sur les helpers de scoring (priorité haute).

## 10) Definition of Done
- Le calcul de score est cohérent entre modules.
- Aucune erreur JS dans la console.
- Les recommandations principales sont compréhensibles et actionnables.
- Les routes admin sont protégées et documentées.
- La version est incrémentée + changelog prêt.
