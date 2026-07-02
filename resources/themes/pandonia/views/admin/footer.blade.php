<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">A propos</legend>
    @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[about_us][title]'])
    @includeIf('components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[about_us][paragraph]'])
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Liens utiles</legend>
    @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[web][title]'])
    <div class="d-flex flex-column flex-md-row flex-wrap gx-2">
        @for($i=1;$i<=5;$i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-25">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS {{$i}}</legend>
                <div class="d-flex flex-column gap-2">
                    <div>
                        @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[web][links][link-'.$i.'][text]'])
                        @includeIf('components.forms.text', ['name' => 'Icone', 'id' => $id.'[web][links][link-'.$i.'][icon]'])
                        <small>(icon bootstrap: exemple: bi bi-heart-fill)</small>
                        @includeIf('components.forms.url', ['name' => 'url', 'id' => $id.'[web][links][link-'.$i.'][url]'])
                    </div>
                    @includeIf('components.forms.switch', ['name' => 'Ouvrir dans un nouvel onglet', 'id' => $id.'[web][links][link-'.$i.'][blank]'])
                </div>
            </fieldset>
        @endfor
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Nous supporter</legend>
    @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[support][title]'])
    @includeIf('components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[support][paragraph]'])
    @for($i=1;$i<=1;$i++)
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS {{$i}}</legend>
            <div class="d-flex flex-column gap-2">
                <div>
                    @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[support][links][link-'.$i.'][text]'])
                    @includeIf('components.forms.text', ['name' => 'Icone (icon bootstrap: exemple: bi bi-heart-fill)', 'id' => $id.'[support][links][link-'.$i.'][icon]'])
                    @includeIf('components.forms.url', ['name' => 'url', 'id' => $id.'[support][links][link-'.$i.'][url]'])
                </div>
                @includeIf('components.forms.switch', ['name' => 'Ouvrir dans un nouvel onglet', 'id' => $id.'[support][links][link-'.$i.'][blank]'])
            </div>
        </fieldset>
    @endfor
</fieldset>
