<x-admin.card :title="trans('theme::admin.menus.home.results')">
    @include('admin.components.forms.switch', [
        'direction' => 'row',
        'id' => $id.'[off]',
        'name' => trans('theme::admin.disable')
    ])

    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.textarea', ['name' => trans('theme::admin.form.subtitle'), 'id' => $id.'[subtitle]'])
    @include('admin.components.forms.textarea', ['name' => trans('theme::admin.form.quote'), 'id' => $id.'[quote]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.author'), 'id' => $id.'[author]'])
</x-admin.card>
