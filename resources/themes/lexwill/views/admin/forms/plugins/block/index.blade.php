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
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Block</legend>
        <div class="d-flex flex-column gap-2">

            <div class="d-flex flex-wrap gap-2">
                @for($i = 1; $i <= 3; $i++)
                    <fieldset class="w-25 d-flex flex-column gap-3 border p-2">
                        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Tag {{$i}}</legend>
                        <div class="d-flex flex-column gap-2">
                            @include('admin.components.forms.text', ['name' => 'Text', 'id' => $id.'[tags]['.$i.'][text]'])
                        </div>
                    </fieldset>
                @endfor
            </div>

            @include('admin.components.forms.text', ['name' => 'Date', 'id' => $id.'[date]'])
            @include('admin.components.forms.text', ['name' => 'Titre', 'id' => $id.'[title]'])
            @include('admin.components.forms.textaera', ['name' => 'Texte', 'id' => $id.'[text]', 'wysiwyg' => true])


            @include('admin.components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[img]'])


            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Button</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => 'Text', 'id' => $id.'[button][text]'])
                    @include('admin.components.forms.text', ['name' => 'Lien', 'id' => $id.'[button][url]'])
                    @include('admin.components.forms.switch', ['name' => 'Nouvel onglet', 'id' => $id.'[button][blank]'])
                </div>
            </fieldset>

            @include('admin.components.forms.number', ['name' => 'Note', 'id' => $id.'[rating]', 'max' => 5, 'min' => 0, 'step' => 1])

        </div>
    </fieldset>
</div>
