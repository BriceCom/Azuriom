<x-admin.card :title="trans('theme::admin.menus.header.hero')">
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
    @include('admin.components.forms.image-azuriom', ['name' => trans('theme::admin.form.image'), 'id' => $id.'[image]'])
    @include('admin.components.forms.image-azuriom', ['name' => trans('theme::admin.background'), 'id' => $id.'[bg]'])
</x-admin.card>
