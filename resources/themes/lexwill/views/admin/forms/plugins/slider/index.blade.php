<div class="d-flex flex-column gap-5">

    <div class="d-flex flex-column gap-5">
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Taille du texte</legend>
            <div class="d-flex flex-column gap-2">
                @include('admin.components.forms.range', ['name' => '0.5 = normal', 'max' => 1, 'min' => 0, 'step' => 0.01, 'value'=>  0.53, 'id' => $id.'[fontSize]'])
            </div>
        </fieldset>
    </div>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Staff</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.text', ['name' => 'Titre', 'id' => $id.'[title]'])

            <div class="d-flex flex-wrap justify-content-between gap-4 border p-2 w-100">
                @for($i = 1; $i <= 3; $i++)
                    <fieldset class="w-100 d-flex gap-3">
                        <legend class="float-none p-2 py-0 bg-dark text-white text-lg">Slider {{$i}}</legend>
                        <div class="d-flex flex-column gap-2">
                            @include('admin.components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[sliders]['.$i.'][img]'])
                            @include('admin.components.forms.text', ['name' => 'Titre', 'id' => $id.'[sliders]['.$i.'][title]'])
                            @include('admin.components.forms.text', ['name' => 'Sous-titre', 'id' => $id.'[sliders]['.$i.'][subtitle]'])
                            @include('admin.components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[sliders]['.$i.'][text]', "wysiwyg" => true])
                            @include('admin.components.forms.text', ['name' => 'Url du bouton', 'id' => $id.'[sliders]['.$i.'][link][url]'])
                            @include('admin.components.forms.text', ['name' => 'Texte du bouton', 'id' => $id.'[sliders]['.$i.'][link][text]'])
                            @include('admin.components.forms.switch', ['name' => 'Lien sortant', 'id' => $id.'[sliders]['.$i.'][link][blank]'])
                        </div>
                    </fieldset>
                @endfor
            </div>
        </div>
    </fieldset>
</div>
