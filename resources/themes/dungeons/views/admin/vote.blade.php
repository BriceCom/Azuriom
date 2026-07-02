<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Hero</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('components.forms.number', ['name' => 'Ordre image par rapport au texte', 'id' => $id.'[hero][order]', 'min'=>0, 'max'=>1, 'step'=>1])
        <small>0 pour l'image à gauche, 1 pour l'image à droite</small>
        @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[hero][title]'])
        @includeIf('components.forms.text', ['name' => 'Paragraphe', 'id' => $id.'[hero][paragraph]'])
        @includeIf('components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[hero][image]'])
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Contenu</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[content][title]', 'placeholder' => 'Titre de la page'])
        @includeIf('components.forms.text', ['name' => 'Paragraphe', 'id' => $id.'[content][paragraph]', 'placeholder' => 'Paragraphe de la page'])

        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Récompenses top voteurs</legend>

            <div class="d-flex flex-column gap-2">
                @for($i = 1; $i<=5;$i++)
                    @includeIf('components.forms.text', ['name' => 'Récompense voteur ('.$i.')', 'id' => $id.'[top-vote-reward]['.$i.']'])
                @endfor
            </div>
        </fieldset>
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Classement</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[classement][title]', 'placeholder' => 'Titre de la section'])
        @includeIf('components.forms.text', ['name' => 'Paragraphe', 'id' => $id.'[classement][paragraph]', 'placeholder' => 'Paragraphe de la section'])
    </div>
</fieldset>

