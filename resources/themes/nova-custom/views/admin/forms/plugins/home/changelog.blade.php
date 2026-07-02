<x-admin.card :title="trans('theme::admin.menus.home.changelog')">
    @include('admin.components.forms.switch', [
                        'direction' => 'row',
                        'id' => $id.'[off]',
                        'name' => trans('theme::admin.disable')
                    ])


    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])

    <x-admin.fieldset :title="trans('theme::admin.form.button')">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[link][name]'])
    </x-admin.fieldset>
</x-admin.card>
