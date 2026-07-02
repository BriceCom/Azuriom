<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Rejoins-nos</legend>
    @includeIf('components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[come][image]'])
    @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[come][title]'])
    @includeIf('components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[come][paragraph]'])
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">A propos</legend>
    @includeIf('components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[about][image]'])
    @includeIf('components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[about][paragraph]'])
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Site Web</legend>
    @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[web][title]'])
    <div class="d-flex flex-column flex-md-row gap-2">
        @for($i=1;$i<=5;$i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS {{$i}}</legend>
                <div class="d-flex flex-column gap-2">
                    <div>
                        @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[web][links][link-'.$i.'][text]'])
                        @includeIf('components.forms.url', ['name' => 'url', 'id' => $id.'[web][links][link-'.$i.'][url]'])
                    </div>
                    @includeIf('components.forms.switch', ['name' => 'Ouvrir dans un nouvel onglet', 'id' => $id.'[web][links][link-'.$i.'][blank]'])
                </div>
            </fieldset>
        @endfor
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Ressources</legend>
    @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[ressources][title]'])
    <div class="d-flex flex-column flex-md-row gap-2">
        @for($i=1;$i<=5;$i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS {{$i}}</legend>
                <div class="d-flex flex-column gap-2">
                    <div>
                        @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[ressources][links][link-'.$i.'][text]'])
                        @includeIf('components.forms.url', ['name' => 'url', 'id' => $id.'[ressources][links][link-'.$i.'][url]'])
                    </div>
                    @includeIf('components.forms.switch', ['name' => 'Ouvrir dans un nouvel onglet', 'id' => $id.'[ressources][links][link-'.$i.'][blank]'])
                </div>
            </fieldset>
        @endfor
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS IMPORTANT</legend>
    @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[important][title]'])
    <small>Exemple: CGU</small>
    <div class="d-flex flex-column flex-md-row gap-2">
        @for($i=1;$i<=4;$i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS {{$i}}</legend>
                <div class="d-flex flex-column gap-2">
                    <div>
                        @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[important][links][link-'.$i.'][text]'])
                        @includeIf('components.forms.url', ['name' => 'url', 'id' => $id.'[important][links][link-'.$i.'][url]'])
                    </div>
                    @includeIf('components.forms.switch', ['name' => 'Ouvrir dans un nouvel onglet', 'id' => $id.'[important][links][link-'.$i.'][blank]'])
                </div>
            </fieldset>
        @endfor
    </div>
</fieldset>
