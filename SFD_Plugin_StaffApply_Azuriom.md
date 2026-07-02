# SFD — Plugin `staff-apply` pour Azuriom

**Version cible :** 1.0.0  
**Compatibilité Azuriom API :** ≥ 1.2.0  
**Dépendances :** aucune  
**Licence :** MIT

---

## 1. Contexte & problème résolu

Sur la quasi-totalité des serveurs Minecraft, les candidatures staff sont gérées via :
- Un sujet épinglé sur le forum (désorganisé, visible de tous)
- Un formulaire Google Docs partagé (hors site, pas de suivi)
- Un channel Discord (impossible à archiver proprement)

Conséquences : perte de candidatures, absence de suivi, réponses oubliées, pas d'historique.

Ce plugin centralise le processus **entièrement dans Azuriom** : formulaire configurable côté admin, workflow de traitement (en attente → en révision → accepté / refusé), notifications intégrées, et historique complet.

---

## 2. Périmètre v1.0

### Inclus
- Formulaire de candidature public (champs configurables par l'admin)
- Types de postes configurables (Modérateur, Admin, Builder, etc.)
- Statuts de candidature : `pending` → `reviewing` → `accepted` / `refused`
- Interface admin : liste, filtres, consultation, changement de statut + commentaire interne
- Notification au candidat par email à chaque changement de statut
- Notification Discord webhook (optionnelle) à chaque nouvelle candidature
- Limite : une seule candidature active par joueur (par poste)
- Traductions FR / EN

### Hors périmètre v1.0
- Système de vote entre membres du staff pour délibérer
- Entretien planifié (calendrier intégré)
- Période de candidature avec dates d'ouverture/fermeture par poste
- API publique pour bot Discord

---

## 3. Structure du plugin

```
plugins/
└── staff-apply/
    ├── plugin.json
    ├── assets/
    │   ├── css/
    │   │   └── apply.css
    │   └── js/
    │       └── apply.js            ← validation front + champs dynamiques
    ├── database/
    │   └── migrations/
    │       ├── 2024_01_01_000000_create_staff_apply_positions_table.php
    │       ├── 2024_01_01_000001_create_staff_apply_fields_table.php
    │       └── 2024_01_01_000002_create_staff_apply_applications_table.php
    ├── resources/
    │   ├── lang/
    │   │   ├── en/messages.php
    │   │   └── fr/messages.php
    │   └── views/
    │       ├── index.blade.php          ← liste des postes ouverts
    │       ├── apply.blade.php          ← formulaire de candidature
    │       ├── status.blade.php         ← suivi de sa candidature (joueur)
    │       └── admin/
    │           ├── index.blade.php      ← liste candidatures + filtres
    │           ├── show.blade.php       ← détail d'une candidature
    │           ├── positions/
    │           │   ├── index.blade.php  ← liste des postes
    │           │   ├── create.blade.php
    │           │   └── edit.blade.php
    │           └── fields/
    │               └── edit.blade.php   ← constructeur de formulaire
    ├── routes/
    │   ├── web.php
    │   └── admin.php
    └── src/
        ├── Controllers/
        │   ├── ApplicationController.php
        │   └── Admin/
        │       ├── ApplicationAdminController.php
        │       └── PositionAdminController.php
        ├── Models/
        │   ├── Application.php
        │   ├── Position.php
        │   └── Field.php
        ├── Notifications/
        │   └── ApplicationStatusChanged.php
        └── Providers/
            ├── StaffApplyServiceProvider.php
            └── RouteServiceProvider.php
```

---

## 4. Base de données

### Table `staff_apply_positions` — postes disponibles

| Colonne        | Type             | Contraintes   | Description                          |
|----------------|------------------|---------------|--------------------------------------|
| `id`           | INT UNSIGNED AI  | PK            |                                      |
| `name`         | VARCHAR(100)     | NOT NULL      | Ex. "Modérateur", "Builder"          |
| `slug`         | VARCHAR(110)     | UNIQUE        | URL-friendly, généré depuis `name`   |
| `description`  | TEXT             | NULLABLE      | Texte affiché au candidat            |
| `is_open`      | BOOLEAN          | DEFAULT true  | Ouvert aux candidatures              |
| `max_pending`  | INT UNSIGNED     | NULLABLE      | Limite de candidatures simultanées (null = illimité) |
| `order`        | INT UNSIGNED     | DEFAULT 0     |                                      |
| `created_at`   | TIMESTAMP        |               |                                      |
| `updated_at`   | TIMESTAMP        |               |                                      |

---

### Table `staff_apply_fields` — champs du formulaire par poste

| Colonne        | Type             | Contraintes   | Description                                      |
|----------------|------------------|---------------|--------------------------------------------------|
| `id`           | INT UNSIGNED AI  | PK            |                                                  |
| `position_id`  | INT UNSIGNED     | FK → positions| Champ lié à un poste                             |
| `label`        | VARCHAR(200)     | NOT NULL      | Libellé affiché ("Quel est ton âge ?")           |
| `type`         | ENUM             | NOT NULL      | `text`, `textarea`, `number`, `select`, `checkbox` |
| `options`      | JSON             | NULLABLE      | Pour `select` : `["Option A","Option B"]`        |
| `is_required`  | BOOLEAN          | DEFAULT true  |                                                  |
| `order`        | INT UNSIGNED     | DEFAULT 0     |                                                  |
| `created_at`   | TIMESTAMP        |               |                                                  |
| `updated_at`   | TIMESTAMP        |               |                                                  |

---

### Table `staff_apply_applications` — candidatures soumises

| Colonne          | Type             | Contraintes        | Description                                         |
|------------------|------------------|--------------------|-----------------------------------------------------|
| `id`             | INT UNSIGNED AI  | PK                 |                                                     |
| `position_id`    | INT UNSIGNED     | FK → positions     |                                                     |
| `user_id`        | INT UNSIGNED     | FK → users         |                                                     |
| `answers`        | JSON             | NOT NULL           | `{"field_id": "réponse", ...}`                      |
| `status`         | ENUM             | DEFAULT `pending`  | `pending`, `reviewing`, `accepted`, `refused`       |
| `admin_note`     | TEXT             | NULLABLE           | Commentaire interne (non visible du joueur)         |
| `reviewed_by`    | INT UNSIGNED     | NULLABLE, FK users | Admin ayant traité la candidature                   |
| `reviewed_at`    | TIMESTAMP        | NULLABLE           |                                                     |
| `created_at`     | TIMESTAMP        |                    |                                                     |
| `updated_at`     | TIMESTAMP        |                    |                                                     |

**Contrainte métier** : un joueur ne peut avoir qu'une candidature avec `status IN ('pending','reviewing')` par poste. Vérification dans le contrôleur avant `store()`.

---

## 5. Modèles Eloquent

### `Position`
```php
namespace Azuriom\Plugin\StaffApply\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasTablePrefix;

    protected $prefix   = 'staff_apply_';
    protected $fillable = ['name', 'slug', 'description', 'is_open', 'max_pending', 'order'];
    protected $casts    = ['is_open' => 'boolean'];

    public function fields()
    {
        return $this->hasMany(Field::class)->orderBy('order');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    // Vérifie si le poste accepte encore des candidatures
    public function isAcceptingApplications(): bool
    {
        if (! $this->is_open) return false;
        if ($this->max_pending === null) return true;
        return $this->applications()
            ->whereIn('status', ['pending', 'reviewing'])
            ->count() < $this->max_pending;
    }
}
```

### `Field`
```php
class Field extends Model
{
    use HasTablePrefix;

    protected $prefix   = 'staff_apply_';
    protected $fillable = ['position_id', 'label', 'type', 'options', 'is_required', 'order'];
    protected $casts    = ['options' => 'array', 'is_required' => 'boolean'];
}
```

### `Application`
```php
class Application extends Model
{
    use HasTablePrefix;
    use HasUser;  // trait Azuriom natif

    protected $prefix   = 'staff_apply_';
    protected $fillable = ['position_id', 'user_id', 'answers', 'status', 'admin_note', 'reviewed_by', 'reviewed_at'];
    protected $casts    = ['answers' => 'array', 'reviewed_at' => 'datetime'];

    public function position()  { return $this->belongsTo(Position::class); }
    public function reviewer()  { return $this->belongsTo(\Azuriom\Models\User::class, 'reviewed_by'); }

    // Labels des statuts pour l'affichage
    public static array $statusColors = [
        'pending'   => 'warning',
        'reviewing' => 'info',
        'accepted'  => 'success',
        'refused'   => 'danger',
    ];
}
```

---

## 6. Routes

### `routes/web.php`
```php
Route::get ('/',                  [ApplicationController::class, 'index']) ->name('staff-apply.index');
Route::get ('/{position:slug}',   [ApplicationController::class, 'show'])  ->name('staff-apply.show');
Route::post('/{position:slug}',   [ApplicationController::class, 'store']) ->name('staff-apply.store')
     ->middleware('auth');
Route::get ('/my-application/{application}',
                                  [ApplicationController::class, 'status'])->name('staff-apply.status')
     ->middleware('auth');
```

### `routes/admin.php`
```php
// Candidatures
Route::prefix('staff-apply')->name('staff-apply.admin.')->group(function () {

    Route::get   ('/',                        [ApplicationAdminController::class, 'index'])  ->name('applications.index');
    Route::get   ('/{application}',           [ApplicationAdminController::class, 'show'])   ->name('applications.show');
    Route::patch ('/{application}/status',    [ApplicationAdminController::class, 'updateStatus'])->name('applications.status');
    Route::delete('/{application}',           [ApplicationAdminController::class, 'destroy'])->name('applications.destroy');

    // Postes
    Route::get   ('/positions',               [PositionAdminController::class, 'index'])     ->name('positions.index');
    Route::get   ('/positions/create',        [PositionAdminController::class, 'create'])    ->name('positions.create');
    Route::post  ('/positions',               [PositionAdminController::class, 'store'])     ->name('positions.store');
    Route::get   ('/positions/{position}/edit',[PositionAdminController::class, 'edit'])     ->name('positions.edit');
    Route::put   ('/positions/{position}',    [PositionAdminController::class, 'update'])    ->name('positions.update');
    Route::delete('/positions/{position}',    [PositionAdminController::class, 'destroy'])   ->name('positions.destroy');
    Route::post  ('/positions/reorder',       [PositionAdminController::class, 'reorder'])   ->name('positions.reorder');
});
```

Toutes les routes admin protégées par `can:admin` (middleware natif Azuriom).

---

## 7. Contrôleurs

### 7.1 `ApplicationController` (public)

| Méthode | Route                        | Comportement                                                                                   |
|---------|------------------------------|-----------------------------------------------------------------------------------------------|
| `index` | GET `/staff-apply`           | Liste les postes ouverts avec description et nombre de candidatures en attente (si affiché)   |
| `show`  | GET `/staff-apply/{slug}`    | Affiche le formulaire du poste. Si non connecté → redirect login. Si candidature active → message |
| `store` | POST `/staff-apply/{slug}`   | Valide, enregistre la candidature, envoie notif Discord, redirige vers `status`               |
| `status`| GET `/my-application/{id}`  | Affiche le statut de la candidature. Vérifie que `$application->user_id === auth()->id()`     |

**Validation dans `store()`** :
- Construit les règles dynamiquement depuis `$position->fields`
- Pour chaque champ : `required` si `is_required`, type `string`/`numeric`/`in:{options}` selon le type
- Vérifie `isAcceptingApplications()` avant tout
- Vérifie l'absence de candidature active existante pour ce joueur + ce poste

### 7.2 `ApplicationAdminController`

| Méthode         | Description                                                                                  |
|-----------------|----------------------------------------------------------------------------------------------|
| `index`         | Liste paginée (15/page) avec filtres : poste, statut, recherche par pseudo. Tri par date desc |
| `show`          | Détail complet : infos joueur (avatar via `getAvatar()`), réponses formatées, historique de statut, note interne, boutons d'action |
| `updateStatus`  | Change le statut + enregistre `admin_note` optionnelle + `reviewed_by` + `reviewed_at`. Déclenche notification email joueur |
| `destroy`       | Suppression définitive (avec confirmation JS)                                                |

**Validation `updateStatus`** :
```php
[
    'status'     => 'required|in:pending,reviewing,accepted,refused',
    'admin_note' => 'nullable|string|max:2000',
]
```

### 7.3 `PositionAdminController`

| Méthode    | Description                                                                        |
|------------|------------------------------------------------------------------------------------|
| `index`    | Liste des postes avec : nom, statut ouvert/fermé, nb de candidatures, actions      |
| `create`   | Formulaire poste vide + constructeur de champs (voir §9)                           |
| `store`    | Valide poste + crée les champs associés en transaction                             |
| `edit`     | Formulaire pré-rempli poste + champs existants                                     |
| `update`   | Met à jour poste + synchronise les champs (supprime/crée/met à jour) en transaction|
| `destroy`  | Refuse si des candidatures existent (message d'erreur). Sinon supprime             |
| `reorder`  | `[{id, order}]` JSON → met à jour les ordres                                       |

---

## 8. Workflow de statuts

```
[Joueur soumet]
      │
      ▼
  PENDING  ──── Admin ignore ────► (reste en attente)
      │
      │  Admin prend en charge
      ▼
  REVIEWING
      │
      ├─── Admin accepte ──► ACCEPTED → email joueur "Félicitations"
      │
      └─── Admin refuse  ──► REFUSED  → email joueur "Candidature refusée"

Transitions autorisées :
  pending   → reviewing, refused
  reviewing → accepted, refused, pending (retour possible)
  accepted  → (terminal — pas de retour en v1.0)
  refused   → (terminal — pas de retour en v1.0)
```

---

## 9. Constructeur de formulaire (admin)

L'éditeur de champs est une interface HTML/JS inline dans la vue `positions/edit.blade.php`. Pas de librairie externe — JavaScript vanilla avec le design Bootstrap d'Azuriom.

### Fonctionnement

1. La page charge les champs existants en JSON dans une variable JS (`window.fieldsData`).
2. Un bouton "Ajouter un champ" insère un bloc HTML de configuration via `cloneNode`.
3. Chaque bloc expose : Libellé, Type (`select`), Obligatoire (`checkbox`), Ordre (drag).
4. Si type = `select` : un sous-bloc "Options" apparaît (liste de valeurs séparées par retour ligne).
5. À la soumission du formulaire, les champs sont sérialisés en tableau `fields[]` et envoyés avec le reste du form.

### Types de champ disponibles

| Type       | Rendu côté candidat                    | Validation                    |
|------------|----------------------------------------|-------------------------------|
| `text`     | `<input type="text">`                  | `string\|max:500`             |
| `textarea` | `<textarea rows="5">`                  | `string\|max:3000`            |
| `number`   | `<input type="number">`                | `numeric`                     |
| `select`   | `<select>` avec les options définies   | `in:{options}`                |
| `checkbox` | `<input type="checkbox">` (oui/non)    | `boolean`                     |

---

## 10. Notifications

### Email `ApplicationStatusChanged`

Envoyée au joueur à chaque changement de statut via `Illuminate\Notifications\Notification`.

Contenu selon le statut :

| Statut     | Objet email                              | Corps                                                          |
|------------|------------------------------------------|----------------------------------------------------------------|
| `reviewing`| "Ta candidature est en cours d'examen"   | Ton dossier a été pris en charge par l'équipe staff.           |
| `accepted` | "Candidature acceptée 🎉"               | Félicitations ! Tu rejoins l'équipe. Contacte un admin.        |
| `refused`  | "Candidature non retenue"                | Merci de ta candidature. Tu pourras en soumettre une nouvelle. |

Le message de refus n'inclut PAS `admin_note` (note interne uniquement).

### Discord Webhook (optionnel)

Configurable dans les paramètres admin du plugin (champ URL webhook). Envoyée à chaque **nouvelle candidature** via `Http::post()` de Laravel.

Payload (embed Discord) :
```json
{
  "embeds": [{
    "title": "Nouvelle candidature — Modérateur",
    "color": 16776960,
    "fields": [
      { "name": "Joueur", "value": "PseudoJoueur", "inline": true },
      { "name": "Poste",  "value": "Modérateur",   "inline": true }
    ],
    "timestamp": "2024-01-15T14:32:00Z",
    "footer": { "text": "Staff Apply — MonServeur" }
  }]
}
```

L'envoi Discord est fait en **fire-and-forget** (`dispatch` async ou simple try/catch silencieux) pour ne pas bloquer la soumission du joueur en cas d'échec webhook.

---

## 11. Vues publiques

### `index.blade.php` — liste des postes

- Grille Bootstrap de cards, une par poste ouvert
- Chaque card : nom du poste, description (tronquée à 150 car.), bouton "Postuler"
- Badge "Fermé" sur les postes `is_open = false`
- Si aucun poste ouvert : message informatif "Aucun recrutement en cours"

### `apply.blade.php` — formulaire

- Titre + description du poste
- Champs générés dynamiquement depuis `$position->fields` (boucle Blade)
- Validation côté client légère (champs requis) via `apply.js`
- Bouton "Envoyer ma candidature" avec protection CSRF `@csrf`
- Si candidature déjà active : bandeau info + lien vers `status`

### `status.blade.php` — suivi joueur

- Badge coloré Bootstrap du statut actuel (warning/info/success/danger)
- Timeline simplifiée : date de soumission, date de prise en charge, date de décision
- Rappel des réponses soumises (lecture seule)
- Message selon statut (`accepted` → message de félicitations, `refused` → possibilité de repostuler)

---

## 12. Vues admin

### Liste des candidatures (`admin/index.blade.php`)

Tableau Bootstrap avec :
- Colonnes : Avatar + Pseudo | Poste | Date | Statut (badge) | Actions
- Filtre par poste (`<select>`) + filtre par statut (`<select>`) + recherche pseudo (`<input>`)
- Pagination 15 par page
- Lien "Voir" → `admin/show`

### Détail candidature (`admin/show.blade.php`)

Layout deux colonnes :
- **Gauche** : infos joueur (avatar `getAvatar()`, pseudo, email, date inscription), poste demandé, date candidature
- **Droite** : toutes les réponses au formulaire (label + réponse), zone note interne (`<textarea>`), sélecteur de statut + bouton "Mettre à jour"
- Historique des changements de statut (date + admin qui a agi) en bas de page

---

## 13. Service Provider

```php
class StaffApplyServiceProvider extends BasePluginServiceProvider
{
    public function boot(): void
    {
        $this->loadViews();
        $this->loadTranslations();
        $this->loadMigrations();
        $this->registerRouteDescriptions();
        $this->registerAdminNavigation();
    }

    protected function routeDescriptions(): array
    {
        return [
            'staff-apply.index' => trans('staff-apply::messages.nav_title'),
        ];
    }

    protected function adminNavigation(): array
    {
        return [
            'staff-apply' => [
                'name'  => trans('staff-apply::messages.admin_nav'),
                'type'  => 'dropdown',
                'icon'  => 'bi bi-person-badge',
                'route' => 'staff-apply.admin.*',
                'items' => [
                    'staff-apply.admin.applications.index' => [
                        'name' => trans('staff-apply::messages.admin_applications'),
                    ],
                    'staff-apply.admin.positions.index' => [
                        'name' => trans('staff-apply::messages.admin_positions'),
                    ],
                ],
            ],
        ];
    }
}
```

---

## 14. Traductions

### `resources/lang/fr/messages.php` (extrait)
```php
return [
    'nav_title'            => 'Candidatures staff',
    'admin_nav'            => 'Staff Apply',
    'admin_applications'   => 'Candidatures',
    'admin_positions'      => 'Postes',

    'apply'                => 'Postuler',
    'no_positions'         => 'Aucun recrutement en cours.',
    'already_applied'      => 'Tu as déjà une candidature active pour ce poste.',
    'position_closed'      => 'Les candidatures pour ce poste sont fermées.',
    'application_sent'     => 'Ta candidature a bien été envoyée !',

    'status_pending'       => 'En attente',
    'status_reviewing'     => 'En cours d\'examen',
    'status_accepted'      => 'Acceptée',
    'status_refused'       => 'Refusée',

    'admin_note'           => 'Note interne (non visible du candidat)',
    'update_status'        => 'Mettre à jour le statut',
    'deleted'              => 'Candidature supprimée.',

    'position_has_applications' => 'Impossible de supprimer : des candidatures existent pour ce poste.',
];
```

---

## 15. `plugin.json`

```json
{
    "id":           "staff-apply",
    "name":         "Staff Apply",
    "version":      "1.0.0",
    "description":  "Système de candidatures staff avec formulaire configurable et workflow de traitement.",
    "url":          "https://github.com/votre-compte/azuriom-staff-apply",
    "authors":      ["Votre Nom"],
    "azuriom_api":  "1.2.0",
    "providers": [
        "\\Azuriom\\Plugin\\StaffApply\\Providers\\StaffApplyServiceProvider",
        "\\Azuriom\\Plugin\\StaffApply\\Providers\\RouteServiceProvider"
    ]
}
```

---

## 16. Sécurité

| Risque                              | Mitigation                                                                      |
|-------------------------------------|---------------------------------------------------------------------------------|
| Soumission sans être connecté       | Middleware `auth` sur `store` et `status`                                       |
| Spam de candidatures                | Vérification candidature active existante avant `store()`                       |
| Voir la candidature d'un autre      | `status()` vérifie `$application->user_id === auth()->id()`, sinon `abort(403)` |
| XSS dans les réponses               | Blade `{{ }}` échappe automatiquement, stockage JSON brut                       |
| Accès admin non autorisé            | Middleware `can:admin` sur toutes les routes admin                               |
| CSRF                                | `@csrf` dans tous les formulaires                                               |
| Injection SQL                       | Eloquent ORM + bindings préparés                                                |
| Webhook Discord en échec bloquant   | Try/catch silencieux, soumission non bloquée                                    |

---

## 17. Installation (guide utilisateur final)

1. Placer le dossier `staff-apply` dans `plugins/`.
2. Admin panel → **Extensions** → activer **Staff Apply**.
3. Dans le menu **Staff Apply → Postes** → créer un premier poste (ex. "Modérateur").
4. Dans l'éditeur du poste, ajouter les champs du formulaire ("Quel est ton âge ?", "Décris ta motivation", etc.).
5. Activer le poste (`is_open = true`).
6. Optionnel : dans **Staff Apply → Paramètres**, coller l'URL du webhook Discord.
7. Dans **Navbar** → ajouter un lien vers "Candidatures staff".

---

## 18. Roadmap v1.x

| Version | Fonctionnalité                                                              |
|---------|-----------------------------------------------------------------------------|
| v1.1    | Paramètre de dates d'ouverture/fermeture par poste (recrutement saisonnier) |
| v1.2    | Vote interne staff : les membres du staff notent les candidatures (1-5)     |
| v1.3    | Statistiques admin : taux d'acceptation, délai moyen de traitement          |
| v2.0    | API REST publique pour bot Discord (lecture statut, notification)           |

---

## 19. Arbre de décision complet

```
JOUEUR
  │
  ├─ Visite /staff-apply
  │     └─ Voit les postes ouverts
  │           ├─ Clique "Postuler"
  │           │     ├─ Non connecté → redirect login
  │           │     ├─ Candidature active → message + lien suivi
  │           │     ├─ Poste plein (max_pending) → message poste indisponible
  │           │     └─ Remplit formulaire → soumet
  │           │           ├─ Validation échoue → erreurs inline
  │           │           └─ OK → candidature créée, notif Discord, redirect status
  │           └─ Aucun poste → "Aucun recrutement en cours"
  │
  └─ Visite /my-application/{id}
        ├─ Pas le sien → 403
        └─ Le sien → affiche statut + réponses

ADMIN
  │
  ├─ Staff Apply → Candidatures
  │     ├─ Filtre / recherche
  │     └─ Clique "Voir"
  │           ├─ Lit les réponses
  │           ├─ Ajoute note interne
  │           ├─ Change statut → email joueur
  │           └─ Supprime (si nécessaire)
  │
  └─ Staff Apply → Postes
        ├─ Crée un poste + champs
        ├─ Modifie (ajoute/supprime/réordonne champs)
        ├─ Ouvre / ferme le poste
        └─ Supprime (bloqué si candidatures existantes)
```
