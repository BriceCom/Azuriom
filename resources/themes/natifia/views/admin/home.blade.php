<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Vidéo</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('components.forms.url', ['name' => 'Lien vidéo youtube', 'id' => $id.'[youtube][url]'])
    </div>
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Partenaire</legend>
        <div class="d-flex flex-column gap-2">
            @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[partner][title]'])
            @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[partner][text]'])
            @includeIf('components.forms.text', ['name' => 'Lien Text', 'id' => $id.'[partner][urlText]'])
            @includeIf('components.forms.url', ['name' => 'Lien', 'id' => $id.'[partner][url]'])
            @includeIf('components.forms.text', ['name' => 'Pseudo', 'id' => $id.'[partner][pseudo]'])
            @includeIf('components.forms.text', ['name' => 'Description sous pseudo', 'id' => $id.'[partner][pseudoDesc]'])
        </div>
    </fieldset>
</fieldset>
