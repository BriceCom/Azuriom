<section>
    @component('theme-editor.components.accordion', ['title' => $te('global.background_particles', 'Particules d’arrière-plan'), 'open' => true])
        <label class="te-field te-field-inline">
            <span class="te-field-label">{{ $te('global.enable_particles', 'Activer les particules') }}</span>
            <input type="checkbox" class="te-input" data-key="global.particles_enabled">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('global.particles_count', 'Nombre de particules (10-500)') }}</span>
            <input type="number" class="te-input" data-key="global.particles_count" min="10" max="500">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('global.particles_density', 'Densité des particules (1-100)') }}</span>
            <input type="number" class="te-input" data-key="global.particles_density" min="1" max="100">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('global.custom_image', 'Image personnalisée (Médiathèque Azuriom)') }}</span>
            <select class="te-input" data-key="global.particles_image" data-te-image-select>
                <option value="">{{ $te('global.particles_default', 'Particules rondes par défaut') }}</option>
                @if(theme_config('global.particles_image') && !in_array(theme_config('global.particles_image'), $editorImageFiles, true))
                    <option value="{{ theme_config('global.particles_image') }}">{{ theme_config('global.particles_image') }} (valeur actuelle)</option>
                @endif
                @foreach($editorImages as $image)
                    <option value="{{ $image['file'] }}">{{ $image['name'] }} ({{ $image['file'] }})</option>
                @endforeach
            </select>
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('global.particles_speed', 'Vitesse des particules (1-10)') }}</span>
            <input type="number" class="te-input" data-key="global.particles_speed" min="1" max="10">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('global.particles_size', 'Taille des particules (1-20)') }}</span>
            <input type="number" class="te-input" data-key="global.particles_size" min="1" max="20">
        </label>
    @endcomponent

    @component('theme-editor.components.accordion', ['title' => $te('global.discord', 'Discord'), 'open' => true])
        <label class="te-field">
            <span class="te-field-label">{{ $te('global.discord_link', 'Lien Discord') }}</span>
            <input type="url" class="te-input" data-key="global.discord_link" placeholder="https://discord.gg/xxxx">
        </label>

        <label class="te-field">
            <span class="te-field-label">{{ $te('global.discord_id', 'ID serveur Discord') }}</span>
            <input type="text" class="te-input" data-key="global.discord_id" placeholder="123456789012345678">
        </label>
    @endcomponent

    @component('theme-editor.components.accordion', ['title' => $te('global.server', 'Serveur'), 'open' => true])
        <label class="te-field te-field-inline">
            <span class="te-field-label">{{ $te('global.server_launcher', 'Serveur avec launcher') }}</span>
            <input type="checkbox" class="te-input" data-key="global.server_launcher">
        </label>

        <div class="te-launcher-only">
            <label class="te-field">
                <span class="te-field-label">{{ $te('global.launcher_download_link', 'Lien de téléchargement launcher') }}</span>
                <input type="url" class="te-input" data-key="global.server_launcher_url">
            </label>

            <label class="te-field">
                <span class="te-field-label">{{ $te('global.launcher_button_text', 'Texte du bouton launcher') }}</span>
                <input type="text" class="te-input" data-key="global.server_launcher_button_text">
            </label>
        </div>

        <label class="te-field">
            <span class="te-field-label">{{ $te('global.server_address', 'Adresse IP / domaine du serveur') }}</span>
            <input type="text" class="te-input" data-key="global.server_address" placeholder="play.monserveur.fr">
        </label>
    @endcomponent
</section>
