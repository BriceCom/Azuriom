<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Barre d'annonce</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('components.forms.switch', ['name' => 'Afficher', 'id' => $id.'[announce-bar][show]'])
        @includeIf('components.forms.textaera', ['name' => 'Texte', 'id' => $id.'[announce-bar][text]'])
    </div>
</fieldset>
