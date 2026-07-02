<fieldset class="p-2 d-flex flex-column gap-3">
    <fieldset class="d-flex flex-row flex-wrap gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS</legend>
        @for($i=1; $i<=3; $i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Lien {{$i}}</legend>
                @include('admin.components.forms.text', ['name' => 'Lien', 'id' => $id.'[links]['.$i.'][url]'])
                @include('admin.components.forms.text', ['name' => 'Texte', 'id' => $id.'[links]['.$i.'][text]'])
            </fieldset>
        @endfor

    </fieldset>
</fieldset>
