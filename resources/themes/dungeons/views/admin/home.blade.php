<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Hero</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('components.forms.number', ['name' => 'Ordre image par rapport au texte', 'id' => $id.'[hero][order]', 'min'=>0, 'max'=>1, 'step'=>1])
        <small>0 pour l'image à gauche, 1 pour l'image à droite</small>
        @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[hero][title]'])
        @includeIf('components.forms.text', ['name' => 'Paragraphe', 'id' => $id.'[hero][paragraph]'])
        @includeIf('components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[hero][image]'])
        <div class="d-flex flex-column flex-md-row">
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Button Jouer</legend>
                <div class="d-flex gap-2">
                    @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[hero][play-button][text]'])
                    @includeIf('components.forms.url', ['name' => 'Lien', 'id' => $id.'[hero][play-button][url]'])
                </div>
            </fieldset>
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Button Ip</legend>
                <div class="d-flex gap-2">
                    @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[hero][server-button][text]'])
                    @includeIf('components.forms.text', ['name' => 'IP', 'id' => $id.'[hero][server-button][ip]'])
                </div>
            </fieldset>
        </div>
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Article</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[article][title]', 'placeholder' => 'Titre de la section'])
        @includeIf('components.forms.text', ['name' => 'Paragraphe', 'id' => $id.'[article][paragraph]', 'placeholder' => 'Paragraphe de la section'])
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Trailer</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[trailer][title]', 'placeholder' => 'Titre de la section'])
        @includeIf('components.forms.text', ['name' => 'Paragraphe', 'id' => $id.'[trailer][paragraph]', 'placeholder' => 'Paragraphe de la section'])

        <div class="d-flex flex-column flex-md-row">
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Trailer 1</legend>
                <div class="d-flex flex-column gap-2">
                    @includeIf('components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[trailer][trailer-one][image]'])
                    @includeIf('components.forms.url', ['name' => 'Lien de la video', 'id' => $id.'[trailer][trailer-one][url]', 'placeholder'=>'https://www.youtube.com/embed/m_yqOoUMHPg?autoplay=1'])
                    <small>Attention le 'embed' dans le lien doit être présent!</small>
                </div>
            </fieldset>
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Trailer 2</legend>
                <div class="d-flex flex-column gap-2">
                    @includeIf('components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[trailer][trailer-two][image]'])
                    @includeIf('components.forms.url', ['name' => 'Lien de la video', 'id' => $id.'[trailer][trailer-two][url]', 'placeholder'=>'https://www.youtube.com/embed/m_yqOoUMHPg?autoplay=1'])
                    <small>Attention le 'embed' dans le lien doit être présent!</small>
                </div>
            </fieldset>
        </div>
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Assurance</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[assurance][title]', 'placeholder' => 'Titre de la section'])
        @includeIf('components.forms.text', ['name' => 'Paragraphe', 'id' => $id.'[assurance][paragraph]', 'placeholder' => 'Paragraphe de la section'])

        <div class="d-flex flex-column flex-md-row flex-wrap">
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Carte 1</legend>
                <div class="d-flex flex-column gap-2">
                    @includeIf('components.forms.text', ['name' => 'Icon', 'id' => $id.'[assurance][card-one][icon]', 'placeholder'=>'bi bi-house'])
                    <small>Icon boostrap seulement</small>
                    @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[assurance][card-one][title]'])
                    @includeIf('components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[assurance][card-one][paragraph]'])
                </div>
            </fieldset>
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Carte 2</legend>
                <div class="d-flex flex-column gap-2">
                    @includeIf('components.forms.text', ['name' => 'Icon', 'id' => $id.'[assurance][card-two][icon]', 'placeholder'=>'bi bi-house'])
                    <small>Icon boostrap seulement</small>
                    @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[assurance][card-two][title]'])
                    @includeIf('components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[assurance][card-two][paragraph]'])
                </div>
            </fieldset>
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Carte 3</legend>
                <div class="d-flex flex-column gap-2">
                    @includeIf('components.forms.text', ['name' => 'Icon', 'id' => $id.'[assurance][card-three][icon]', 'placeholder'=>'bi bi-house'])
                    <small>Icon boostrap seulement</small>
                    @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[assurance][card-three][title]'])
                    @includeIf('components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[assurance][card-three][paragraph]'])
                </div>
            </fieldset>
        </div>
    </div>
</fieldset>

