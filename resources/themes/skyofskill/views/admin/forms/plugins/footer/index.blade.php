<x-admin.card :title="trans('theme::admin.form.left_section')">
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]', 'placeholder' => 'Premier serveur Skyblock et opprison de france SkyOfSkill'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]', 'placeholder' => 'SkyOfSkill est le premier serveur minecraft français à fusionner en un seul mode de jeu le SkyBlock et l’OpPrison. PLAY.SKYOFSKILL.FR - 1.8.8 à la 1.20.1'])
</x-admin.card>

<x-admin.card :title="'Button'">
    @include('admin.components.forms.switch', [
        'direction' => 'row',
        'id' => $id.'[button][off]',
        'name' => trans('theme::admin.disable')
    ])

    <x-admin.fieldset class="flex-column" :title="trans('theme::admin.form.button')">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.icon'), 'icon' => true, 'id' => $id.'[button][icon]', 'placeholder' => 'bi bi-cart'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[button][text]', 'placeholder' => 'Boutique'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[button][url]'])
    </x-admin.fieldset>
</x-admin.card>

@for($i=1;$i<=1;$i++)
    <x-admin.card :title="trans('theme::admin.form.links')">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[links]['.$i.'][title]', 'placeholder' => 'Liens utiles'])
        @include('admin.components.forms.list-input',
            ['id' => 'footer-links'.$i,
            'name' => $id.'[links]['.$i.'][links]',
            'inputText' => true,
            'inputUrl' => true,
            'inputUrlBlank' => true,
            'values' => theme_config('footer.index.links.'.$i.'.links') ?? []
            ])
    </x-admin.card>
@endfor


<x-admin.card :title="trans('theme::admin.form.legals')">
    @include('admin.components.forms.list-input', [
        'id' => 'footer-links-legals',
        'name' => $id.'[legals][links]',
        'inputText' => true,
        'inputUrl' => true,
        'inputUrlBlank' => true,
        'values' => theme_config('footer.index.legals.links') ?? []]
    )
</x-admin.card>
