# Bootstrap-First Checklist

Apply this checklist before considering a theme complete.

## Build setup

1. Confirm files exist:
- `resources/sass/override-bootstrap.scss`
- `resources/sass/_override-boostrap/_variables.scss`
- `resources/webpack.mix.js`
- `assets/css/override-bootstrap.css`

2. Confirm import order in `override-bootstrap.scss`:
- Bootstrap functions
- Custom variables (light/dark)
- Bootstrap maps/mixins/utilities
- Bootstrap core
- Local component overrides (`_btn`, `_alert`, `_badge`, `_table`, `_ui`)

3. Confirm compiled CSS is loaded from layout:
- `theme_asset('css/override-bootstrap.css')` before `theme_asset('css/styles.css')`

4. Run build:
```bash
cd resources/themes/<theme>/resources
npm run development
npm run prod
```

## Compatibility rules

1. Use Bootstrap classes for standard controls:
- Buttons: `btn`, `btn-primary`, variants
- Alerts: `alert`, contextual classes
- Forms: `form-control`, `form-select`, validation classes
- Tables: `table`, `table-*`
- Dropdowns: `dropdown`, `dropdown-menu`, `dropdown-item`

2. Do not reinvent base component markup unless required.

3. Keep plugin pages visually integrated via tokenized colors and Bootstrap variables.

4. Keep dark/light behavior consistent where supported.

## Theme configuration rules

1. For each new option, check:
- Key exists in `config.json`
- Key validation exists in `config/rules.php`
- Field exists in `config/config.blade.php`
- Key is consumed via `theme_config()` in views

2. Reuse existing admin field partials instead of custom inline field markup whenever possible.

## Translation rules

1. No hardcoded UI text in Blade.

2. Keep at least `lang/en` and one secondary locale aligned key-by-key.

3. Verify `trans('theme::...')` keys resolve in both frontend and admin.

## Must-pass smoke tests

1. Guest navbar:
- login/register links visible

2. Auth navbar:
- avatar/name, profile, plugin nav entries, admin entry (if authorized), logout

3. Session alert rendering:
- success/error flash visible in non-home pages

4. Plugin pages:
- Shop/Vote/other enabled plugins still usable with no layout breakage

5. Bootstrap controls:
- primary buttons, dropdowns, alerts, tables, forms remain coherent with the new theme tokens
