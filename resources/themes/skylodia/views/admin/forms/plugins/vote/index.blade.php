<div class="p-2 d-flex flex-column gap-3">
    <div class="row gap-3">
        @for($i=1;$i<=10;$i++)
            <fieldset class="col-md-5 d-flex flex-column flex-md-row gap-3 border p-2">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Récompense top {{$i}}</legend>
                <div class='d-flex gap-3'>
                    @include('admin.components.forms.textaera', ['name' => 'Texte', 'id' => $id.'[reward]['.$i.']', 'wysiwyg' => true])
                </div>
            </fieldset>
        @endfor
    </div>
</div>
