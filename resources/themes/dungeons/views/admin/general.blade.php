<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Hero generé automatiquement</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('components.forms.switch', ['name' => 'Ordre image par rapport au texte aléatoire', 'id' => $id.'[hero][random]'])
        @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[hero][title]'])
        @includeIf('components.forms.text', ['name' => 'Paragraphe', 'id' => $id.'[hero][paragraph]'])
        @includeIf('components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[hero][image]'])
    </div>
</fieldset>


