<x-admin.card :title="trans('theme::admin.menus.home.support')">
    @include('admin.components.forms.switch', [
        'direction' => 'row',
        'id' => $id.'[off]',
        'name' => trans('theme::admin.disable')
    ])

    @include('admin.components.forms.image-azuriom', [
        'name' => trans('theme::admin.form.image'),
        'id' => $id.'[image]'
    ])

    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.textarea', ['name' => trans('theme::admin.form.subtitle'), 'id' => $id.'[subtitle]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.button_text'), 'id' => $id.'[cta]'])

    <x-admin.fieldset :title="trans('theme::admin.form.points')">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.point_1'), 'id' => $id.'[point_1]'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.point_2'), 'id' => $id.'[point_2]'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.point_3'), 'id' => $id.'[point_3]'])
    </x-admin.fieldset>
</x-admin.card>
