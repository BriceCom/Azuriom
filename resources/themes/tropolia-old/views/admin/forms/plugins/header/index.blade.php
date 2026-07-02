<div>
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Logo</legend>
        @include('admin.components.forms.range', ['name' => trans('theme::admin.pixel'), 'id' => $id.'[hero][img][height]', 'value' => 64,'max' => 500, 'min' => 64, 'step' => 1])
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border border p-2">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Boutton</legend>
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[button][icon]', 'icon' => true])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[button][text]'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[button][url]'])
    </fieldset>
</div>
