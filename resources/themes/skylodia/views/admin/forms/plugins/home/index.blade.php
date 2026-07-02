<div class="p-2 d-flex flex-column gap-3">

    @for($i=1;$i<=1;$i++)
        <fieldset class="d-flex flex-column flex-md-row gap-3 border p-2 w-50">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Stat Record</legend>
            <div class='d-flex gap-3'>
                @include('admin.components.forms.text', ['name' => 'Montant', 'id' => $id.'[stats]['.$i.'][title]', 'placeholder' => '972'])
                @include('admin.components.forms.text', ['name' => 'Texte', 'id' => $id.'[stats]['.$i.'][text]', 'placeholder' => 'Record connectés'])
            </div>
        </fieldset>
    @endfor
</div>
