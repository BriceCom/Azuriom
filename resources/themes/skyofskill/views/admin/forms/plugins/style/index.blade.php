<x-admin.card :title="trans('theme::admin.theme_mode.title')" class="flex-row">
            @include('admin.components.forms.switch', [
                'id' => $id.'[theme][dark][off]',
                'name' => trans('theme::admin.theme_mode.off')
            ])
            @include('admin.components.forms.switch', [
                'id' => $id.'[theme][dark][prefer]',
                'name' => trans('theme::admin.theme_mode.dark_priority')
            ])
</x-admin.card>

<x-admin.card :title="trans('theme::admin.background')">
            <p>Configurez un fond pour les thème clair ou thème sombre, le fond d'image par défaut est celui qui est configuré dans vos
                <a href="http://127.0.0.1:8000/admin/settings#imageSelect" target="_blank">paramètres Azuriom</a>.</p>

            @include('admin.components.forms.image-azuriom', ['name' => trans('theme::admin.background_light'), 'id' => $id.'[background][light]'])
            @include('admin.components.forms.image-azuriom', ['name' => trans('theme::admin.background_dark'), 'id' => $id.'[background][dark]'])
</x-admin.card>

<x-admin.card :title="trans('theme::admin.font.title')">
    <x-admin.fieldset class="flex-column">
        @include('admin.components.forms.switch', [
            'direction' => 'row',
            'id' => $id.'[font][on]',
            'name' => trans('theme::admin.font.on')
        ])

        <x-admin.fieldset :title="trans('theme::admin.primary_font_example_for_tile')" class="d-flex gap-3">
            @include('admin.components.forms.url', [
                'id' => $id.'[font][url]',
                'nameToUpper' => false,
                'name' => strtoupper(trans('theme::admin.font.link_of_font')).' <a target="_blank" href="https://fonts.bunny.net/">'.trans('theme::admin.font.find_custom_font').'</a>',
                'placeholder' => "https://fonts.bunny.net/css?family=poppins:100,200,300,400,500,600,700,700i,800,900&display=swap",
                'class' => 'w-50'
            ])

            @include('admin.components.forms.text', [
                'id' => $id.'[font][name]',
                'nameToUpper' => false,
                'name' => trans('theme::admin.name_of_font'),
                'placeholder' => "Poppins",
            ])
        </x-admin.fieldset>
    </x-admin.fieldset>
</x-admin.card>
