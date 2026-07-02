<x-admin.card :title="trans('theme::admin.menus.home.stats')">
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

    <x-admin.fieldset :title="trans('theme::admin.stats.first')">
        @include('admin.components.forms.text', [
            'name' => trans('theme::admin.stats.value'),
            'id' => $id.'[first][value]',
            'placeholder' => '{vote_total}+'
        ])
        @include('admin.components.forms.text', [
            'name' => trans('theme::admin.stats.label'),
            'id' => $id.'[first][label]',
            'placeholder' => 'Total de votes'
        ])
    </x-admin.fieldset>

    <x-admin.fieldset :title="trans('theme::admin.stats.second')">
        @include('admin.components.forms.text', [
            'name' => trans('theme::admin.stats.value'),
            'id' => $id.'[second][value]',
            'placeholder' => '{server_online}'
        ])
        @include('admin.components.forms.text', [
            'name' => trans('theme::admin.stats.label'),
            'id' => $id.'[second][label]',
            'placeholder' => 'Joueurs en ligne'
        ])
    </x-admin.fieldset>

    <x-admin.fieldset :title="trans('theme::admin.stats.third')">
        @include('admin.components.forms.text', [
            'name' => trans('theme::admin.stats.value'),
            'id' => $id.'[third][value]',
            'placeholder' => '10 ans'
        ])
        @include('admin.components.forms.text', [
            'name' => trans('theme::admin.stats.label'),
            'id' => $id.'[third][label]',
            'placeholder' => "d'expérience"
        ])
    </x-admin.fieldset>

    <small class="text-muted">{{ trans('theme::admin.stats.help') }}</small>
</x-admin.card>
