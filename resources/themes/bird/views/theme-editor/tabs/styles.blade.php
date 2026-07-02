@php
    $lightColorLabels = [
        'primary' => $te('styles.color_labels.primary', 'Primaire'),
        'secondary' => $te('styles.color_labels.secondary', 'Secondaire'),
        'tertiary' => $te('styles.color_labels.tertiary', 'Tertiaire'),
        'quaternary' => $te('styles.color_labels.quaternary', 'Quaternaire'),
        'background' => $te('styles.color_labels.background', 'Fond du site'),
        'dark_tone_1' => $te('styles.color_labels.dark_tone_1', 'Ton sombre 1'),
        'dark_tone_2' => $te('styles.color_labels.dark_tone_2', 'Ton sombre 2'),
        'light_tone_1' => $te('styles.color_labels.light_tone_1', 'Ton clair 1'),
        'light_tone_2' => $te('styles.color_labels.light_tone_2', 'Ton clair 2'),
        'text' => $te('styles.color_labels.text', 'Texte'),
        'text_background' => $te('styles.color_labels.text_background', 'Fond du texte'),
        'alert_success' => $te('styles.color_labels.alert_success', 'Alerte succès'),
        'alert_info' => $te('styles.color_labels.alert_info', 'Alerte info'),
        'alert_warning' => $te('styles.color_labels.alert_warning', 'Alerte avertissement'),
        'alert_error' => $te('styles.color_labels.alert_error', 'Alerte erreur'),
    ];
@endphp

<div class="te-segmented" role="tablist" aria-label="{{ $te('styles.title', 'Style') }}">
    <button type="button" class="te-segment te-segment-active" data-te-segment-target="style">{{ $te('styles.tab_style', 'Style') }}</button>
    <button type="button" class="te-segment" data-te-segment-target="colors">{{ $te('styles.tab_colors', 'Couleurs') }}</button>
</div>

<section class="te-segment-panel" data-te-segment="style">
    @component('theme-editor.components.accordion', ['title' => $te('styles.section_theme', 'THÈME'), 'open' => true])
        <label class="te-field te-field-inline">
            <span class="te-field-label">{{ $te('styles.disable_dark_light', 'Désactiver le thème sombre/clair') }}</span>
            <input type="checkbox" class="te-input" data-key="styles.theme_dark_disabled">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('styles.priority', 'Priorité du thème') }}</span>
            <select class="te-input" data-key="styles.theme_priority">
                <option value="dark">{{ $te('styles.dark_theme', 'Sombre') }}</option>
                <option value="light">{{ $te('styles.light_theme', 'Clair') }}</option>
            </select>
        </label>
    @endcomponent

    @component('theme-editor.components.accordion', ['title' => $te('styles.section_background', 'ARRIÈRE-PLAN'), 'open' => true])
        <label class="te-field">
            <span class="te-field-label">{{ $te('styles.background_light', 'Image d’arrière-plan — thème clair') }}</span>
            <select class="te-input" data-key="styles.bg_light" data-te-image-select>
                <option value="">{{ $te('styles.default_image', 'Image Azuriom par défaut') }}</option>
                @if(theme_config('styles.bg_light') && !in_array(theme_config('styles.bg_light'), $editorImageFiles, true))
                    <option value="{{ theme_config('styles.bg_light') }}">{{ theme_config('styles.bg_light') }} ({{ $te('styles.current_value', 'valeur actuelle') }})</option>
                @endif
                @foreach($editorImages as $image)
                    <option value="{{ $image['file'] }}">{{ $image['name'] }} ({{ $image['file'] }})</option>
                @endforeach
            </select>
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('styles.background_dark', 'Image d’arrière-plan — thème sombre') }}</span>
            <select class="te-input" data-key="styles.bg_dark" data-te-image-select>
                <option value="">{{ $te('styles.default_image', 'Image Azuriom par défaut') }}</option>
                @if(theme_config('styles.bg_dark') && !in_array(theme_config('styles.bg_dark'), $editorImageFiles, true))
                    <option value="{{ theme_config('styles.bg_dark') }}">{{ theme_config('styles.bg_dark') }} ({{ $te('styles.current_value', 'valeur actuelle') }})</option>
                @endif
                @foreach($editorImages as $image)
                    <option value="{{ $image['file'] }}">{{ $image['name'] }} ({{ $image['file'] }})</option>
                @endforeach
            </select>
        </label>
    @endcomponent

    @component('theme-editor.components.accordion', ['title' => $te('styles.section_fonts', 'POLICE'), 'open' => true, 'class' => 'te-module te-module-advanced'])
        <div class="te-advanced-hint" data-te-advanced-hint>
            <p class="te-advanced-hint-title mb-1">{{ $te('styles.advanced_hint_title', 'Comment activer le mode avancé') }}</p>
            <p class="te-advanced-hint-text mb-2">{{ $te('styles.advanced_hint_text', 'Vous pouvez remplir ces champs maintenant, mais ils ne seront appliqués qu’en mode avancé.') }}</p>
            <button type="button" class="te-btn te-btn-warning" data-te-open-advanced>
                {{ $te('styles.open_advanced', 'Ouvrir l’onglet Mode avancé') }}
            </button>
        </div>

        <label class="te-field te-field-inline">
            <span class="te-field-label">{{ $te('styles.custom_font_enable', 'Activer la police personnalisée') }}</span>
            <input type="checkbox" class="te-input" data-key="styles.font_custom_enabled">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('styles.body_font_url', 'Police d’écriture des textes — URL') }}</span>
            <input type="url" class="te-input" data-key="styles.font_body_url" placeholder="https://fonts.bunny.net/css?family=inter">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('styles.body_font_name', 'Police d’écriture des textes — Nom') }}</span>
            <input type="text" class="te-input" data-key="styles.font_body_name" placeholder="Inter">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('styles.heading_font_url', 'Police d’écriture des titres — URL') }}</span>
            <input type="url" class="te-input" data-key="styles.font_heading_url" placeholder="https://fonts.bunny.net/css?family=sora">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('styles.heading_font_name', 'Police d’écriture des titres — Nom') }}</span>
            <input type="text" class="te-input" data-key="styles.font_heading_name" placeholder="Sora">
        </label>
    @endcomponent
