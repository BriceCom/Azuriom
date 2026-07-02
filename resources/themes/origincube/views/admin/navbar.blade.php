<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LOGO</legend>
    <div class="d-flex flex-column flex-md-row gap-2">
        @includeIf('admin.components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[image]'])
        <div class="flex-grow-1">
            @includeIf('admin.components.forms.range', ['name' => 'Hauteur max', 'id' => $id.'[imageHeightMax]', 'value' => 0, 'min' => 1, 'step' => 1, 'max' => 800])
        </div>
    </div>
</fieldset>


