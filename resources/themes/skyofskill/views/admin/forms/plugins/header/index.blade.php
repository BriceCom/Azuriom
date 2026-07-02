<x-admin.card :title="trans('theme::admin.form.links')">
        <div class="d-flex flex-wrap align-items-center gap-2">
            @include('admin.components.forms.text', [
                'name' => 'Texte à détecter',
                'id' => $id.'[links][vote_variant][text]'])

            @include('admin.components.forms.select', [
                'id' => $id.'[links][vote_variant][color]',
                'name' => "Variant couleur",
                'options' => [
                    ['value' => 'primary', 'text' => trans('theme::admin.style.colors.primary')],
                    ['value' => 'secondary', 'text' => trans('theme::admin.style.colors.secondary')],
                    ['value' => 'tertiary', 'text' => trans('theme::admin.style.colors.tertiary')],
                    ['value' => 'quaternary', 'text' => trans('theme::admin.style.colors.quaternary')]
                ],
                'value' => theme_config('header.index.links.vote_variant') ?? 'quaternary',
            ])
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            @include('admin.components.forms.text', [
                'name' => 'Texte à détecter',
                'id' => $id.'[links][shop_variant][text]'])

            @include('admin.components.forms.select', [
                'id' => $id.'[links][shop_variant][color]',
                'name' => "Variant couleur",
                'options' => [
                    ['value' => 'primary', 'text' => trans('theme::admin.style.colors.primary')],
                    ['value' => 'secondary', 'text' => trans('theme::admin.style.colors.secondary')],
                    ['value' => 'tertiary', 'text' => trans('theme::admin.style.colors.tertiary')],
                    ['value' => 'quaternary', 'text' => trans('theme::admin.style.colors.quaternary')]
                ],
                'value' => theme_config('header.index.links.shop_variant') ?? 'tertiary',
            ])
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            @include('admin.components.forms.text', [
                'name' => 'Texte à détecter',
                'id' => $id.'[links][play_variant][text]'])

            @include('admin.components.forms.select', [
                'id' => $id.'[links][play_variant][color]',
                'name' => "Variant couleur",
                'options' => [
                    ['value' => 'primary', 'text' => trans('theme::admin.style.colors.primary')],
                    ['value' => 'secondary', 'text' => trans('theme::admin.style.colors.secondary')],
                    ['value' => 'tertiary', 'text' => trans('theme::admin.style.colors.tertiary')],
                    ['value' => 'quaternary', 'text' => trans('theme::admin.style.colors.quaternary')]
                ],
                'value' => theme_config('header.index.links.play_variant') ?? 'primary',
            ])
        </div>
</x-admin.card>
