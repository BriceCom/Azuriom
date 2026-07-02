<section>
    <h3 class="te-section-title">{{ $te('advanced.title', 'Mode avancé') }}</h3>
    <label class="te-field te-field-inline">
        <span class="te-field-label">{{ $te('advanced.enable', 'Activer le mode avancé') }}</span>
        <input type="checkbox" class="te-input" data-key="advanced.advanced_mode">
    </label>

    <label class="te-field">
        <span class="te-field-label">{{ $te('advanced.serveurliste_link', 'Lien ServeurListe') }}</span>
        <input type="url" class="te-input" data-key="advanced.serveurliste_link">
    </label>

    <label class="te-field">
        <span class="te-field-label">{{ $te('advanced.serveurliste_token', 'Token ServeurListe') }}</span>
        <input type="text" class="te-input" data-key="advanced.serveurliste_token">
    </label>
</section>
