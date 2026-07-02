<x-admin.card :title="trans('theme::admin.menus.home.textbuttonimage')">
    @include('admin.components.forms.switch', [
        'direction' => 'row',
        'id' => $id.'[on]',
        'name' => trans('theme::admin.active')
    ])

    @include('admin.components.forms.number', [
        'id' => $id.'[order]',
        'name' => trans('theme::admin.display_order'),
        'min' => 1,
        'max' => 99,
        'step' => 1
    ])

    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.textarea', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]', 'wysiwyg' => true])

    <x-admin.fieldset :title="trans('theme::admin.form.button')">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[link][text]'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[link][url]'])
    </x-admin.fieldset>

    <x-admin.fieldset :title="trans('theme::admin.form.image')">
        @include('admin.components.forms.image-azuriom', ['name' => trans('theme::admin.form.image'), 'id' => $id.'[image]'])
    </x-admin.fieldset>
</x-admin.card>
