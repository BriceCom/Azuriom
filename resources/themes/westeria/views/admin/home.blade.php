<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">IP</legend>
        <div class="d-flex flex-column gap-2">
            @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[ip][text]'])
        </div>
    </fieldset>
</fieldset>
