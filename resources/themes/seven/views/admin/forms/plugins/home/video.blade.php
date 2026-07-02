<div class="d-flex flex-column gap-4">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.settings')}}</legend>
        @include('admin.components.forms.switch', [
            'direction' => 'row',
            'id' => $id.'[cta][off]',
            'name' => trans('theme::admin.disable') . ' : Call to Action'
        ])
        @include('admin.components.forms.switch', [
            'direction' => 'row',
            'id' => $id.'[trailer][off]',
            'name' => trans('theme::admin.disable') . ' : Trailer'
        ])
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.video')}}</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])
            @include('admin.components.forms.url', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[url]'])
        </div>
    </fieldset>
</div>
