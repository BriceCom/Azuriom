<div class="d-flex flex-column gap-4">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.settings')}}</legend>
        @include('admin.components.forms.switch', [
            'direction' => 'row',
            'id' => $id.'[off]',
            'name' => trans('theme::admin.disable')
        ])
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Bentobox</legend>
        <div class="d-flex flex-column gap-2">


            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend
                    class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.vote.title')}}</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[vote][title]'])
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[vote][text]'])
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text') .' - '. trans('theme::admin.vote_empty'), 'id' => $id.'[vote_empty][text]'])
                </div>
                <div class="d-flex flex-column gap-2 mt-3">
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text') .' - '. trans('theme::admin.disabled_plugin', ['name' => 'Vote']), 'id' => $id.'[vote][text]'])
                    @include('admin.components.forms.textaera', ['name' => trans('theme::admin.form.text') .' - '. trans('theme::admin.disabled_plugin', ['name' => 'Vote']), 'id' => $id.'[vote][wysiwyg]', 'wysiwyg' => true])
                </div>
            </fieldset>

            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend
                    class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.user_disconnected')}}</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[user_disconnected][title]'])
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[user_disconnected][text]'])
                </div>
            </fieldset>

            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend
                    class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.shop')}}</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[shop][title]'])

                    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                        <legend
                            class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.form.link')}}</legend>
                        <div class="d-flex flex-column gap-2">
                            @include('admin.components.forms.switch', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[shop][link][blank]', 'direction' => 'row'])
                            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[shop][link][text]'])
                            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[shop][link][url]'])
                        </div>
                    </fieldset>
                </div>
            </fieldset>
        </div>
    </fieldset>
</div>
