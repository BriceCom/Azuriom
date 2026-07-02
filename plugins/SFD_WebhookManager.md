# SFD — Plugin Webhook Manager
> Plugin Azuriom | Laravel | Destination : Discord | Payload JSON custom

---

## 1. Présentation du plugin

Le **Webhook Manager** est un plugin Azuriom permettant aux administrateurs de configurer de manière centralisée des webhooks sortants vers Discord. Chaque webhook est associé à un événement déclencheur, dispose d'un payload JSON entièrement personnalisable avec des variables dynamiques, de headers HTTP custom, d'une signature HMAC et peut être étendu par d'autres plugins via une API publique.

---

## 2. Stack technique

| Élément | Technologie |
|---|---|
| CMS | Azuriom |
| Backend | Laravel (PHP) |
| Frontend | Blade + JS vanilla |
| HTTP Client | Laravel Http Facade |
| Base de données | MySQL / MariaDB (migrations Laravel) |
| Queues | Laravel Queue (optionnel, P5) |

---

## 3. Événements déclencheurs supportés

| Identifiant | Description |
|---|---|
| `user.registered` | Nouvel inscrit sur le site |
| `order.paid` | Achat validé en boutique |
| `admin.login` | Connexion d'un administrateur |
| `user.voted` | Vote serveur effectué |
| `ticket.created` | Nouveau ticket support ouvert |
| `custom.*` | Events custom déclarés par d'autres plugins (P8) |

---

## 4. Structure de la base de données

### Table `webhooks`

| Colonne | Type | Description |
|---|---|---|
| `id` | bigint PK | Identifiant |
| `name` | string | Nom lisible du webhook |
| `url` | string | URL Discord webhook |
| `event` | string | Identifiant de l'event déclencheur |
| `payload_template` | JSON | Template du payload avec variables |
| `headers` | JSON nullable | Headers HTTP custom |
| `secret` | string nullable | Clé secrète pour signature HMAC |
| `is_active` | boolean | Actif ou non |
| `created_at` | timestamp | — |
| `updated_at` | timestamp | — |

### Table `webhook_logs`

| Colonne | Type | Description |
|---|---|---|
| `id` | bigint PK | Identifiant |
| `webhook_id` | FK → webhooks | Webhook concerné |
| `event` | string | Event qui a déclenché l'envoi |
| `payload_sent` | JSON | Payload réellement envoyé |
| `response_status` | integer | Code HTTP retourné |
| `response_body` | text nullable | Corps de la réponse |
| `sent_at` | timestamp | Date d'envoi |

---

## 5. Variables dynamiques par événement

Les variables s'insèrent dans le payload template avec la syntaxe `{variable}`.

### Variables communes (tous les events)
| Variable | Description |
|---|---|
| `{user.name}` | Pseudo du joueur |
| `{user.email}` | Email du joueur |
| `{site.name}` | Nom du site Azuriom |
| `{date}` | Date et heure de l'événement |

### `user.registered`
| Variable | Description |
|---|---|
| `{user.name}` | Pseudo du nouvel inscrit |
| `{user.email}` | Email du nouvel inscrit |

### `order.paid`
| Variable | Description |
|---|---|
| `{order.total}` | Montant total de la commande |
| `{order.items}` | Liste des articles achetés |
| `{order.id}` | Identifiant de la commande |

### `admin.login`
| Variable | Description |
|---|---|
| `{admin.name}` | Pseudo de l'admin connecté |
| `{admin.ip}` | Adresse IP de connexion |

### `user.voted`
| Variable | Description |
|---|---|
| `{vote.server_name}` | Nom du serveur voté |
| `{vote.site}` | Site de vote utilisé |

### `ticket.created`
| Variable | Description |
|---|---|
| `{ticket.subject}` | Sujet du ticket |
| `{ticket.id}` | Identifiant du ticket |
| `{ticket.category}` | Catégorie du ticket |

---

## 6. Architecture des classes

```
src/
├── Providers/
│   └── WebhookManagerServiceProvider.php
├── Models/
│   ├── Webhook.php
│   ├── WebhookService.php          ✅ déjà développé
│   └── WebhookLog.php
├── Http/
│   └── Controllers/
│       └── Admin/
│           ├── WebhookController.php
│           └── WebhookServiceController.php  ✅ déjà développé
├── Services/
│   ├── WebhookDispatcher.php
│   └── VariableResolver.php
├── Listeners/
│   ├── UserRegisteredListener.php
│   ├── OrderPaidListener.php
│   ├── AdminLoginListener.php
│   ├── UserVotedListener.php
│   └── TicketCreatedListener.php
└── Facades/
    └── WebhookManager.php
```

---

## 7. Système de Services (connecteurs) — ✅ Déjà développé

> Cette section documente l'architecture des **Services** qui est considérée comme acquise. Les phases de développement ci-dessous s'appuient sur ce système.

### Concept

