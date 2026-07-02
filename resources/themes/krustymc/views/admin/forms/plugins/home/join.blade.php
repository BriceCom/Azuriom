<div class="mb-3">
@include('admin.components.forms.switch', [
                'direction' => 'row',
                'id' => $id.'[off]',
                'name' => trans('theme::admin.disable')
            ])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])


    @include('admin.components.forms.textaera', ['name' => "Contenu", 'id' => $id.'[content]', "wysiwyg" => true])

</div>
