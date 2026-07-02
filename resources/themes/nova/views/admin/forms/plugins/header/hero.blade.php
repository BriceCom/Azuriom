<x-admin.card :title="trans('theme::admin.header.hero.server_section')">
    @include('admin.components.forms.switch', [
            'direction' => 'row',
            'id' => $id.'[server][hide]',
            'name' => trans('theme::admin.hide')
        ])

    @include('admin.components.forms.text', [
                'name' => trans('theme::admin.form.joinText'),
                'placeholder' => "Join {server_online} players !",
                'id' => $id.'[joinText]'
            ])

    @include('admin.components.forms.text', [
        'name' => trans('theme::admin.header.hero.server_address_copied'),
        'placeholder' => "Ip copied !",
        'id' => $id.'[server_address_copied]'
    ])
</x-admin.card>

<x-admin.card :title="trans('theme::admin.header.hero.discord_section')">
    @include('admin.components.forms.switch', [
           'direction' => 'row',
           'id' => $id.'[discord][hide]',
           'name' => trans('theme::admin.hide')
       ])

    @include('admin.components.forms.text', [
            'name' => trans('theme::admin.header.hero.discord_title'),
            'placeholder' => "{discord_online} online",
            'id' => $id.'[discord][title]'
        ])

    @include('admin.components.forms.text', [
        'name' => trans('theme::admin.header.hero.discord_text'),
        'placeholder' => "Join",
        'id' => $id.'[discord][text]'
    ])
</x-admin.card>
