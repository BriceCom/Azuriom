<div class="p-2 d-flex flex-column gap-3">

    <div class="mb-4">
        @include('admin.components.forms.switch', [
            'direction' => 'row',
            'id' => $id.'[server][show]',
            'name' => trans('theme::admin.server_button_hide')
        ])
    </div>

    @include('admin.components.forms.textaera', [
        'id' => $id.'[text]',
        'wysiwyg' => true,
        'name' => "Text home",
    ])
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.image')}}</legend>

    @include('admin.components.forms.range', [
        'id' => $id.'[image][opacity]',
        'name' => trans('theme::admin.opacity'),
        'value' => 50,
        'max' => 100,
        'min' => 0,
        'step' => 1
    ])

    @include('admin.components.forms.range', [
        'id' => $id.'[image][blur]',
        'name' => trans('theme::admin.blur'),
        'value' => 7,
        'max' => 100,
        'min' => 0,
        'step' => 1
    ])

</fieldset>


</div>
