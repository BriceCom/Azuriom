

<div>
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Logo</legend>
        @include('admin.components.forms.range', ['name' => trans('theme::admin.pixel'), 'id' => $id.'[hero][img][height]', 'value' => 235,'max' => 500, 'min' => 64, 'step' => 1])
    </fieldset>
</div>