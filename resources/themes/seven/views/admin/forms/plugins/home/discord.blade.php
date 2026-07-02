<div class="d-flex flex-column gap-4">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.settings')}}</legend>
        @include('admin.components.forms.switch', [
            'direction' => 'row',
            'id' => $id.'[off]',
            'name' => trans('theme::admin.disable')
        ])
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Discord</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.image-azuriom', ['name' => trans('theme::admin.form.image'), 'id' => $id.'[img]'])
            @include('admin.components.forms.range', ['name' => trans('theme::admin.form.image_size_height'), 'id' => $id.'[imgHeight]', 'min' => 0, 'max' => 500, 'step' => 1, 'value' => 170])
            @include('admin.components.forms.textaera', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]', "wysiwyg" => true, "height" => 200])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])

            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.form.link')}}</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[link][text]'])
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[link][url]'])
                </div>
            </fieldset>
        </div>
    </fieldset>
</div>
