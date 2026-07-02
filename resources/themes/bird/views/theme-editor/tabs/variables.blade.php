<section>
    <h3 class="te-section-title">{{ $te('variables.title', 'Variables') }}</h3>
    <p class="te-help mb-2">
        {!! $te('variables.help', 'Utilisez les variables dans les champs texte avec la syntaxe <code>{nom_variable}</code>.') !!}
    </p>

    <div class="te-field">
        <span class="te-field-label">{{ $te('variables.system_label', 'Variables système (non supprimables)') }}</span>
        <div id="teSystemVariablesList" class="te-list-items"></div>
    </div>

    <div class="te-field">
        <span class="te-field-label">{{ $te('variables.custom_label', 'Variables personnalisées') }}</span>
        <div id="teCustomVariablesList" class="te-list-items"></div>
        <button type="button" id="teAddCustomVariable" class="te-btn te-btn-success te-list-add">{{ $te('variables.add_custom', 'Nouveau +') }}</button>
    </div>

    <template id="teSystemVariableTemplate">
        <article class="te-list-item">
            <div class="te-list-item-head">
                <strong class="te-list-item-title" data-te-system-variable-title></strong>
                <span class="te-btn te-btn-ghost">{{ $te('variables.system', 'Système') }}</span>
            </div>
            <div class="te-list-item-body">
                <label class="te-field">
                    <span class="te-field-label">{{ $te('variables.variable', 'Variable') }}</span>
                    <input type="text" class="te-input" data-te-system-variable-token readonly>
                </label>
                <label class="te-field">
                    <span class="te-field-label">{{ $te('variables.current_value', 'Valeur courante') }}</span>
                    <input type="text" class="te-input" data-te-system-variable-value readonly>
                </label>
            </div>
        </article>
    </template>

    <template id="teCustomVariableTemplate">
        <article class="te-list-item" data-te-custom-variable-item>
            <div class="te-list-item-head">
                <strong class="te-list-item-title">{{ $te('variables.custom_item_title', 'Variable personnalisée') }}</strong>
                <button type="button" class="te-btn te-btn-danger" data-te-custom-variable-delete>{{ $te('common.delete', 'Supprimer') }}</button>
            </div>
            <div class="te-list-item-body">
                <label class="te-field">
                    <span class="te-field-label">{{ $te('variables.name', 'Nom') }}</span>
                    <input type="text" class="te-input" data-te-custom-variable-key placeholder="toto">
                </label>
                <label class="te-field">
                    <span class="te-field-label">{{ $te('variables.value', 'Valeur') }}</span>
                    <input type="text" class="te-input" data-te-custom-variable-value placeholder="tata">
                </label>
            </div>
        </article>
    </template>
</section>
