<x-admin.card :title="trans('theme::admin.footer.copyright')" :advanced="true">
    @include('admin.components.forms.switch', [
        'direction' => 'row',
        'id' => $id.'[dixept_copyright][off]',
        'name' => trans('theme::admin.footer.index.dixept_copyright.off')
    ])
</x-admin.card>

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

<x-admin.card :title="trans('theme::admin.form.left_section')">
    @include('admin.components.forms.image-azuriom', [
        'name' => trans('theme::admin.form.image'),
        'id' => $id.'[image]'
    ])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])
</x-admin.card>

<x-admin.card :title="'Button'">
    @include('admin.components.forms.switch', [
        'direction' => 'row',
        'id' => $id.'[button][off]',
        'name' => trans('theme::admin.disable')
    ])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[button][title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.description'), 'id' => $id.'[button][description]'])

    <x-admin.fieldset class="flex-column" :title="trans('theme::admin.form.button')">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[button][text]'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[button][url]'])
    </x-admin.fieldset>
</x-admin.card>

@for($i=1;$i<=1;$i++)
    <x-admin.card :title="trans('theme::admin.form.links').' '. $i">
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[links]['.$i.'][title]'])
            @include('admin.components.forms.list-input', ['id' => 'footer-links'.$i, 'name' => $id.'[links]['.$i.'][links]', 'inputUrl' => true, 'inputUrlBlank' => true, 'values' => theme_config('footer.index.links.'.$i.'.links') ?? []])
    </x-admin.card>
@endfor
