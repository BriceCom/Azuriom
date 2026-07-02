<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Hero</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[hero][title]'])
        @includeIf('components.forms.text', ['name' => 'Sous-titre', 'id' => $id.'[hero][subtitle]'])
    </div>
</fieldset>
