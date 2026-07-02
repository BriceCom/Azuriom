<div class="p-2 d-flex flex-column flex-md-row gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Your Legend</legend>

        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.text', ['name' => 'ID Discord', 'id' => $id.'[discord-id]'])
        </div>
    </fieldset>
</div>
