<x-admin.card :title="trans('theme::admin.form.links')">
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
        @include('admin.components.forms.range', ['name' => trans('theme::admin.pixel'), 'id' => $id.'[hero][img][height]', 'value' => 235,'max' => 500, 'min' => 64, 'step' => 1])
</x-admin.card>

<x-admin.card :title="trans('theme::admin.max_height')">
        @include('admin.components.forms.range', ['name' => trans('theme::admin.pixel'), 'id' => $id.'[hero][bg][max-height]', 'value' => 1000,'max' => 1024, 'min' => 100, 'step' => 1])
</x-admin.card>
