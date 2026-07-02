<div class="p-2 d-flex flex-column gap-3">
    <div class="d-flex flex-column gap-5">
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Taille du texte</legend>
            <div class="d-flex flex-column gap-2">
                @include('admin.components.forms.range', ['name' => '0.5 = normal', 'max' => 1, 'min' => 0, 'step' => 0.01, 'value'=>  0.53, 'id' => $id.'[fontSize]'])
            </div>
        </fieldset>
    </div>


    @include('admin.components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[text]', 'wysiwyg' => true])

    <div class="p-2 d-flex flex-column flex-md-row gap-3">
        @for($i = 0; $i < 6; $i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Lien {{$i}}</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => 'Text', 'id' => $id.'[links]['.$i.'][text]'])
                    @include('admin.components.forms.text', ['name' => 'Lien', 'id' => $id.'[links]['.$i.'][url]'])
                </div>
            </fieldset>
        @endfor
    </div>
</div>
