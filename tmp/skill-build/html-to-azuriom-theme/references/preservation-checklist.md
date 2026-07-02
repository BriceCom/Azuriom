# Preservation Checklist

Use this checklist to confirm the conversion keeps Azuriom behavior intact.

## Must-keep functionality

1. User dropdown works in both states:
- Guest: login/register
- Authenticated: profile, plugin links, admin (if permitted), logout

2. Session feedback works:
- `@include('elements.session-alerts')` present in non-home layout
- success/error messages render visibly with Bootstrap alert styles

3. Navbar menu supports:
- normal links
- dropdown links
- active route highlight
- mobile collapse behavior

4. Plugin compatibility preserved:
- No plugin source file edited
- Optional plugin overrides live in `views/plugins/<plugin-id>/...`
- Plugin pages render with no missing variables/includes

## Bootstrap-first verification

1. Primary controls use Bootstrap classes, not template-only classes.

2. `override-bootstrap.css` loads before theme-specific `styles.css`.

3. Colors, typography, border radius and spacing are configurable through Bootstrap variables/theme tokens.

4. Core Bootstrap components remain usable after overrides:
- dropdown
- modal
- tooltip
- alert
- table
- form validation

## Config and translation verification

1. Every configurable item has:
- default (`config.json`)
- validation (`config/rules.php`)
- admin field (`config/config.blade.php`)
- frontend consumption (`theme_config()`)

2. Every visible string is translatable with `trans('theme::...')`.

3. At least two locales compile with matching key trees.

## Asset and route verification

1. `npm run development` and `npm run prod` complete in theme resources folder.

2. Compiled outputs exist in `assets/css` and `assets/js`.

3. Smoke-test routes:
- `/` (home)
- one CMS page (`/page/...`)
- auth routes (`/login`, `/register` if enabled)
- each installed plugin route (`/shop`, `/vote`, etc.)

4. No console JS errors on base layout and plugin pages.
