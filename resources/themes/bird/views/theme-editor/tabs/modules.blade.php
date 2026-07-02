<section>
    @component('theme-editor.components.accordion', ['title' => $te('modules.announce_bar.title', 'Barre d’annonce'), 'open' => true, 'class' => 'te-module te-module-advanced'])
        <div class="te-advanced-hint" data-te-advanced-hint>
            <p class="te-advanced-hint-title mb-1">{{ $te('modules.announce_bar.advanced_hint_title', 'Comment activer le mode avancé') }}</p>
            <p class="te-advanced-hint-text mb-2">{{ $te('modules.announce_bar.advanced_hint_text', 'Vous pouvez configurer ce module, mais il ne sera appliqué qu’en mode avancé.') }}</p>
            <button type="button" class="te-btn te-btn-warning" data-te-open-advanced>
                {{ $te('modules.announce_bar.open_advanced', 'Ouvrir l’onglet Mode avancé') }}
            </button>
        </div>

        <label class="te-field te-field-inline">
            <span class="te-field-label">{{ $te('modules.announce_bar.enable', 'Activer') }}</span>
            <input type="checkbox" class="te-input" data-key="modules.announce_bar.enabled">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('modules.announce_bar.text', 'Texte') }}</span>
            <textarea class="te-input" rows="3" data-key="modules.announce_bar.text"></textarea>
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('modules.announce_bar.background_color', 'Couleur d’arrière-plan') }}</span>
            <input type="color" class="te-input te-input-color" data-key="modules.announce_bar.background_color" value="{{ theme_config('modules.announce_bar.background_color', '#1a1a2e') }}">
        </label>
    @endcomponent

    @component('theme-editor.components.accordion', ['title' => $te('modules.scroll_progress.title', 'Barre de progression (scroll)'), 'open' => true, 'class' => 'te-module te-module-advanced'])
        <div class="te-advanced-hint" data-te-advanced-hint>
            <p class="te-advanced-hint-title mb-1">{{ $te('modules.scroll_progress.advanced_hint_title', 'Comment activer le mode avancé') }}</p>
            <p class="te-advanced-hint-text mb-2">{{ $te('modules.scroll_progress.advanced_hint_text', 'Vous pouvez configurer ce module, mais il ne sera appliqué qu’en mode avancé.') }}</p>
            <button type="button" class="te-btn te-btn-warning" data-te-open-advanced>
                {{ $te('modules.scroll_progress.open_advanced', 'Ouvrir l’onglet Mode avancé') }}
            </button>
        </div>

        <label class="te-field te-field-inline">
            <span class="te-field-label">{{ $te('modules.scroll_progress.enable', 'Activer') }}</span>
            <input type="checkbox" class="te-input" data-key="modules.scroll_progress.enabled">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('modules.scroll_progress.height', 'Hauteur (2-20)') }}</span>
            <input type="number" class="te-input" data-key="modules.scroll_progress.height" min="2" max="20">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('modules.scroll_progress.background_color', 'Couleur de fond') }}</span>
            <input type="color" class="te-input te-input-color" data-key="modules.scroll_progress.background_color" value="{{ theme_config('modules.scroll_progress.background_color', '#1a1a2e') }}">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('modules.scroll_progress.color', 'Couleur de progression') }}</span>
            <input type="color" class="te-input te-input-color" data-key="modules.scroll_progress.color" value="{{ theme_config('modules.scroll_progress.color', '#6c63ff') }}">
        </label>
    @endcomponent
</section>
