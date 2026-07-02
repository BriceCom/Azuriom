# Project Guidelines (Azuriom)

This file defines contribution standards for this repository (`azuriom_neuf`).

## 1. What Is Azuriom?

Azuriom is an open-source game CMS built on Laravel. It provides:
- A core CMS (pages, posts, users, auth, admin)
- A plugin system (`plugins/*`) for feature extensions
- A theme system (`resources/themes/*`) for frontend customization

In this project:
- PHP version target: `^8.2`
- Laravel version target: `^12.0`
- Frontend stack includes Bootstrap `^5.1.0` and Laravel Mix

## 2. Plugin Development Standard

### 2.1 Create a plugin

Use the built-in generator:

```bash
php artisan plugin:create "My Plugin" my-plugin --author="Your Name" --description="My plugin" --url="https://example.com"
```

This creates a plugin in `plugins/my-plugin` with:
- `plugin.json`
- `composer.json`
- `src/Providers/*`
- `routes/{web,admin,api}.php`
- `resources/{views,lang}`
- `database/migrations`
- `assets/{css,js}`

### 2.2 Required plugin structure

Minimum expected files:
- `plugins/<id>/plugin.json`
- `plugins/<id>/composer.json`
- `plugins/<id>/src/Providers/<Plugin>ServiceProvider.php`
- `plugins/<id>/src/Providers/RouteServiceProvider.php`
- `plugins/<id>/routes/web.php`

Commonly expected:
- `resources/views/*`
- `resources/lang/<locale>/*`
- `database/migrations/*`
- `src/helpers.php` (if custom helper functions are needed)

### 2.3 `plugin.json` rules

- `id` must be unique, lowercase slug style
- `version` must follow semantic versioning
- `providers` must point to valid service providers
- `azuriom_api` must match the targeted API version used in this project

### 2.4 Plugin coding conventions

- Namespace pattern: `Azuriom\Plugin\<StudlyName>\...`
- Keep controllers thin; move business logic to services/actions
- Use Form Request classes for validation
- Load plugin resources through `BasePluginServiceProvider`:
  - `loadViews()`
  - `loadTranslations()`
  - `loadMigrations()`
- Register permissions explicitly with `Permission::registerPermissions([...])`
- Use translation keys, not hardcoded user-facing strings
- Add migrations for schema changes; do not edit old migrations in released plugins

### 2.5 Plugin routes

Default route patterns from the generated provider:
- Public: `/plugin-id/*`
- Admin: `/admin/plugin-id/*`
- API: `/api/plugin-id/*`

Use route namespaced names (`plugin-id.*`) and middleware appropriately (`web`, `admin-access`, `api`).

## 3. Theme Development Standard

### 3.1 Create a theme

Use the built-in generator:

```bash
php artisan theme:create "My Theme" my-theme --author="Your Name" --description="My theme" --url="https://example.com"
```

This creates `resources/themes/my-theme` with:
- `theme.json`
- `config.json`
- `assets/`
- `views/`

### 3.2 Required theme structure

Minimum expected files:
- `resources/themes/<id>/theme.json`
- `resources/themes/<id>/views/home.blade.php`

Commonly expected:
- `config.json`
- `config/config.blade.php`
- `config/rules.php`
- `assets/*`
- `views/maintenance.blade.php`

### 3.3 `theme.json` rules

- `id` must be unique and folder-aligned
- `version` must follow semantic versioning
- `azuriom_api` must be compatible with the running Azuriom version
- Keep metadata (`name`, `description`, `authors`, `url`) complete and accurate

### 3.4 Theme implementation conventions

- Extend base layout when possible (`@extends('layouts.base')`)
- Use Blade components/partials for reusable blocks
- Use helper functions (`theme_asset()`, `theme_config()`, `site_name()`, etc.)
- Keep presentational logic in Blade, business logic outside Blade
- Keep assets under the theme folder only

## 4. Helpers Standard (What Helpers Are)

Helpers are globally available PHP functions used across core, plugins, and themes.

Core helper files in this repo:
- `app/base_helpers.php`
- `app/color_helpers.php`
- `app/helpers.php`

Examples of important helpers:
- Extension/path: `plugins()`, `themes()`, `plugin_path()`, `themes_path()`, `theme_path()`
- Assets/config: `plugin_asset()`, `theme_asset()`, `theme_config()`
- Settings/site: `setting()`, `site_name()`, `site_logo()`, `favicon()`
- Formatting/misc: `format_date()`, `format_money()`, `trans_bool()`

Helper rules:
- Always wrap with `if (! function_exists('...'))`
- Keep helpers pure and lightweight
- Do not place heavy DB queries in frequently called helpers
- Use clear names and return types where practical
- Prefer services for complex logic

## 5. Laravel 12 Standards

### 5.1 Architecture

- Follow PSR-4 autoloading and framework conventions
- Keep domain logic outside controllers
- Use service providers for bootstrapping integrations
- Use Eloquent relationships/scopes instead of duplicated query logic
- Use queued jobs for long-running tasks

### 5.2 Validation, authorization, security

- Use Form Request classes for all non-trivial input validation
- Use policies/gates/permissions for access control
- Escape output by default in Blade (`{{ }}`)
- Do not use raw SQL when query builder/Eloquent is sufficient
- Never commit secrets (`.env`, API keys, tokens)

### 5.3 Database and migrations

- One logical change per migration
- Use foreign keys/indexes intentionally
- Write reversible migrations where possible
- Prefer additive migrations for backward compatibility

### 5.4 Code style and quality

- Use `laravel/pint` for formatting
- Keep methods focused and short
- Favor explicit naming over abbreviations
- Add tests for changed behavior (feature/unit depending on scope)

Recommended local checks:

```bash
./vendor/bin/pint
php artisan test
```

## 6. Bootstrap 5 Standards

This repository uses Bootstrap 5 (package target `^5.1.0`).

### 6.1 Markup and layout

- Use Bootstrap grid and utility classes before writing custom CSS
- Keep semantic HTML (`header`, `main`, `section`, `nav`, etc.)
- Prefer Bootstrap components (cards, modals, alerts, dropdowns) for consistency

### 6.2 Design consistency

- Reuse spacing scale (`mt-*`, `mb-*`, `p-*`, `gap-*`)
- Keep color usage tied to theme variables/tokens
- Avoid inline styles except for small, justified cases

### 6.3 Accessibility

- Provide labels for form controls
- Maintain color contrast and visible focus states
- Add `aria-*` attributes where required by component behavior
- Ensure keyboard navigation works for interactive components

### 6.4 JavaScript usage

- Prefer Bootstrap native JS behavior before custom scripts
- Keep custom JS modular and minimal
- Do not block rendering with unnecessary scripts

## 7. Pull Request Checklist

Before submitting code:
- Plugin/theme metadata updated (`plugin.json` / `theme.json`)
- Translations added/updated for user-facing text
- Migrations included for schema changes
- `pint` passes
- Tests pass locally
- No secrets or generated artifacts accidentally committed

