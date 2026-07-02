<div class="mb-3">
@include('admin.components.forms.switch', [
                'direction' => 'row',
                'id' => $id.'[off]',
                'name' => trans('theme::admin.disable')
            ])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])


    @include('admin.components.forms.textarea', ['name' => "Contenu", 'id' => $id.'[content]', "wysiwyg" => true])


    <fieldset class="d-flex flex-column gap-3 border p-2 w-100 mt-5">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Faq</legend>

        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[faq][title]'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[faq][text]'])

        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Questions</legend>

            <div class="d-flex flex-column gap-2">
                @include('admin.components.forms.list-input', ['id' => 'faqs', 'name' => $id.'[faq][faqs]', 'inputTexarea' => true, 'inputTexareaWysiwyg' => true, 'values' => theme_config('home.join.faq.faqs') ?? []])
            </div>
        </fieldset>
    </fieldset>
</div>
