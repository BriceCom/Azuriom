# Project Guidelines

## Azuriom Overview
Azuriom is an open-source web solution for game servers, built with Laravel. It supports various games like Minecraft, Garry's Mod, Rust, and more.
The project structure follows a typical Laravel application but with modular support for plugins and themes.

### Project Structure
- `app/`: Core logic (Controllers, Models, Providers, etc.)
- `plugins/`: Directory for all Azuriom plugins. Each plugin is a self-contained module.
- `resources/themes/`: Directory for all Azuriom themes.
- `resources/views/`: Global views.
- `routes/`: Web and API routes.
- `storage/`: Logs, cache, and uploaded files.

---

## How to Create a Plugin
Azuriom provides a built-in command to scaffold a new plugin.

### 1. Generate the Plugin
Run the following Artisan command:
```bash
php artisan plugin:create "Plugin Name" plugin-id
```
- **name**: The display name of the plugin.
- **id**: A unique identifier for the plugin (slug).

### 2. Plugin Structure
A new plugin will be created in `plugins/plugin-id/` with the following structure:
- `plugin.json`: Metadata about the plugin (id, version, authors, providers, etc.).
- `src/`: PHP source code.
  - `Providers/`: Service providers (e.g., `PluginServiceProvider`).
  - `Controllers/`: Plugin controllers.
  - `Models/`: Plugin models.
- `resources/`: Plugin resources.
  - `views/`: Blade templates.
  - `lang/`: Translation files.
- `routes/`: Plugin-specific routes (`web.php`, `admin.php`, `api.php`).

### 3. Registering the Plugin
Metadata and service providers are defined in `plugin.json`. Azuriom automatically detects plugins in the `plugins/` directory.

---

## How to Create a Theme
Similarly, Azuriom provides a command to scaffold a new theme.

### 1. Generate the Theme
Run the following Artisan command:
```bash
php artisan theme:create "Theme Name" theme-id
```

### 2. Theme Structure
A new theme will be created in `resources/themes/theme-id/` with:
- `theme.json`: Metadata about the theme.
- `views/`: Blade templates that override or extend the core views.
  - `layouts/`: Base layout files.
- `assets/`: CSS, JS, and images.

### 3. Customizing the Theme
Themes in Azuriom use Blade templates. You can customize the look by modifying files in the `views/` directory. Common files to look at:
- `views/layouts/base.blade.php`: The main layout wrapper.
- `views/home.blade.php`: The homepage template.

---

## Development & Testing
- Use `php artisan serve` for local development.
- Azuriom follows PSR-12 coding style.
- Use `./vendor/bin/pint` to fix code style issues.
- When working on existing plugins (like `tasks`), ensure translations are updated in all supported languages (`en`, `fr`, `es-ES`, `ru`, etc.).
