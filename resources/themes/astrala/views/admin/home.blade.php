<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Contenu central</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[image]'])
        @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[title]'])
        @includeIf('components.forms.text', ['name' => 'Sous-titre', 'id' => $id.'[subtitle]'])
    </div>
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">IP</legend>
        <div class="d-flex flex-column gap-2">
            @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[ip][text]'])
        </div>
    </fieldset>
</fieldset>