Un **Service** représente une destination de webhook réutilisable et configurable indépendamment des règles de déclenchement. Au lieu de saisir une URL brute à chaque création de webhook, l'admin crée un Service une fois et le sélectionne depuis n'importe quel webhook.

```
Service (connecteur)
    └── Nom, URL, identité visuelle (bot name, avatar, couleur)
            ↓ référencé par
Webhook
    └── Service + Event + Payload template
```

### Table `webhook_services`

| Colonne | Type | Description |
|---|---|---|
| `id` | bigint PK | Identifiant |
| `name` | string | Nom lisible (ex: "Discord #sanctions") |
| `type` | enum | `discord`, `slack`, `custom` |
| `url` | string | URL du webhook distant |
| `bot_name` | string nullable | Nom affiché du bot Discord |
| `bot_avatar` | string nullable | URL de l'avatar du bot |
| `default_color` | string nullable | Couleur hex de l'embed Discord |
| `created_at` | timestamp | — |
| `updated_at` | timestamp | — |

### Impact sur la table `webhooks`

La colonne `url` est remplacée par `service_id` (FK → `webhook_services`).

| Colonne | Type | Description |
|---|---|---|
| `service_id` | FK → webhook_services | Service utilisé par ce webhook |

### Avantages

- **Maintenabilité** — Modifier l'URL d'un service met à jour tous les webhooks liés en une seule opération
- **Réutilisabilité** — Un même service (ex: "Discord #général") peut être assigné à autant de webhooks que nécessaire
- **Personnalisation centralisée** — Le nom du bot et l'avatar sont définis une fois par service
- **Extensibilité** — L'ajout d'un nouveau type (Slack, Telegram) se fait au niveau du Service sans impacter les webhooks

### Architecture des classes ajoutées

```
src/
├── Models/
│   └── WebhookService.php
├── Http/
│   └── Controllers/
│       └── Admin/
│           └── WebhookServiceController.php
```

---

## 8. Roadmap de développement

---

### P0 — Socle du plugin
**Objectif : faire reconnaître le plugin par Azuriom**

- Créer la structure de base du plugin (`plugin.json`, `routes/`, `src/`, `resources/`)
- Déclarer le `WebhookManagerServiceProvider` et l'enregistrer
- Créer la migration pour la table `webhook_services` ✅ déjà développé
- Créer la migration pour la table `webhooks` (avec `service_id` FK à la place de `url`)
- Créer la migration pour la table `webhook_logs`
- Créer les modèles `Webhook`, `WebhookService` ✅ et `WebhookLog`
- Vérifier que le plugin s'installe et se désinstalle proprement depuis le panel Azuriom

---

### P1 — Interface admin CRUD
**Objectif : permettre à l'admin de créer et gérer ses webhooks**

- ✅ `WebhookServiceController` déjà développé (CRUD des connecteurs)
- Créer le `WebhookController` avec les méthodes : `index`, `create`, `store`, `edit`, `update`, `destroy`
- Déclarer les routes admin dans `routes/web.php`
- Créer les vues Blade :
    - `index.blade.php` — liste des webhooks (nom, service associé, event, statut, actions)
    - `create.blade.php` / `edit.blade.php` — formulaire complet
        - Champ **Nom** (libre)
        - Sélecteur **Service** (liste des connecteurs créés) avec aperçu du bot name/avatar
        - Sélecteur **Événement déclencheur**
        - Zone **Payload JSON** (textarea avec coloration syntaxique)
        - Toggle **Actif / Inactif**
- Ajouter la validation Laravel (`required`, `exists:webhook_services,id`, `json`)
- Ajouter le lien dans le menu admin d'Azuriom

---

### P2 — Système de variables dynamiques
**Objectif : permettre des payloads personnalisés avec variables injectées**

- Créer le `VariableResolver` (service class) :
    - Prend en entrée : le template JSON + le contexte de l'event
    - Remplace toutes les occurrences `{variable}` par leurs valeurs réelles
    - Retourne le JSON final prêt à l'envoi
- Définir les variables disponibles par event (cf. section 5)
- Dans le formulaire admin, afficher dynamiquement la liste des variables disponibles selon l'event sélectionné (JS vanilla)
- Valider que le JSON reste valide après interpolation

---

### P3 — Listeners d'événements
**Objectif : déclencher les webhooks automatiquement**

- Créer le `WebhookDispatcher` (service class) :
    - Récupère tous les webhooks actifs pour un event donné
    - Appelle le `VariableResolver` pour résoudre les variables
    - Envoie la requête HTTP POST via `Http::post()`
    - Persiste le résultat dans `webhook_logs`
- Créer les Listeners pour chaque event Azuriom :
    - `UserRegisteredListener` → `user.registered`
    - `OrderPaidListener` → `order.paid`
    - `AdminLoginListener` → `admin.login`
    - `UserVotedListener` → `user.voted`
    - `TicketCreatedListener` → `ticket.created`
- Enregistrer les Listeners dans le `WebhookManagerServiceProvider`

---

