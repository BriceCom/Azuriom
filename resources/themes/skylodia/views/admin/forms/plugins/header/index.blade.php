<div class="p-2 d-flex flex-column gap-3">
    <div class="d-flex flex-wrap gap-3">

        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Boutton</legend>
            @include('admin.components.forms.text', ['name' => 'Text', 'id' => $id.'[button][text]'])
            @include('admin.components.forms.text', ['name' => 'Lien', 'id' => $id.'[button][link]'])
        </fieldset>
    </div>

</div>