</section>

<section class="te-segment-panel" data-te-segment="colors" hidden>
    <h3 class="te-section-title">{{ $te('styles.colors_title', 'Presets couleur') }}</h3>
    <p class="te-help mb-2">{{ $te('styles.colors_help', 'Applique rapidement un thème clair/sombre prédéfini.') }}</p>
    <div class="te-preset-grid mb-3">
        <button type="button" class="te-btn te-btn-ghost te-preset-btn" data-te-color-preset="bootstrap">Bootstrap</button>
        <button type="button" class="te-btn te-btn-ghost te-preset-btn" data-te-color-preset="azure">Azure</button>
        <button type="button" class="te-btn te-btn-ghost te-preset-btn" data-te-color-preset="emerald">Emerald</button>
        <button type="button" class="te-btn te-btn-ghost te-preset-btn" data-te-color-preset="moonlight">Moonlight</button>
        <button type="button" class="te-btn te-btn-ghost te-preset-btn" data-te-color-preset="rose">Rose</button>
        <button type="button" class="te-btn te-btn-ghost te-preset-btn" data-te-color-preset="amber">Amber</button>
        <button type="button" class="te-btn te-btn-ghost te-preset-btn" data-te-color-preset="slate">Slate</button>
        <button type="button" class="te-btn te-btn-ghost te-preset-btn" data-te-color-preset="purple">Purple</button>
    </div>

    <div class="te-color-matrix">
        <div class="te-color-matrix-head">
            <span class="te-color-matrix-label">{{ $te('styles.matrix.color', 'Couleur') }}</span>
            <span class="te-color-matrix-mode">{{ $te('styles.matrix.light', 'Clair') }}</span>
            <span class="te-color-matrix-mode">{{ $te('styles.matrix.dark', 'Sombre') }}</span>
        </div>
        @foreach($lightColorLabels as $key => $label)
            <div class="te-color-matrix-row">
                <span class="te-color-matrix-label">{{ $label }}</span>
                <input
                    type="color"
                    class="te-input te-input-color"
                    data-key="styles.colors.light.{{ $key }}"
                    value="{{ theme_config('styles.colors.light.'.$key, '#ffffff') }}"
                >
                <input
                    type="color"
                    class="te-input te-input-color"
                    data-key="styles.colors.dark.{{ $key }}"
                    value="{{ theme_config('styles.colors.dark.'.$key, '#ffffff') }}"
                >
            </div>
        @endforeach
    </div>
</section>
