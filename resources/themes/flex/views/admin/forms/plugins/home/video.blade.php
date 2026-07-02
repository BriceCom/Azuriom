<x-admin.card :title="trans('theme::admin.menus.home.trailer')">
    @include('admin.components.forms.switch', [
            'direction' => 'row',
            'id' => $id.'[trailer][off]',
            'name' => trans('theme::admin.disable')
        ])

    @include('admin.components.forms.number', [
        'id' => $id.'[order]',
        'name' => trans('theme::admin.display_order'),
        'min' => 1,
        'max' => 99,
        'step' => 1
    ])

    @include('admin.components.forms.text', ['name' => trans('theme::admin.badge_text'), 'id' => $id.'[badge]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[url]', 'placeholder' => 'https://www.youtube.com/embed/XXXXXXX'])
</x-admin.card>
