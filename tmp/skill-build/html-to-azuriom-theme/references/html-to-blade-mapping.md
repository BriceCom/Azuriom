# HTML to Blade Mapping

Use this mapping to convert static HTML into an Azuriom theme cleanly.

## 1) File mapping

- Source `index.html` main shell
Target `views/layouts/base.blade.php` + `views/home.blade.php`

- Source reusable chunks (`header`, `footer`, `hero`, `cards`, `cta`)
Target `views/elements/**` and `views/components/**`

- Source secondary pages (`about.html`, `rules.html`, etc.)
Target `views/pages/show.blade.php` with CMS data, or dedicated Blade views when required

- Source custom plugin-like pages (`shop.html`, `vote.html`)
Target `views/plugins/<plugin-id>/*.blade.php` overrides (if plugin is enabled)

## 2) Dynamic helpers replacement

Replace hardcoded site data with Azuriom helpers:

- Site title/logo/favicon -> `site_name()`, `site_logo()`, `favicon()`
- Theme assets -> `theme_asset('...')`
- Media ids/paths -> `image_url(...)`
- Theme options -> `theme_config('...')`
- Translations -> `trans('theme::...')`

## 3) Navbar/auth conversion

Convert static nav states into Blade logic:

- Logged out: login/register links (`@guest`)
- Logged in: avatar/profile, plugin items, admin entry, logout (`@auth`)
- Keep plugin nav extension point: `plugins()->getUserNavItems()`

Do not hardcode auth names/avatars.

## 4) Bootstrap migration strategy

1. Map source utility classes to Bootstrap 5 utilities where possible.
2. Map source buttons/forms/cards/alerts/dropdowns to Bootstrap markup.
3. Move remaining design tokens to Bootstrap variable overrides.
4. Keep only truly custom layout classes in `styles.scss`.

Avoid attaching design to plugin-specific DOM unless unavoidable.

## 5) Configuration extraction strategy

Move these from static HTML into theme config:

- Hero titles/subtitles/buttons
- Background images and media
- CTA labels/URLs
- Social links
- Accent colors / typography toggles
- Optional block visibility flags

Pattern:

1. Add default in `config.json`
2. Validate in `config/rules.php`
3. Add admin field in `config/config.blade.php`
4. Read value with `theme_config()` in view

## 6) Translation extraction strategy

1. Replace visible text literals by translation keys.
2. Put frontend keys in `lang/<locale>/theme.php`.
3. Put admin labels/help text in `lang/<locale>/admin.php`.
4. Keep key trees aligned between locales.

## 7) JavaScript migration notes

- Keep progressive enhancement approach.
- Avoid jQuery-only assumptions.
- Keep bootstrap bundle loading for dropdown/collapse/modal behaviors.
- Keep scripts scoped to feature-specific files in `resources/js/`.
