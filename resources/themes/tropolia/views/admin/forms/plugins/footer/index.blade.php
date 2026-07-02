<div class="p-2 d-flex flex-column gap-3">

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Button soutenir</legend>

        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.switch', [
                'direction' => 'row',
                'id' => $id.'[button][off]',
                'name' => trans('theme::admin.disable')
            ])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[button][title]'])
            <div class="d-flex flex-wrap gap-2">
                @include('admin.components.forms.text', ['name' => trans('theme::admin.form.icon'), 'id' => $id.'[button][icon]', 'icon' => true])
                @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[button][text]'])
                @include('admin.components.forms.text', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[button][url]'])
            </div>
        </div>
    </fieldset>

    @for($i=1;$i<=2;$i++)
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.form.links').' '. $i}}</legend>
            <div class="d-flex flex-column gap-2">

            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[links]['.$i.'][title]'])

            @include('admin.components.forms.list-input', ['id' => 'footer-links'.$i, 'name' => $id.'[links]['.$i.'][links]', 'inputUrl' => true, 'inputUrlBlank' => true, 'values' => theme_config('footer.index.links.'.$i.'.links') ?? []])
        </fieldset>
    @endfor
</div>
