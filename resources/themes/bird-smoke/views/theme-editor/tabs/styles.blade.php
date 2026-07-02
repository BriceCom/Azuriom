@php
    $lightColorLabels = [
        'primary' => 'Primaire',
        'secondary' => 'Secondaire',
        'tertiary' => 'Tertiaire',
        'quaternary' => 'Quaternaire',
        'background' => 'Fond du site',
        'dark_tone_1' => 'Ton sombre 1',
        'dark_tone_2' => 'Ton sombre 2',
        'light_tone_1' => 'Ton clair 1',
        'light_tone_2' => 'Ton clair 2',
        'text' => 'Texte',
        'text_background' => 'Fond du texte',
        'alert_success' => 'Alerte succès',
        'alert_info' => 'Alerte info',
        'alert_warning' => 'Alerte avertissement',
        'alert_error' => 'Alerte erreur',
    ];
@endphp

<div class="te-segmented" role="tablist" aria-label="Style ou couleurs">
    <button type="button" class="te-segment te-segment-active" data-te-segment-target="style">Style</button>
    <button type="button" class="te-segment" data-te-segment-target="colors">Couleurs</button>
</div>

<section class="te-segment-panel" data-te-segment="style">
    @component('theme-editor.components.accordion', ['title' => 'THÈME', 'open' => true])
        <label class="te-field te-field-inline">
            <span class="te-field-label">Désactiver le thème sombre/clair</span>
            <input type="checkbox" class="te-input" data-key="styles.theme_dark_disabled">
        </label>

        <label class="te-field">
            <span class="te-field-label">Priorité du thème</span>
            <select class="te-input" data-key="styles.theme_priority">
                <option value="dark">Sombre</option>
                <option value="light">Clair</option>
            </select>
        </label>
    @endcomponent

    @component('theme-editor.components.accordion', ['title' => 'ARRIÈRE-PLAN', 'open' => true])
        <label class="te-field">
            <span class="te-field-label">Image d’arrière-plan — thème clair</span>
            <select class="te-input" data-key="styles.bg_light" data-te-image-select>
                <option value="">Image Azuriom par défaut</option>
                @if(theme_config('styles.bg_light') && !in_array(theme_config('styles.bg_light'), $editorImageFiles, true))
                    <option value="{{ theme_config('styles.bg_light') }}">{{ theme_config('styles.bg_light') }} (valeur actuelle)</option>
                @endif
                @foreach($editorImages as $image)
                    <option value="{{ $image['file'] }}">{{ $image['name'] }} ({{ $image['file'] }})</option>
                @endforeach
            </select>
        </label>

        <label class="te-field">
            <span class="te-field-label">Image d’arrière-plan — thème sombre</span>
            <select class="te-input" data-key="styles.bg_dark" data-te-image-select>
                <option value="">Image Azuriom par défaut</option>
                @if(theme_config('styles.bg_dark') && !in_array(theme_config('styles.bg_dark'), $editorImageFiles, true))
                    <option value="{{ theme_config('styles.bg_dark') }}">{{ theme_config('styles.bg_dark') }} (valeur actuelle)</option>
                @endif
                @foreach($editorImages as $image)
                    <option value="{{ $image['file'] }}">{{ $image['name'] }} ({{ $image['file'] }})</option>
                @endforeach
            </select>
        </label>
    @endcomponent

    @component('theme-editor.components.accordion', ['title' => 'POLICE', 'open' => true, 'class' => 'te-module te-module-advanced'])
        <div class="te-advanced-hint" data-te-advanced-hint>
            <p class="te-advanced-hint-title mb-1">Comment activer le mode avancé</p>
            <p class="te-advanced-hint-text mb-2">
                Vous pouvez remplir ces champs maintenant, mais ils ne seront appliqués qu’en mode avancé.
            </p>
            <button type="button" class="te-btn te-btn-warning" data-te-open-advanced>
                Ouvrir l’onglet Mode avancé
            </button>
        </div>

        <label class="te-field te-field-inline">
            <span class="te-field-label">Activer la police personnalisée</span>
            <input type="checkbox" class="te-input" data-key="styles.font_custom_enabled">
        </label>

        <label class="te-field">
            <span class="te-field-label">Police d’écriture des textes — URL</span>
            <input type="url" class="te-input" data-key="styles.font_body_url" placeholder="https://fonts.bunny.net/css?family=inter">
        </label>

        <label class="te-field">
            <span class="te-field-label">Police d’écriture des textes — Nom</span>
            <input type="text" class="te-input" data-key="styles.font_body_name" placeholder="Inter">
        </label>

        <label class="te-field">
            <span class="te-field-label">Police d’écriture des titres — URL</span>
            <input type="url" class="te-input" data-key="styles.font_heading_url" placeholder="https://fonts.bunny.net/css?family=sora">
        </label>

        <label class="te-field">
            <span class="te-field-label">Police d’écriture des titres — Nom</span>
            <input type="text" class="te-input" data-key="styles.font_heading_name" placeholder="Sora">
        </label>
    @endcomponent
</section>

<section class="te-segment-panel" data-te-segment="colors" hidden>
    <h3 class="te-section-title">Presets couleur</h3>
    <p class="te-help mb-2">Applique rapidement un thème clair/sombre prédéfini.</p>
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
            <span class="te-color-matrix-label">Couleur</span>
            <span class="te-color-matrix-mode">Clair</span>
            <span class="te-color-matrix-mode">Sombre</span>
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
