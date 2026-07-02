# Hunt Plugin - Next Features

## Objectif
Documenter les améliorations, manques et prochaines étapes pour `plugins/hunt` (plugin 100% maison, sans API externe).

## État global
- Couvre déjà un socle complet: hunts, rewards, logs, leaderboard, claim AJAX, cooldown, cap global, limites journalières.
- Le plugin est fonctionnel, mais comporte plusieurs incohérences techniques et quelques régressions probables.

## Priorité P0 (faite)
- Corriger la migration dupliquée `spawn_delay_seconds`.
  - `database/migrations/2025_11_22_000001_create_hunt_hunts_table.php` crée déjà la colonne.
  - `database/migrations/2025_12_10_180900_add_spawn_delay_seconds_to_hunt_hunts_table.php` la recrée.
  - Risque: échec migration sur installation fraîche.
- Corriger l’inclusion Blade dans `resources/views/index.blade.php`.
  - `@include('hunt::components.hunt-card', $hunt)` devrait passer un tableau (`['hunt' => $hunt]`).
- Corriger la directive Blade invalide dans `resources/views/components/hunt-infos.blade.php`.
  - `@guest ... @endauth` doit être `@guest ... @endguest`.
- Corriger les clés de traduction manquantes/cassées pour validations rewards.
  - `RewardRequest` utilise `rewards.validation.chances_range`, `money_positive`, `command_length`, `reward_required`, `servers_required_for_commands`.
  - Ces clés ne sont pas présentes dans `resources/lang/en/admin.php` (noms différents actuellement).
- Corriger la permission traduite manquante.
  - `HuntServiceProvider` enregistre `hunt::admin.permission`, mais la clé existante est `hunt::admin.permissions.admin`.

## Priorité P1 (faite)
- Aligner les liens JS sur la route hunt publique.
  - `assets/js/hunt.js` construit `/hunt/${result.hunt.id}` alors que la réponse contient aussi `slug`.
  - Décider une convention claire (ID ou slug) et l’utiliser partout.
- Réduire les incohérences de traduction/front.
  - Plusieurs textes JS tombent sur des clés inexistantes (`warnings`, `error`, `hunt_error`, `time_remaining`).
- Nettoyer le code mort/non branché.
  - Méthodes contrôleurs sans route: `Admin\HuntController::toggleActive`, `Admin\RewardController::test`, `Admin\RewardController::getForHunt`.
  - `routes/api.php` est vide: soit supprimer la surface API locale, soit exposer de vrais endpoints.

## Priorité P2 (faite)
- Réduire les duplications JS admin rewards.
  - `resources/views/admin/rewards/_form.blade.php` contient déjà la logique add/remove/validation des commandes.
  - `create.blade.php` et `edit.blade.php` réinjectent la même logique.
- Harmoniser les messages et règles métier.
  - UI indique parfois `global_cap = 0` illimité, alors que la validation attend `min:1` ou `null`.
- Remplacer les `console.log` debug dans `assets/js/hunt.js` par logs conditionnels (mode debug).

## Priorité P3 (faite)
- Durcir la concurrence sur `claim`.
  - Ajouter une protection transactionnelle pour éviter de dépasser `global_cap` en cas de clics simultanés.
- Ajouter des index DB complémentaires selon volumétrie.
  - Ex: `hunt_logs(created_at)` et `hunt_logs(user_id, created_at)` pour les écrans logs/statistiques.

## Priorité P4 (reportée)
- Ajouter nettoyage planifié des stats journalières.
  - Planifier `HuntUserDaily::cleanup()` via commande scheduler quand le volume d'historique le justifiera.
  - Pour le besoin actuel, des requêtes SQL ponctuelles suffisent.

## Tests (en cours)
- Déjà en place:
  - `tests/Unit/Plugins/Hunt/TranslationCoverageTest.php` (couverture clés JS -> `hunt::messages`, et absence de `aria-label="Close"` brut dans les vues hunt).
  - `tests/Unit/Plugins/Hunt/DryStructureTest.php` (garde-fou DRY sur les scripts rewards, et page settings sans formulaire éditable).
  - `tests/Unit/Plugins/Hunt/HuntCanUserClaimLogicTest.php` (branches métier de `Hunt::canUserClaim`: inactive, cap global, limite journalière, cooldown, cas OK).
  - `tests/Unit/Plugins/Hunt/HuntUserDailyLogicTest.php` (remaining claims, cooldown remaining, progress payload).
  - `tests/Unit/Plugins/Hunt/HuntRewardLogicTest.php` (éligibilité rôles, sélection de reward).
  - `tests/Feature/Plugins/Hunt/HuntClaimHttpFlowTest.php` (flux HTTP claim complet: non connecté, pas de hunt active, cap global, limite journalière, cooldown, spawn fail, succès + log).
- Tests feature `claim`:
  - non connecté,
  - hunt inactive,
  - cap global atteint,
  - limite journalière atteinte,
  - cooldown actif,
  - succès avec reward,
  - succès sans reward.
  - Restant à ajouter: succès avec reward monétaire/commandes (cas de dispatch).
- Tests unitaires modèles:
  - `Hunt::canUserClaim`,
  - `HuntReward::isUserEligible`, `selectRandomReward`,
  - `HuntUserDaily::recordClaim`, `getCooldownRemainingMinutes`.
- Tests de régression vues Blade pour détecter directives/`@include` invalides.

## Roadmap proposée
1. Stabilisation critique (P0).
2. Cohérence fonctionnelle et nettoyage route/code mort (P1).
3. Refactor qualité front/admin + traductions (P2).
4. Durcissement concurrence + index DB + tests (P3).
5. Maintenance planifiée des stats journalières (P4).
