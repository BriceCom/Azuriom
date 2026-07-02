<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Qu-est ce que ?</legend>
    <div class="d-flex flex-column flex-md-row flex-wrap gx-2">
        <div class="d-flex flex-column gap-3 w-100 mb-2">
            @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[who][title]'])
            @includeIf('components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[who][paragraph]'])
        </div>
        @for($i=1;$i<=10;$i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-25">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">JEUX {{$i}}</legend>
                <div class="d-flex flex-column gap-2">
                    <div>
                        @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[who][games][game-'.$i.'][text]'])
                        @includeIf('components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[who][games][game-'.$i.'][img]'])
                    </div>
                </div>
            </fieldset>
        @endfor
    </div>
</fieldset>
