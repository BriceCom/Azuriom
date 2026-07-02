<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Bouton "Boutique"</legend>
    <div class="d-flex flex-column gap-2">
        <div class="d-flex flex-column gap-2">
            <div>
                @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[shop][title]'])
                @includeIf('components.forms.url', ['name' => 'Url', 'id' => $id.'[shop][url]'])
            </div>
        </div>
    </div>
</fieldset>

