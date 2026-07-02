<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Image</legend>
    @includeIf('components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[background]'])
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Statistiques</legend>
    @includeIf('components.forms.text', ['name' => 'Texte 1', 'id' => $id.'[stats][1]'])
    @includeIf('components.forms.text', ['name' => 'Texte 2', 'id' => $id.'[stats][2]'])
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">A propos</legend>
    @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[about][title]'])
    @includeIf('components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[about][paragraph]'])
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS IMPORTANT</legend>
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
