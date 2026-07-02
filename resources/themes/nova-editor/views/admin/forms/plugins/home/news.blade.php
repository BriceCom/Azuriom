<x-admin.card :title="trans('theme::admin.menus.home.news')">
    @include('admin.components.forms.switch', [
                  'direction' => 'row',
                  'id' => $id.'[off]',
                  'name' => trans('theme::admin.disable')
              ])

    @include('admin.components.forms.number', [
        'id' => $id.'[order]',
        'name' => trans('theme::admin.display_order'),
        'min' => 1,
        'max' => 99,
        'step' => 1
    ])


    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])


    <x-admin.fieldset :title="trans('theme::admin.form.article')">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.badge_text'), 'id' => $id.'[badge][name]'])
    </x-admin.fieldset>

    <x-admin.fieldset :title="trans('theme::admin.form.button')">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[link][name]'])
    </x-admin.fieldset>
</x-admin.card>
