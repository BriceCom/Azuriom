<section>
    <h3 class="te-section-title">Variables</h3>
    <p class="te-help mb-2">
        Utilisez les variables dans les champs texte avec la syntaxe <code>{nom_variable}</code>.
    </p>

    <div class="te-field">
        <span class="te-field-label">Variables système (non supprimables)</span>
        <div id="teSystemVariablesList" class="te-list-items"></div>
    </div>

    <div class="te-field">
        <span class="te-field-label">Variables personnalisées</span>
        <div id="teCustomVariablesList" class="te-list-items"></div>
        <button type="button" id="teAddCustomVariable" class="te-btn te-btn-success te-list-add">Nouveau +</button>
    </div>

    <template id="teSystemVariableTemplate">
        <article class="te-list-item">
            <div class="te-list-item-head">
                <strong class="te-list-item-title" data-te-system-variable-title></strong>
                <span class="te-btn te-btn-ghost">Système</span>
            </div>
            <div class="te-list-item-body">
                <label class="te-field">
                    <span class="te-field-label">Variable</span>
                    <input type="text" class="te-input" data-te-system-variable-token readonly>
                </label>
                <label class="te-field">
                    <span class="te-field-label">Valeur courante</span>
                    <input type="text" class="te-input" data-te-system-variable-value readonly>
                </label>
            </div>
        </article>
    </template>

    <template id="teCustomVariableTemplate">
        <article class="te-list-item" data-te-custom-variable-item>
            <div class="te-list-item-head">
                <strong class="te-list-item-title">Variable personnalisée</strong>
                <button type="button" class="te-btn te-btn-danger" data-te-custom-variable-delete>Supprimer</button>
            </div>
            <div class="te-list-item-body">
                <label class="te-field">
                    <span class="te-field-label">Nom</span>
                    <input type="text" class="te-input" data-te-custom-variable-key placeholder="toto">
                </label>
                <label class="te-field">
                    <span class="te-field-label">Valeur</span>
                    <input type="text" class="te-input" data-te-custom-variable-value placeholder="tata">
                </label>
            </div>
        </article>
    </template>
</section>
