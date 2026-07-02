<fieldset class="p-2 d-flex flex-column gap-3">
    <fieldset class="d-flex flex-row flex-wrap gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">RECOMPENSES</legend>
        @for($i=1; $i<=10; $i++)
                @include('admin.components.forms.text', ['name' => 'Récompense '.$i, 'id' => $id.'[reward]['.$i.']'])
        @endfor

    </fieldset>
</fieldset>
