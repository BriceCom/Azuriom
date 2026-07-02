@php
    $themeTarget = isset($theme) && is_string($theme) && trim($theme) !== ''
        ? $theme
        : (request()->route('theme') ?? themes()->currentTheme());

    if (!is_string($themeTarget) || trim($themeTarget) === '') {
        $themeTarget = '__missing_theme__';
    }

    $colorKeys = [
        'primary',
        'secondary',
        'tertiary',
        'quaternary',
        'background',
        'dark_tone_1',
        'dark_tone_2',
        'light_tone_1',
        'light_tone_2',
        'text',
        'text_background',
        'alert_success',
        'alert_info',
        'alert_warning',
        'alert_error',
    ];
@endphp

<form id="themeEditorConfigForm" class="d-none" action="{{ route('admin.themes.config', $themeTarget) }}" method="POST">
    @csrf

    <input type="hidden" name="styles[theme_dark_disabled]" data-config-key="styles.theme_dark_disabled" value="{{ theme_config('styles.theme_dark_disabled', false) ? '1' : '0' }}">
    <input type="hidden" name="styles[theme_priority]" data-config-key="styles.theme_priority" value="{{ theme_config('styles.theme_priority', 'dark') }}">
    <input type="hidden" name="styles[bg_light]" data-config-key="styles.bg_light" value="{{ theme_config('styles.bg_light') }}">
    <input type="hidden" name="styles[bg_dark]" data-config-key="styles.bg_dark" value="{{ theme_config('styles.bg_dark') }}">
    <input type="hidden" name="styles[font_custom_enabled]" data-config-key="styles.font_custom_enabled" value="{{ theme_config('styles.font_custom_enabled', false) ? '1' : '0' }}">
    <input type="hidden" name="styles[font_body_url]" data-config-key="styles.font_body_url" value="{{ theme_config('styles.font_body_url', '') }}">
    <input type="hidden" name="styles[font_body_name]" data-config-key="styles.font_body_name" value="{{ theme_config('styles.font_body_name', '') }}">
    <input type="hidden" name="styles[font_heading_url]" data-config-key="styles.font_heading_url" value="{{ theme_config('styles.font_heading_url', '') }}">
    <input type="hidden" name="styles[font_heading_name]" data-config-key="styles.font_heading_name" value="{{ theme_config('styles.font_heading_name', '') }}">

    @foreach (['light', 'dark'] as $mode)
        @foreach ($colorKeys as $colorKey)
            <input
                type="hidden"
                name="styles[colors][{{ $mode }}][{{ $colorKey }}]"
                data-config-key="styles.colors.{{ $mode }}.{{ $colorKey }}"
                value="{{ theme_config('styles.colors.'.$mode.'.'.$colorKey) }}"
            >
        @endforeach
    @endforeach

    <input type="hidden" name="global[particles_enabled]" data-config-key="global.particles_enabled" value="{{ theme_config('global.particles_enabled', false) ? '1' : '0' }}">
    <input type="hidden" name="global[particles_count]" data-config-key="global.particles_count" value="{{ theme_config('global.particles_count', 80) }}">
    <input type="hidden" name="global[particles_density]" data-config-key="global.particles_density" value="{{ theme_config('global.particles_density', 50) }}">
    <input type="hidden" name="global[particles_image]" data-config-key="global.particles_image" value="{{ theme_config('global.particles_image') }}">
    <input type="hidden" name="global[particles_speed]" data-config-key="global.particles_speed" value="{{ theme_config('global.particles_speed', 3) }}">
    <input type="hidden" name="global[particles_size]" data-config-key="global.particles_size" value="{{ theme_config('global.particles_size', 3) }}">
    <input type="hidden" name="global[discord_link]" data-config-key="global.discord_link" value="{{ theme_config('global.discord_link', '') }}">
    <input type="hidden" name="global[discord_id]" data-config-key="global.discord_id" value="{{ theme_config('global.discord_id', '') }}">
    <input type="hidden" name="global[server_launcher]" data-config-key="global.server_launcher" value="{{ theme_config('global.server_launcher', false) ? '1' : '0' }}">
    <input type="hidden" name="global[server_launcher_url]" data-config-key="global.server_launcher_url" value="{{ theme_config('global.server_launcher_url', '') }}">
    <input type="hidden" name="global[server_launcher_button_text]" data-config-key="global.server_launcher_button_text" value="{{ theme_config('global.server_launcher_button_text', '') }}">
    <input type="hidden" name="global[server_address]" data-config-key="global.server_address" value="{{ theme_config('global.server_address', '') }}">

    <input type="hidden" name="advanced[advanced_mode]" data-config-key="advanced.advanced_mode" value="{{ theme_config('advanced.advanced_mode', false) ? '1' : '0' }}">
    <input type="hidden" name="advanced[serveurliste_link]" data-config-key="advanced.serveurliste_link" value="{{ theme_config('advanced.serveurliste_link', '') }}">
    <input type="hidden" name="advanced[serveurliste_token]" data-config-key="advanced.serveurliste_token" value="{{ theme_config('advanced.serveurliste_token', '') }}">

    <input type="hidden" name="modules[announce_bar][enabled]" data-config-key="modules.announce_bar.enabled" value="{{ theme_config('modules.announce_bar.enabled', false) ? '1' : '0' }}">
    <input type="hidden" name="modules[announce_bar][text]" data-config-key="modules.announce_bar.text" value="{{ theme_config('modules.announce_bar.text', '') }}">
    <input type="hidden" name="modules[announce_bar][background_color]" data-config-key="modules.announce_bar.background_color" value="{{ theme_config('modules.announce_bar.background_color', '#1a1a2e') }}">
    <input type="hidden" name="modules[scroll_progress][enabled]" data-config-key="modules.scroll_progress.enabled" value="{{ theme_config('modules.scroll_progress.enabled', false) ? '1' : '0' }}">
    <input type="hidden" name="modules[scroll_progress][height]" data-config-key="modules.scroll_progress.height" value="{{ theme_config('modules.scroll_progress.height', 8) }}">
    <input type="hidden" name="modules[scroll_progress][background_color]" data-config-key="modules.scroll_progress.background_color" value="{{ theme_config('modules.scroll_progress.background_color', '#1a1a2e') }}">
    <input type="hidden" name="modules[scroll_progress][color]" data-config-key="modules.scroll_progress.color" value="{{ theme_config('modules.scroll_progress.color', '#6c63ff') }}">

    <div id="themeEditorPageBlocksFields"></div>
    <div id="themeEditorVariablesFields"></div>
</form>
