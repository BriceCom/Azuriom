---
name: html-to-azuriom-theme
description: Convert static HTML/CSS/JS websites into Azuriom themes using Nova technical conventions and a Bootstrap 5-first approach. Use when asked to migrate an existing site template to Azuriom, split HTML into Blade layouts/components, map content to theme config and translations, implement plugin view overrides, and preserve native Azuriom features like user dropdown and alerts.
---

# HTML To Azuriom Theme

Convert structure and behavior, not raw files. Keep target output aligned with Azuriom theme contracts.

Use `resources/themes/nova` as architecture reference only. Do not clone Nova visual style.

## Workflow

1. Audit source HTML template:
- List pages, sections, navigation states, forms, modals, and JS behaviors.
- Identify hardcoded text, colors, and assets to parameterize.
- Detect existing CSS framework; plan migration to Bootstrap 5 classes/utilities.

2. Create Azuriom theme skeleton:
- Create `resources/themes/<theme-id>/` with standard folders (`assets`, `resources`, `views`, `config`, `lang`).
- Set `theme.json.id` to match folder name.
- Copy Nova/Flex technical scaffold only when it accelerates delivery.

3. Rebuild CSS as Bootstrap-first:
- Move brand palette/typography/radius to `resources/sass/_override-boostrap/_variables.scss`.
- Keep Bootstrap import and override order in `resources/sass/override-bootstrap.scss`.
- Convert custom button/card/form styles to Bootstrap variants before writing custom CSS.
- Keep remaining site-specific styles in `resources/sass/styles.scss`.

4. Split HTML into Blade layouts and components:
- Move global head/scripts/footer shell into `views/layouts/base.blade.php`.
- Keep non-home wrapper in `views/layouts/app.blade.php`.
- Build homepage in `views/home.blade.php`.
- Extract sections into `views/components/**` and `views/elements/**`.

5. Restore Azuriom-native behavior:
- Implement guest/auth navbar states with `@guest` and `@auth`.
- Keep user dropdown links: profile, plugin links, admin link (when allowed), logout form.
- Keep `@include('elements.session-alerts')` in page layout.
- Keep plugin user navigation (`plugins()->getUserNavItems()`), notifications, and theme selector when enabled.

6. Convert static content to theme configuration:
- Put defaults in `config.json`.
- Validate with `config/rules.php`.
- Build admin form UI in `config/config.blade.php`, reusing Nova-style form partials if present.
- Replace hardcoded values in views by `theme_config('...')`.

7. Convert text to translation files:
- Store frontend strings in `lang/<locale>/theme.php`.
- Store admin/config strings in `lang/<locale>/admin.php`.
- Replace literals with `trans('theme::...')`.

8. Handle plugin screens via overrides:
- Map plugin views to `views/plugins/<plugin-id>/...`.
- Keep plugin data contracts unchanged.
- Override only when required by layout/UX goals.

9. Compile, test, and fix regressions:
- Build assets from `resources/themes/<theme>/resources`.
- Test home, one CMS page, auth flows, and each installed plugin route.
- Fix regressions with Bootstrap/token adjustments before custom per-plugin CSS.

## References

- Read `references/html-to-blade-mapping.md` for direct source-to-target mapping.
- Read `references/preservation-checklist.md` for non-negotiable Azuriom compatibility checks.
