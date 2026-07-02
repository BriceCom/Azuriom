# SFD — Daily Reward (Spécification Azuriom)
> Plugin Azuriom | Laravel | Récompenses quotidiennes avec streak  
> Version de spec: 2026-04-27

---

## 1. Objectif

Construire un plugin **Daily Reward** compatible Azuriom qui permet :

- une claim quotidienne par joueur,
- une progression de streak configurable,
- des récompenses en crédits et/ou commandes serveur,
- une administration claire via le dashboard Azuriom.

La spec ci-dessous est alignée sur les patterns utilisés dans les plugins Azuriom (`vote`, `shop`, `hunt`, `suggest`, `tebex`).

---

## 2. Compatibilité Azuriom

### Cible

- `azuriom_api`: `^1.2.0` (à ajuster selon le cœur installé)
- PHP: `>=8.1`
- Type Composer: `azuriom-plugin`

### Principes Azuriom à respecter

- Provider principal: `BasePluginServiceProvider`
- Provider routes: `BaseRouteServiceProvider`
- Permissions: `Permission::registerPermissions([...])`
- Settings: `Setting::updateSettings([...])` + helper `setting(...)`
- Logs: `ActionLog::registerLogModels()` et `ActionLog::registerLogs()`
- Commandes serveur: `$server->bridge()->sendCommands(...)`
- Crédits joueur: `$user->addMoney(...)`

---

## 3. Structure technique minimale

```text
plugins/daily-reward/
├── plugin.json
├── composer.json
├── routes/
│   ├── web.php
│   ├── admin.php
│   └── api.php               (optionnel au MVP)
├── src/
│   ├── Providers/
│   │   ├── DailyRewardServiceProvider.php
│   │   └── RouteServiceProvider.php
│   ├── Controllers/
│   │   ├── DailyRewardController.php
│   │   ├── Admin/SettingController.php
│   │   ├── Admin/DayController.php
│   │   └── Admin/RewardController.php
│   ├── Requests/
│   │   ├── Admin/DailyRewardSettingsRequest.php
│   │   ├── Admin/DayRequest.php
│   │   └── Admin/RewardRequest.php
│   ├── Models/
│   │   ├── DailyRewardDay.php
│   │   ├── DailyRewardReward.php
│   │   ├── DailyRewardClaim.php
│   │   └── DailyRewardUserState.php
│   ├── Services/
│   │   ├── DailyRewardService.php
│   │   └── RewardDispatcher.php
│   └── Commands/
│       └── DailyRewardReminderCommand.php   (optionnel)
├── database/migrations/
├── resources/views/
└── resources/lang/
```

---

## 4. Conventions de routes

### RouteServiceProvider

- `web`: préfixe `daily-reward`, noms `daily-reward.*`
- `admin`: préfixe `admin/daily-reward`, noms `daily-reward.admin.*`, middleware `admin-access`
- `api` (optionnel): préfixe `api/daily-reward`, noms `daily-reward.api.*`

### Exemples de routes

- `GET /daily-reward` -> `daily-reward.index`
- `POST /daily-reward/claim` -> `daily-reward.claim` (middleware `auth`)
- `GET /admin/daily-reward` -> `daily-reward.admin.settings`
- `POST /admin/daily-reward` -> `daily-reward.admin.settings.save`
- `resource /admin/daily-reward/days` -> gestion du cycle et des récompenses

---

## 5. Paramètres globaux (Settings Azuriom)

Ne pas créer de table `daily_reward_configs` pour le MVP.  
Utiliser la table native `settings` via `Setting::updateSettings`.

### Clés recommandées

| Clé | Type | Défaut | Description |
|---|---|---|---|
| `daily_reward.enabled` | bool | `true` | Active/désactive le plugin côté front |
| `daily_reward.reset_mode` | string | `midnight` | `midnight` ou `rolling_24h` |
| `daily_reward.cycle_length` | int | `7` | Taille du cycle |
| `daily_reward.reminder_enabled` | bool | `false` | Active les rappels (optionnel) |
| `daily_reward.reminder_delay_hours` | int | `20` | Délai avant rappel (optionnel) |
| `daily_reward.public_leaderboard` | bool | `true` | Active la page leaderboard |

---

## 6. Modèle de données (tables plugin)

Toutes les tables plugin sont préfixées `daily_reward_`.

### `daily_reward_days`

- `id`
- `day_number` (unique)
- `label` (nullable)
- `is_enabled` (bool, défaut `true`)
- timestamps

### `daily_reward_rewards`

- `id`
- `day_id` (FK -> `daily_reward_days`)
- `name` (string)
- `type` (`money` | `command`)
- `money` (decimal nullable)
- `commands` (json nullable)
- `need_online` (bool, défaut `false`)
- `is_enabled` (bool, défaut `true`)
- timestamps

### `daily_reward_reward_server` (pivot)

- `reward_id` (FK -> `daily_reward_rewards`)
- `server_id` (FK -> `servers`)
- index unique (`reward_id`, `server_id`)

### `daily_reward_user_states`

- `id`
- `user_id` (unique, FK -> `users`)
- `streak_count` (int, défaut `0`)
- `max_streak` (int, défaut `0`)
- `next_day_number` (int, défaut `1`)
- `last_claim_at` (timestamp nullable)
- timestamps

### `daily_reward_claims`

- `id`
- `user_id` (FK -> `users`)
- `day_number` (int)
- `streak_before` (int)
- `streak_after` (int)
- `rewards_snapshot` (json nullable)
- `claimed_at` (timestamp)
- timestamps
- index (`user_id`, `claimed_at`)

---

