<x-admin.card :title="trans('theme::admin.max_width')">
    @include('admin.components.forms.range', [
        'name' => trans('theme::admin.max_width'),
        'id' => $id.'[container][max-width]',
        'value' => 1320,
        'max' => 2000,
        'min' => 960,
        'step' => 10
    ])
</x-admin.card>

<x-admin.card :title="trans('theme::admin.max_height')">
    @include('admin.components.forms.range', ['name' => trans('theme::admin.pixel'), 'id' => $id.'[hero][bg][max-height]', 'value' => 1000,'max' => 1024, 'min' => 100, 'step' => 1])
</x-admin.card>

<x-admin.card :title="trans('theme::admin.form.links')">
        @include('admin.components.forms.switch', [
            'direction' => 'row',
            'id' => $id.'[links][center]',
            'name' => trans('theme::admin.no_center')
        ])

            @include('admin.components.forms.switch', [
             'direction' => 'row',
             'id' => $id.'[notif][off]',
             'name' => trans('theme::admin.notifications')
         ])

        @include('admin.components.forms.switch', [
            'direction' => 'row',
            'id' => $id.'[links][remove_active_background]',
            'name' => trans('theme::admin.remove_active_background')
        ])

        @include('admin.components.forms.select', [
            'id' => $id.'[links][shop_variant]',
            'name' => trans('theme::admin.header.links.shop_btn_color_variant'),
            'options' => [
                ['value' => 'primary', 'text' => trans('theme::admin.style.colors.primary')],
                ['value' => 'secondary', 'text' => trans('theme::admin.style.colors.secondary')],
                ['value' => 'tertiary', 'text' => trans('theme::admin.style.colors.tertiary')]
            ],
            'value' => theme_config('header.index.links.shop_variant') ?? 'tertiary',
        ])
</x-admin.card>

<x-admin.card :title="trans('theme::admin.logo')">
        @include('admin.components.forms.image-azuriom', [
            'name' => trans('theme::admin.form.image'),
            'id' => $id.'[image]'
        ])
        @include('admin.components.forms.range', ['name' => trans('theme::admin.pixel'), 'id' => $id.'[hero][img][height]', 'value' => 235,'max' => 500, 'min' => 64, 'step' => 1])
</x-admin.card>
