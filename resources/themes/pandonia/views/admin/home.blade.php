<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Id discord</legend>
        <div class="d-flex flex-column gap-2">
            @includeIf('components.forms.text', ['name' => 'ID du discord', 'id' => $id.'[discord][id]'])
            @includeIf('components.forms.url', ['name' => 'Lien invitation', 'id' => $id.'[discord][url]'])
        </div>
    </fieldset>
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">IP</legend>
        <div class="d-flex flex-column gap-2">
            @includeIf('components.forms.text', ['name' => 'Adresse ip du serveur', 'id' => $id.'[ip][text]'])
        </div>
    </fieldset>
</fieldset>
