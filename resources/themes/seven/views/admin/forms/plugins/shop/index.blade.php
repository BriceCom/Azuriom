<div class="p-2 d-flex flex-column flex-md-row gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.form.text')}}</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title') . trans('theme::admin.form.logout_brackets'), 'id' => $id.'[title]'])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text') . trans('theme::admin.form.logout_brackets'), 'id' => $id.'[text]'])
        </div>
    </fieldset>
</div>