### P4 — Logs d'envoi
**Objectif : tracer les envois et aider au debug**

- Après chaque envoi dans le `WebhookDispatcher`, persister dans `webhook_logs` :
    - Le payload réellement envoyé
    - Le code HTTP de réponse
    - Le corps de la réponse
    - La date d'envoi
- Créer la vue `logs.blade.php` dans l'admin :
    - Liste des derniers envois avec statut HTTP (vert si 2xx, rouge sinon)
    - Payload envoyé visible en expandable
    - Filtre par webhook ou par event
- Ajouter une colonne **"Dernier statut"** sur la liste des webhooks

---

### P5 — Test manuel & robustesse
**Objectif : permettre de tester sans attendre un vrai event**

- Ajouter un bouton **"Tester"** sur chaque webhook dans la liste admin :
    - Envoie un payload d'exemple avec des données fictives
    - Affiche le résultat HTTP en retour (toast ou modal)
- Gérer les erreurs dans le `WebhookDispatcher` :
    - Try/catch sur l'appel HTTP
    - Timeout configurable (défaut 5s)
    - Logger l'échec sans faire planter l'event Azuriom parent
- Ajouter un timeout configurable par webhook depuis le formulaire

---

### P6 — Headers HTTP custom
**Objectif : permettre des appels vers des APIs nécessitant une authentification**

- Ajouter la colonne `headers` (JSON nullable) dans la migration `webhooks`
- Dans le formulaire admin, ajouter un éditeur de headers dynamique :
    - Lignes clé/valeur avec bouton "Ajouter un header"
    - Bouton "Supprimer" par ligne
- Injecter les headers dans l'appel HTTP (l'URL étant récupérée depuis le Service lié) :
  ```php
  Http::withHeaders($resolvedHeaders)->post($webhook->service->url, $payload);
  ```
- Dans les logs, afficher les headers envoyés en masquant les valeurs sensibles (ex: `Authorization: Bearer ***`)

---

### P7 — Signature HMAC
**Objectif : sécuriser les webhooks sortants**

- Ajouter la colonne `secret` (string nullable) dans la migration `webhooks`
- Dans le formulaire admin :
    - Champ **Secret** optionnel
    - Bouton **"Générer"** pour créer un secret aléatoire (`Str::random(32)`)
- Dans le `WebhookDispatcher`, si un secret est défini :
  ```php
  $signature = hash_hmac('sha256', $payloadJson, $webhook->secret);
  Http::withHeaders([
      'X-Webhook-Signature' => $signature
  ])->post($webhook->url, $payload);
  ```
- Documenter le format de vérification dans le README pour les développeurs destinataires

---

### P8 — Event custom / API publique
**Objectif : rendre le plugin extensible par d'autres plugins Azuriom**

- Créer la façade `WebhookManager` avec les méthodes publiques :

  **Déclarer un event custom :**
  ```php
  WebhookManager::registerEvent('my_plugin.custom_event', [
      'label'     => 'Mon event custom',
      'variables' => ['custom.var1', 'custom.var2'],
  ]);
  ```

  **Déclencher un webhook depuis un autre plugin :**
  ```php
  WebhookManager::dispatch('my_plugin.custom_event', [
      'custom.var1' => 'valeur1',
      'custom.var2' => 'valeur2',
  ]);
  ```

- Stocker les events enregistrés en mémoire dans le `ServiceProvider` (tableau statique)
- Mettre à jour le sélecteur d'events dans le formulaire admin pour inclure les events custom déclarés
- Mettre à jour le `VariableResolver` pour résoudre les variables custom
- Documenter l'API dans le README avec un exemple complet d'intégration depuis un plugin tiers

---

### P9 — Polish & publication
**Objectif : préparer le plugin pour le market Azuriom**

- Traduire toutes les chaînes UI (`lang/fr.json`, `lang/en.json`)
- Ajouter les permissions admin (qui peut gérer les webhooks)
- Vérifier l'installation propre, la désinstallation (suppression des tables) et la mise à jour
- Rédiger le `README.md` complet :
    - Description du plugin
    - Liste des events et variables
    - Documentation de l'API publique (P8)
    - Format de vérification HMAC (P7)
- Préparer les assets pour la page du market (screenshots, description, icône)

---

## 9. Récapitulatif des priorités

| Phase | Fonctionnalité | Priorité |
|---|---|---|
| P0 | Socle du plugin | 🔴 Critique |
| P1 | Interface admin CRUD | 🔴 Critique |
| P2 | Variables dynamiques | 🔴 Critique |
| P3 | Listeners d'événements | 🔴 Critique |
| P4 | Logs d'envoi | 🟠 Important |
| P5 | Test manuel & robustesse | 🟠 Important |
| P6 | Headers HTTP custom | 🟡 Souhaitable |
| P7 | Signature HMAC | 🟡 Souhaitable |
| P8 | Event custom / API | 🟡 Souhaitable |
| P9 | Polish & publication | 🔴 Critique |
