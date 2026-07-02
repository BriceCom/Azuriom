<div class="p-2 d-flex flex-column gap-3">

    <div class="d-flex flex-column gap-5">
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Taille du texte</legend>
            <div class="d-flex flex-column gap-2">
                @include('admin.components.forms.range', ['name' => '0.5 = normal', 'max' => 1, 'min' => 0, 'step' => 0.01, 'value'=>  0.53, 'id' => $id.'[fontSize]'])
            </div>
        </fieldset>
    </div>

    <div class="p-2 d-flex flex-column flex-md-row gap-3">
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Vote</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => 'Titre', 'id' => $id.'[vote][title]'])
                    @include('admin.components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[vote][text]', 'wysiwyg' => true])
                </div>
            </fieldset>
    </div>
    <div class="p-2 d-flex flex-column flex-md-row gap-3">
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Classement</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => 'Titre', 'id' => $id.'[top][title]'])
                    @include('admin.components.forms.textaera', ['name' => 'Paragraphe', 'id' => $id.'[top][text]', 'wysiwyg' => true])
                </div>
            </fieldset>
    </div>
</div>
