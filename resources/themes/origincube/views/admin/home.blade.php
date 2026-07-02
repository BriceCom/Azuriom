<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LOGO</legend>
    <div class="d-flex flex-column flex-md-row gap-2">
        @includeIf('admin.components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[image]'])
        <div class="flex-grow-1">
            @includeIf('admin.components.forms.range', ['name' => 'Hauteur max', 'id' => $id.'[imageHeightMax]', 'value' => 0, 'min' => 1, 'step' => 1, 'max' => 800])
        </div>
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Discord</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('admin.components.forms.text', ['name' => 'ID Discord', 'id' => $id.'[discord][id]', 'placeholder' => '1025845189115400303'])
        @includeIf('admin.components.forms.text', ['name' => 'Titre', 'id' => $id.'[discord][title]', 'placeholder' => 'Notre communauté'])
        @includeIf('admin.components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[discord][paragraph]', 'placeholder' => 'Paragraphe'])
        <div class="d-flex flex-row gap-2">
            <div>
                @includeIf('admin.components.forms.url', ['name' => 'Lien discord', 'id' => $id.'[discordLink][url]'])
                @includeIf('admin.components.forms.switch', ['name' => 'Ouvrir dans un nouvel onglet', 'id' => $id.'[discordLink][blank]'])
            </div>
            <div>
                @includeIf('admin.components.forms.url', ['name' => 'Lien youtube', 'id' => $id.'[youtubeLink][url]'])
                @includeIf('admin.components.forms.switch', ['name' => 'Ouvrir dans un nouvel onglet', 'id' => $id.'[youtubeLink][blank]'])
            </div>
        </div>

    </div>
</fieldset>
