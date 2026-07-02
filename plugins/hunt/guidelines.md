# Hunt Plugin - Guidelines

## 1) Vue d’ensemble
Le plugin `hunt` ajoute une mécanique de chasse interactive:
- une hunt active est sélectionnée côté serveur,
- un item visuel apparaît aléatoirement côté front,
- le joueur clique pour tenter de claim,
- le serveur valide les règles (auth, période, cap, cooldown, limite journalière),
- une récompense est distribuée (argent site et/ou commandes serveur),
- un log est écrit et la progression journalière est mise à jour.

Le plugin ne dépend d’aucune API externe: toute la logique est interne Azuriom.

## 2) Architecture

### Providers
- `src/Providers/RouteServiceProvider.php`
  - routes web (`/hunt`), admin (`/admin/hunt`), api locale (`/api/hunt`, actuellement vide).
- `src/Providers/HuntServiceProvider.php`
  - charge vues/lang/migrations,
  - enregistre permission `hunt.admin`,
  - enregistre logs d’actions,
  - injecte automatiquement le display hunt via view composer sur `*layouts.base`.

### Controllers
- Public: `src/Controllers/HuntController.php`
  - `index`, `show`, `getHuntData`, `claim`.
- Admin:
  - `Admin/HuntController.php` (CRUD hunts + archive/restore + stats),
  - `Admin/RewardController.php` (CRUD rewards + bulk/toggle/clone),
  - `Admin/LogController.php` (listing, filtres, détail, stats JSON),
  - `Admin/SettingsController.php` (écran info + règles d’affichage automatiques).

### Models
- `Hunt` (`hunt_hunts`)
  - règles métier: active/current, priorité, cap global, droit au claim.
- `HuntReward` (`hunt_rewards`)
  - éligibilité rôles, probabilité, dispatch argent/commandes.
- `HuntLog` (`hunt_logs`)
  - historique complet des claims.
- `HuntUserDaily` (`hunt_user_daily`)
  - suivi journalier claims/cooldown/argent.

### Frontend
- Script principal: `assets/js/hunt.js`.
- Injection globale: `resources/views/partials/_hunt_display.blade.php`.
- Pages publiques:
  - `resources/views/index.blade.php`,
  - `resources/views/show.blade.php`,
  - composants `resources/views/components/*`.

## 3) Flux métier principal (claim)
1. Front appelle `GET /hunt/data` pour récupérer la hunt active + statut utilisateur.
2. Front déclenche un spawn local selon probabilité/délai (`spawn_rate`, `spawn_delay_seconds`).
3. Au clic, front appelle `POST /hunt/claim`.
4. Serveur vérifie:
  - utilisateur connecté,
  - hunt active et dans la période,
  - cap global non atteint,
  - limite journalière non atteinte,
  - cooldown expiré.
5. Serveur fait un check probabilité (`spawn_rate`) puis sélectionne une reward éligible.
6. Dispatch reward:
  - `addMoney()` si montant,
  - commandes bridge serveur si configurées.
7. Écriture log + update `HuntUserDaily`.
8. Retour JSON pour modale front + progression.

## 4) Routes locales

### Web
- `GET /hunt` -> liste hunts.
- `GET /hunt/data` -> data JSON temps réel.
- `POST /hunt/claim` -> tentative claim.
- `GET /hunt/{hunt}` -> détail hunt + leaderboard.

### Admin
- Hunts:
  - `GET /admin/hunt` index,
  - `GET /admin/hunt/create`, `POST /admin/hunt`,
  - `GET /admin/hunt/{hunt}`, `GET /admin/hunt/{hunt}/edit`, `PUT /admin/hunt/{hunt}`, `DELETE /admin/hunt/{hunt}`,
  - `POST /admin/hunt/{hunt}/archive`, `POST /admin/hunt/{hunt}/restore`.
- Rewards:
  - resource `rewards` (index/create/store/edit/update/destroy),
  - `POST /admin/hunt/rewards/bulk-toggle`,
  - `POST /admin/hunt/rewards/{reward}/toggle-enabled`,
  - `POST /admin/hunt/rewards/{reward}/clone`.
- Logs:
  - `GET /admin/hunt/logs`,
  - `GET /admin/hunt/logs/statistics`,
  - `GET /admin/hunt/logs/{log}`.
- Settings:
  - `GET /admin/hunt/settings`,
  - `PUT /admin/hunt/settings`.

### API locale
- `routes/api.php` existe mais ne déclare actuellement aucune route.

## 5) Schéma de données
- `hunt_hunts`
  - config de hunt: nom, slug, image, priorité, limites, dates, status.
- `hunt_rewards`
  - récompenses: chances, money, commands, need_online, enabled.
- `hunt_reward_role`
  - pivot rôles éligibles par reward.
- `hunt_reward_server`
  - pivot serveurs cibles pour commandes.
- `hunt_logs`
  - logs techniques et métier de chaque claim.
- `hunt_user_daily`
  - état journalier par utilisateur et par hunt.

## 6) Règles métier importantes
- Une seule hunt courante prioritaire est utilisée (`Hunt::getCurrentHunt`).
- Le cap global (`global_cap`) s’applique à l’ensemble des claims d’une hunt.
- La limite journalière est par utilisateur et par hunt (`max_per_day`).
- Le cooldown est stocké dans `HuntUserDaily.cooldown_until`.
- Les rewards peuvent être filtrées par rôles.
- Une reward peut donner argent, commandes, ou les deux.

## 7) Points sensibles actuels
- Migration dupliquée `spawn_delay_seconds` (risque d’échec en installation fraîche).
- Quelques incohérences Blade/traductions:
  - include hunt card mal passé,
  - directive `@guest` fermée en `@endauth`,
  - clés de traduction manquantes (permissions + validations rewards + messages JS).
- Méthodes contrôleurs non reliées à des routes (code mort partiel).
- Logs debug JS très verbeux en production.

## 8) Conventions recommandées
- Garder toute logique métier dans modèles/controllers, pas dans JS.
- Utiliser des clés de traduction existantes uniquement, avec fallback explicite si besoin.
- Centraliser les scripts communs admin rewards dans `_form.blade.php` pour éviter duplication.
- Préférer une convention unique de routing public (`id` ou `slug`) et l’appliquer partout.

## 9) Checklist avant release
- Migrer sur base fraîche et valider toutes migrations.
- Tester claim complet (success + tous cas erreur).
- Tester distribution argent + commandes bridge.
- Vérifier cohérence des traductions sur toutes pages.
- Vérifier leaderboard, logs admin, filtres et stats.
- Vérifier affichage de l’item hunt sur desktop/mobile et routes exclues.

## 10) Évolutions
Voir `plugins/hunt/next_features.md` pour la roadmap priorisée (P0 à P3).