## 7. Récompenses et variables

### Types supportés

- `money`: crédite le solde Azuriom via `$user->addMoney(...)`
- `command`: exécute des commandes sur un ou plusieurs serveurs liés à la récompense

### Dispatch commandes

- Utiliser `$server->bridge()->sendCommands($commands, $user, $needOnline)`
- Ne pas appeler RCON manuellement dans le plugin

### Variables de template commande

| Variable | Description |
|---|---|
| `{player}` | Nom du joueur |
| `{user}` | Alias de `{player}` |
| `{day}` | Jour du cycle |
| `{streak}` | Streak actuel après claim |
| `{reward}` | Nom de la récompense |

---

## 8. Logique de claim (idempotente)

La claim doit être transactionnelle.

### Règles

- utilisateur authentifié obligatoire,
- plugin activé (`daily_reward.enabled`),
- cycle configuré (`cycle_length >= 1`),
- lock sur l’état utilisateur (`lockForUpdate`) pendant la claim,
- revalidation après lock (anti double clic / anti race condition).

### Modes de reset

- `midnight`:
  - claim autorisée si aucune claim sur la date courante (timezone site),
  - streak cassé si dernière claim antérieure à J-1.
- `rolling_24h`:
  - claim autorisée si `now() - last_claim_at >= 24h`,
  - streak cassé si `now() - last_claim_at > 48h`.

### Résultat d’une claim

1. déterminer le `day_number` courant (`next_day_number`),
2. charger les récompenses actives du jour,
3. distribuer via `RewardDispatcher`,
4. écrire `daily_reward_claims`,
5. mettre à jour `daily_reward_user_states` (`streak_count`, `max_streak`, `next_day_number`, `last_claim_at`),
6. retourner un payload clair pour l’UI (succès + récompenses + prochain délai).

---

## 9. Couche admin (dashboard Azuriom)

### Permissions recommandées

| Permission | Usage |
|---|---|
| `daily-reward.admin` | Accès général au plugin |
| `daily-reward.settings` | Modifier les réglages globaux |
| `daily-reward.days` | Gérer les jours du cycle |
| `daily-reward.rewards` | Gérer les récompenses |
| `daily-reward.logs` | Consulter l’historique |

### Navigation admin

Dropdown `Daily Reward`:

- Paramètres
- Jours du cycle
- Récompenses
- Historique des claims
- Statistiques (optionnel)

### Validation

- utiliser des `FormRequest` dédiées,
- utiliser `ConvertCheckbox` pour les booléens HTML,
- interdire récompense vide:
  - type `money` -> `money > 0`
  - type `command` -> `commands` non vide + au moins un serveur

---

## 10. Couche front joueur

### Page principale (`daily-reward.index`)

- streak actuel,
- statut de claim (disponible / cooldown),
- grille du cycle (jour courant, déjà claim, à venir),
- bouton de claim (POST),
- feedback des récompenses obtenues.

### Leaderboard (optionnel)

- activable via setting `daily_reward.public_leaderboard`,
- top streak actuel,
- top max streak historique.

---

## 11. Logs et audit

Enregistrer les actions sensibles:

- modification des settings,
- création/édition/suppression de jour,
- création/édition/suppression de récompense.

Utiliser `ActionLog` pour rester cohérent avec l’admin Azuriom.

---

## 12. Scheduler (optionnel)

Le plugin peut fonctionner sans commande cron dédiée (reset calculé à la volée lors de la claim).  
Une commande planifiée est utile pour les rappels.

### Exemple

- commande: `daily-reward:remind`
- schedule: `hourly()`
- garde-fou: ne pas notifier deux fois la même fenêtre

---

## 13. Intégrations optionnelles

### Webhook Discord (annonces de streak)

- stocker l’URL webhook en setting,
- isoler l’appel HTTP dans un service dédié,
- ne jamais bloquer la claim si Discord est indisponible.

### API plugin (bots externes)

- conserver `routes/api.php` optionnel,
- protéger les endpoints (token signé ou middleware dédié),
- retourner des payloads stables et versionnés.

---

## 14. Roadmap réaliste

### P0 — Skeleton Azuriom

- `plugin.json`, `composer.json`, providers, routes
- migrations + modèles
- permissions + navigation admin

### P1 — MVP claim quotidienne

- settings admin (mode reset, cycle, activation)
- CRUD jours/récompenses
- page joueur + claim transactionnelle

### P2 — Durcissement

- logs admin
- tests manuels de concurrence (double submit)
- fallback robustes sur erreurs bridge serveur

### P3 — Extensions

- leaderboard
- rappels
- webhook Discord
- endpoints API externes

---

## 15. Checklist de tests manuels

1. Installer/désinstaller le plugin sans erreur.
2. Vérifier les permissions: un admin sans `daily-reward.settings` ne peut pas modifier les paramètres.
3. Vérifier `midnight`: une seule claim par date locale.
4. Vérifier `rolling_24h`: claim bloquée avant 24h.
5. Simuler une rupture de streak (>48h en rolling, jour manqué en midnight).
6. Vérifier distribution crédits (`addMoney`) et commandes (`bridge()->sendCommands`).
7. Vérifier qu’un double clic sur claim ne crée pas deux récompenses.
8. Vérifier la résilience: erreur bridge n’annule pas tout le traitement sans message explicite.

---

## 16. Notes d’implémentation

- Namespace recommandé: `Azuriom\Plugin\DailyReward\...`
- Id plugin recommandé: `daily-reward`
- Préfixe SQL recommandé: `daily_reward_`
- Clés de traduction: `daily-reward::...`
- Nommage des routes: `daily-reward.*`

