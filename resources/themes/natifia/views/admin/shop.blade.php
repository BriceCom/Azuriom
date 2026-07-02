<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <div class="d-flex flex-column gap-2">
            @includeIf('components.forms.url', ['name' => 'Lien CGU/CGV', 'id' => $id.'[link][cgu]'])
            @includeIf('components.forms.url', ['name' => 'Lien Mentions légales', 'id' => $id.'[link][mentions]'])
            @includeIf('components.forms.url', ['name' => 'Lien Support', 'id' => $id.'[link][support]'])
            @includeIf('components.forms.text', ['name' => 'Email Support', 'id' => $id.'[email]'])
        </div>
</fieldset>
