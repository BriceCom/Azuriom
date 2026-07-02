# Nova Implementation Map

Use this map to replicate Nova architecture, not Nova design.

## 1) Bootstrap-first CSS pipeline

- `resources/themes/nova/resources/sass/override-bootstrap.scss`
Role: Bootstrap import order + theme color map merge + component overrides.

- `resources/themes/nova/resources/sass/_override-boostrap/_variables.scss`
Role: light-theme Bootstrap variables/tokens (colors, radius, typography, component defaults).

- `resources/themes/nova/resources/sass/_override-boostrap/_variables-dark.scss`
Role: dark-theme variable overrides.

- `resources/themes/nova/resources/sass/_override-boostrap/_btn.scss`
- `resources/themes/nova/resources/sass/_override-boostrap/_alert.scss`
- `resources/themes/nova/resources/sass/_override-boostrap/_badge.scss`
- `resources/themes/nova/resources/sass/_override-boostrap/_table.scss`
- `resources/themes/nova/resources/sass/_override-boostrap/_ui.scss`
Role: component-level Bootstrap override layers.

- `resources/themes/nova/resources/webpack.mix.js`
Role: compile `sass/override-bootstrap.scss` and `sass/styles.scss` into `assets/css`.

## 2) Layout and view contracts

- `resources/themes/nova/views/layouts/base.blade.php`
Role: global HTML shell, CSS/JS loading, navbar/footer includes, theme mode, global scripts.

- `resources/themes/nova/views/layouts/app.blade.php`
Role: wrapper for non-home pages; keep `@include('elements.session-alerts')`.

- `resources/themes/nova/views/home.blade.php`
Role: homepage composition.

- `resources/themes/nova/views/components/**`
Role: reusable sections.

- `resources/themes/nova/views/elements/**`
Role: global navbar/header/footer and shared widgets.

## 3) Keep Azuriom features intact

Inside navbar/layout, preserve:

- Auth conditions: `@auth`, `@guest`
- User dropdown actions: profile, plugin links, admin access, logout
- Plugin nav extensions: `plugins()->getUserNavItems()`
- Optional global UI blocks: notifications, theme selector

Inside non-home layout, preserve:

- `@include('elements.session-alerts')`

## 4) Theme configuration architecture

- `resources/themes/nova/config/config.blade.php`
Role: admin form UI and tab composition.

- `resources/themes/nova/config/rules.php`
Role: backend validation rules.

- `resources/themes/nova/config.json`
Role: default values consumed by `theme_config()`.

Nova admin form building blocks:

- `resources/themes/nova/views/admin/components/forms/*.blade.php`
- `resources/themes/nova/views/admin/forms/plugins/**`

Pattern to preserve:

1. Define key in `config.json`.
2. Validate key in `config/rules.php`.
3. Expose key in `config/config.blade.php` form.
4. Consume key with `theme_config('...')` in frontend/admin views.

## 5) Plugin view override mechanism

- Source plugin views: `plugins/<plugin-id>/resources/views/...`
- Theme override views: `resources/themes/<theme>/views/plugins/<plugin-id>/...`

Examples from Nova:

- `views/plugins/vote/index.blade.php`
- `views/plugins/shop/...`

Prefer CSS and layout compatibility first; override plugin templates only when structural changes are required.

## 6) Translation structure

- `resources/themes/nova/lang/en/theme.php`
- `resources/themes/nova/lang/en/admin.php`
- `resources/themes/nova/lang/fr/theme.php`
- `resources/themes/nova/lang/fr/admin.php`

Keep identical key trees across locales and always call strings with `trans('theme::...')`.
