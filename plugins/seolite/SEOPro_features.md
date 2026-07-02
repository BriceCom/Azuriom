# SEOPro Features (Premium)

Date: 2026-04-21
Scope: couche premium au-dessus de `plugins/seolite`

## Objectif produit
SEOPro doit apporter les fonctions avancees qui font gagner du temps a grande echelle, centralisent les decisions SEO, et accelerent les resultats business.

## Repartition de la liste marketing (cote Pro)
- `Google Search Console Hook` -> Oui (PRO)
- `Link Cannibalism Detection` -> Oui (PRO)
- `External & Internal Link Inspector` -> Oui, version globale (graphe du site)
- `Advanced Meta-data Editor (No Theme Limitations)` -> Oui (PRO)
- `Regrouped SEO Dashboard` -> Oui (PRO)
- `Automatic Canonical Pages` -> Oui, moteur de regles (PRO)
- `SEO Penalty Prevention` -> Oui, detection site-wide + alertes (PRO)
- `TwitterCard & Social Preview Generator` -> Oui, version avancee (PRO)
- `EXPERIMENTAL LLMs.txt` -> Oui, mode beta (PRO)

## Fonctionnalites Premium

### 1. Crawler global et centre d audit (P0)
- Scanner toutes les URLs publiques depuis un seul dashboard (pages, posts, pages plugin, routes custom).
- Lancer des scans planifies (quotidien, hebdo) ou manuels.
- Detecter et regrouper les problemes: metas manquantes/dupliquees, canonical absent, hierarchie heading casse, OG/Twitter manquants, contenu faible, pages lentes, balises critiques manquantes.
- Prioriser automatiquement par severite et impact estime.

Criteres d acceptation:
1. Un clic lance un audit complet sans visiter les pages une par une.
2. Les resultats sont filtrables par type de probleme, severite, et pattern URL.
3. Chaque issue pointe vers un ecran de correction.

### 2. Advanced Meta-data Editor + Automatic Canonical Pages (P0)
- Edition en masse des metas sur un lot d URLs.
- Templates metadata avec variables (`{title}`, `{site_name}`, `{category}`).
- Regles metadata par type de route/type de contenu/tag.
- Detection des doublons et resolution de conflits.
- Generation automatique de canonical avec moteur de regles et priorites.

Criteres d acceptation:
1. Un admin peut mettre a jour 100+ pages en une action.
2. Une preview montre les metas finales avant publication.
3. La priorite des regles est deterministe et documentee.
4. Les canonical auto corrigent les conflits de duplication identifies.

### 3. Google Search Console Hook (P0)
- Connexion OAuth a une ou plusieurs proprietes.
- Import clics, impressions, CTR, position moyenne, top queries, top landing pages.
- Vue croisee: "issue SEO + opportunite CTR faible".

Criteres d acceptation:
1. La synchro quotidienne fonctionne avec retry et logs d erreur lisibles.
2. Les donnees sont filtrables par periode et par page/requete.
3. Le dashboard met en avant les pages a optimiser en premier.

### 4. Link Cannibalism Detection (P1)
- Detecter les groupes de pages qui ciblent la meme intention de recherche.
- Signaler collisions title/H1/query + dilution de CTR/position.
- Proposer action recommandee: fusionner, rediriger, re-cibler, canonicaliser.

Criteres d acceptation:
1. L admin voit les clusters de pages en cannibalisation avec niveau de risque.
2. Chaque cluster expose une action corrective priorisee.

### 5. External & Internal Link Inspector (P1)
- Construire une vue globale du maillage interne/externe sur tout le site.
- Identifier pages orphelines, hubs, depth excessive, liens sortants faibles.
- Visualiser la structure via graphe ou matrices filtrables.

Criteres d acceptation:
1. L admin peut filtrer la structure de liens par type de page et profondeur.
2. Les pages orphelines et zones faibles sont detectees automatiquement.

### 6. Regrouped SEO Dashboard + SEO Penalty Prevention (P1)
- Regrouper crawl, metas, cannibalisation, liens, GSC et priorites dans un dashboard unique.
- Afficher des widgets actionnables: top risques, top quick wins, top regressions.
- Detecter en continu les signaux de penalite (multiple H1, metas manquantes, thin content) a l echelle du site.

Criteres d acceptation:
1. Toutes les donnees SEO majeures sont visibles sur une seule page.
2. Les alertes de risque SEO sont historisees et priorisees.

### 7. TwitterCard & Social Preview Generator (P1)
- Generer/valider les balises Twitter Card et Open Graph de facon centralisee.
- Previsualiser le rendu partage (X/Twitter, Discord, Facebook) avant publication.
- Proposer templates par type de page.

Criteres d acceptation:
1. L utilisateur voit la preview sociale finale avant de publier.
2. Les erreurs de balises sociales sont detectees automatiquement.

### 8. EXPERIMENTAL LLMs.txt (P2)
- Ajouter un editeur `llms.txt` experimental pour guider crawlers IA/LLM.
- Fournir presets de base + avertissement beta.
- Journaliser les changements pour rollback rapide.

Criteres d acceptation:
1. La feature est activable/desactivable proprement depuis l admin.
2. Les versions de `llms.txt` sont historisees.

### 9. Toolbox SEO technique (P1)
- Controle qualite sitemap XML + detection URLs obsoletes.
- Gestionnaire de redirections (301/302) avec detection boucles/chaines.
- Detection des liens casses.

Criteres d acceptation:
1. Les changements passent des checks de securite avant publication.
2. Les erreurs critiques sont signalees avant impact indexation.

### 10. Reporting et exports (P1)
- Rapports management avec priorites, tendances, issues ouvertes/resolues.
- Exports CSV/PDF.
- Envoi planifie par email aux membres d equipe.

Criteres d acceptation:
1. Rapports generables a la demande et en mode planifie.
2. Les tableaux/graphes cles sont exportables.

### 11. Workflow equipe et API (P2)
- Assigner les taches SEO (owner, due date, statut).
- Historique des modifications metadata.
- Webhooks/API pour outils BI ou automatisation externe.

Criteres d acceptation:
1. Chaque issue SEO peut avoir un proprietaire et un statut.
2. Une trace d audit est disponible pour debug et suivi.

## Positionnement Premium
SEOPro vend la scalabilite et la vitesse d execution:
- passer du controle manuel page par page a une gouvernance SEO globale
- passer des recommandations statiques a des donnees connectees (GSC + tendances + concurrence)
- passer du diagnostic a l execution d equipe
