<div class="mb-3">
@include('admin.components.forms.switch', [
                'direction' => 'row',
                'id' => $id.'[off]',
                'name' => trans('theme::admin.disable')
            ])
    @include('admin.components.forms.image-azuriom', ['name' => trans('theme::admin.form.image'), 'id' => $id.'[img]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])


    <fieldset class="d-flex flex-column gap-3 border border p-2 mt-4">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Boutton</legend>
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[button][icon]', 'icon' => true])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[button][text]'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[button][url]'])
    </fieldset>
</div>
