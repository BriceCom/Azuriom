<div class="p-2 d-flex flex-column gap-3">
    <div class="d-flex flex-wrap gap-3">
        @include('admin.components.forms.textarea', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]', 'wysiwyg' => true])
    </div>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.form.links')}}</legend>
            <div class="d-flex flex-column gap-2">
                @include('admin.components.forms.list-input', ['id' => 'footer_links', 'name' => $id.'[links]', 'inputUrl' => true, 'inputUrlBlank' => true, 'values' => theme_config('footer.index.links') ?? []])
            </div>
    </fieldset>
</div>
