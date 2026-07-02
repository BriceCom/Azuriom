<div class="mb-3">
@include('admin.components.forms.switch', [
                'direction' => 'row',
                'id' => $id.'[off]',
                'name' => trans('theme::admin.disable')
            ])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])
</div>
