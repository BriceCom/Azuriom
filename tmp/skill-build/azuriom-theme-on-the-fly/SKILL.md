---
name: azuriom-theme-on-the-fly
description: Create Azuriom themes quickly from a brief while keeping Nova technical conventions (not Nova visual design). Use when asked to build a new theme fast, set up Bootstrap 5 overrides first (colors, typography, spacing), wire layouts/components/pages, implement theme config forms, add translations, preserve core Azuriom UX (user dropdown, alerts, notifications), and keep plugin compatibility.
---

# Azuriom Theme On The Fly

Use `resources/themes/nova` as a technical reference only. Do not reproduce Nova branding or composition.

For static HTML template migration, use `$html-to-azuriom-theme`.

## Workflow

1. Enforce Bootstrap-first architecture:
- Build UI with Bootstrap 5 primitives and utilities (`btn-primary`, `alert-*`, `dropdown`, `table`, `modal`, spacing utilities).
- Avoid bespoke component rewrites for standard controls.
- Put visual identity in Bootstrap variables and theme tokens, not in ad-hoc per-page CSS.

2. Scaffold the theme structure:
- Create `resources/themes/<theme-id>/` with `theme.json`, `assets/`, `resources/`, `views/`, `config/`, `lang/`, `config.json`.
- Keep `<theme-id>` folder name and `theme.json.id` identical.
- Copy Nova structure/pipeline as base if speed is required, then replace content.

3. Configure CSS before page work:
- Create or keep `resources/sass/override-bootstrap.scss` and `_override-boostrap/*`.
- Set color and typography foundations in `_override-boostrap/_variables.scss` (+ dark variant if needed).
- Compile `override-bootstrap.scss` and load `assets/css/override-bootstrap.css` in layout before `styles.css`.
- Keep `resources/webpack.mix.js` compiling both `styles.scss` and `override-bootstrap.scss`.

4. Implement layout contracts:
- Keep global shell in `views/layouts/base.blade.php`.
- Keep plugin/default page shell in `views/layouts/app.blade.php`.
- Keep homepage composition in `views/home.blade.php`.
- Extract repeatable blocks to `views/components/**` and `views/elements/**`.

5. Preserve Azuriom core UX features:
- Keep auth-aware navbar behavior with `@auth` / `@guest`.
- Keep user dropdown actions (profile, plugin nav items, admin, logout).
- Keep `@include('elements.session-alerts')` in app/page layout.
- Keep notifications/theme selector when supported (`elements.notifications`, `elements.theme-selector`).
- Keep plugin user nav integration (`plugins()->getUserNavItems()`).

6. Build theme config with stable architecture:
- Store defaults in `config.json`.
- Store validation in `config/rules.php`.
- Build admin form in `config/config.blade.php` and submit to the route used by the project baseline (`admin.themes.update` or project-specific equivalent).
- Reuse config form partials/components from `views/admin/components/forms/*.blade.php` and tab partials from `views/admin/forms/**` when using Nova-style admin UX.
- Keep every `theme_config('...')` key synchronized across defaults, validation, and form fields.

7. Keep plugin compatibility through view overrides:
- Avoid editing plugin source files.
- Override plugin views in `views/plugins/<plugin-id>/...` only when needed.
- Prefer CSS/layout compatibility before rewriting plugin templates.

8. Add translations from day one:
- Add strings in `lang/<locale>/theme.php` and `lang/<locale>/admin.php`.
- Use `trans('theme::...')` in views; avoid hardcoded strings.
- Keep locale key structures aligned across languages.

9. Build and validate:
- Run asset build in `resources/themes/<theme>/resources` (`npm run development`, then `npm run prod`).
- Validate compiled outputs in `assets/css/` and `assets/js/`.
- Smoke-test home, one standard page, login/register states, and installed plugin pages.

## References

- Read `references/nova-implementation-map.md` for exact Nova path responsibilities.
- Read `references/bootstrap-first-checklist.md` for execution and QA checklist.
