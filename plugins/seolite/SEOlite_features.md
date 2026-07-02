# SEOlite Features (Freemium)

Date: 2026-04-21
Scope: plugin `plugins/seolite` pour Azuriom

## Objectif produit
SEOlite doit corriger les blocages SEO essentiels dans Azuriom avec une version gratuite utile en production.
Priorite absolue: pouvoir modifier `meta title` et `meta description` page par page.

## Repartition de la liste marketing (cote Lite)
- `Google Search Console Hook` -> Non (PRO uniquement)
- `Link Cannibalism Detection` -> Non (PRO uniquement)
- `External & Internal Link Inspector` -> Oui, version simple (analyse de la page courante)
- `Advanced Meta-data Editor (No Theme Limitations)` -> Oui, version manuelle page par page (pas bulk)
- `Regrouped SEO Dashboard` -> Oui, version dashboard de base
- `Automatic Canonical Pages` -> Oui, version automatique simple sur contenus natifs
- `SEO Penalty Prevention` -> Oui, detection en temps reel sur la page en cours
- `TwitterCard & Social Preview Generator` -> Oui, verification + preview simple
- `EXPERIMENTAL LLMs.txt` -> Non (PRO uniquement)

## Fonctionnalites Freemium

### 1. Editeur de metas par page (P0)
- Ajouter un bloc SEO dans les formulaires d edition (posts d abord, puis pages et autres contenus natifs).
- Champs: `seo_title`, `seo_description`, `og_title`, `og_description`, `og_image`, `canonical_url`, `robots_index`, `robots_follow`.
- Ajouter compteur de caracteres + zone optimale (title 50-60, description 120-160).
- Ajouter une preview SERP (rendu desktop).
- Ajouter un fallback automatique si un champ est vide.

Criteres d acceptation:
1. Un admin peut definir un title/description personnalise pour une page sans impacter les autres pages.
2. Le HTML final dans `<head>` prend la valeur page si elle existe.
3. Si la valeur page est vide, la chaine de fallback s applique sans meta vide.

### 2. Moteur de fallback metadata (P0)
- Definir une chaine de priorite stable: page override -> valeur du contenu -> valeur globale plugin -> valeur theme/Azuriom.
- Ajouter un ecran admin pour les valeurs globales (suffix title, description par defaut, image sociale par defaut).

Criteres d acceptation:
1. Chaque page publique a un title et une description non vides.
2. Une meme page retourne toujours les memes metas pour les memes donnees.

### 3. Analyseur SEO temps reel (P1)
- Garder l offcanvas actuel et fiabiliser le moteur de score.
- Conserver modules: metas, headings, lisibilite, keyword density, image alt, image format, recommandations.
- Exclure l UI SeoLite de l extraction de texte.
- Garder severite + actions concretes par recommandation.

Criteres d acceptation:
1. Aucune erreur JS sur pages Azuriom standard.
2. Les scores restent stables apres ouverture/fermeture de l offcanvas.
3. Les recommandations sont triees par severite avec action explicite.

### 4. Cockpit d analyse des articles (P1)
- Conserver la liste d articles avec indicateurs SEO/lisibilite.
- Ajouter filtres: recherche, plage de score, plage de lisibilite, faible volume de mots.
- Ajouter tri: score le plus faible, date la plus ancienne, opportunite la plus forte.

Criteres d acceptation:
1. Un admin identifie les 10 pages prioritaires en moins de 2 minutes.
2. Filtres et tri restent actifs pendant la pagination.

### 5. Historique simple des scores (P1)
- Sauvegarder des snapshots par article (metriques principales) a chaque analyse.
- Afficher un delta simple: score en hausse ou baisse depuis le snapshot precedent.

Criteres d acceptation:
1. L admin voit immediatement si une page progresse ou regresse.
2. Le stockage des snapshots ne degrade pas le rendu public.

### 6. i18n et stabilite (P1)
- Parite complete `en` et `fr`.
- Retirer les textes hardcodes dans les modules JS.
- Injecter les traductions JS via JSON (pas interpolation fragile).

Criteres d acceptation:
1. Aucune cle brute `seolite::messages.*` visible.
2. Fonctionnement correct en EN et FR sans probleme d echappement.

### 7. Editeur robots.txt (P1)
- Ajouter un ecran admin SEOlite pour editer le contenu `robots.txt`.
- Ajouter un template par defaut pre-rempli (safe) au premier usage.
- Ajouter verification minimale avant sauvegarde (presence directives de base, taille raisonnable).
- Ajouter bouton "Restaurer le template par defaut".

Criteres d acceptation:
1. Un admin peut modifier `robots.txt` sans edition manuelle des fichiers serveur.
2. Le fichier est servi correctement apres sauvegarde.
3. Une restauration rapide vers un template valide est possible.

## Limites Freemium (hors scope)
- Pas de crawler global de tout le site.
- Pas de generation bulk automatique de metas.
- Pas de synchronisation Google Search Console.
- Pas de detection de cannibalisation de mots-cles a l echelle du site.
- Pas de graphe global du maillage interne/externe.
- Pas d analyse concurrentielle.
- Pas de dashboard unifie avec donnees externes.
- Pas de generateur social avance base templates.
- Pas de support LLMs.txt experimental.
- Pas de reporting PDF/CSV planifie.

## Ordre de livraison recommande
1. Editeur de metas par page
2. Moteur de fallback
3. Stabilisation analyseur
4. Filtres et tri articles
5. Snapshots de tendance
6. Durcissement i18n
7. Editeur robots.txt
