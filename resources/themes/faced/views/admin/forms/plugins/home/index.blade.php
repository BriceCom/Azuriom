<div class="p-2 d-flex flex-column gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Bentobox</legend>
        <div class="d-flex flex-column gap-2">

            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.vote.title')}}</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[bentobox][vote][title]'])
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[bentobox][vote][text]'])
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text') .' - '. trans('theme::admin.vote_empty'), 'id' => $id.'[bentobox][vote_empty][text]'])
                </div>
                <div class="d-flex flex-column gap-2 mt-3">
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text') .' - '. trans('theme::admin.disabled_plugin', ['name' => 'Vote']), 'id' => $id.'[bentobox][vote][text]'])
                    @include('admin.components.forms.textaera', ['name' => trans('theme::admin.form.text') .' - '. trans('theme::admin.disabled_plugin', ['name' => 'Vote']), 'id' => $id.'[bentobox][vote][wysiwyg]', 'wysiwyg' => true])
                </div>
            </fieldset>

            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.user_disconnected')}}</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[bentobox][user_disconnected][title]'])
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[bentobox][user_disconnected][text]'])
                </div>
            </fieldset>

            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.shop')}}</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[bentobox][shop][title]'])

                    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.form.link')}}</legend>
                        <div class="d-flex flex-column gap-2">
                            @include('admin.components.forms.switch', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[bentobox][shop][link][blank]', 'direction' => 'row'])
                            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[bentobox][shop][link][text]'])
                            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[bentobox][shop][link][url]'])
                        </div>
                    </fieldset>
                </div>
            </fieldset>
        </div>
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Discord</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.image-azuriom', ['name' => trans('theme::admin.form.image'), 'id' => $id.'[discord][img]'])
            @include('admin.components.forms.range', ['name' => trans('theme::admin.form.image_size_height'), 'id' => $id.'[discord][imgHeight]', 'min' => 0, 'max' => 500, 'step' => 1, 'value' => 170])
            @include('admin.components.forms.textaera', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[discord][title]', "wysiwyg" => true, "height" => 200])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[discord][text]'])

            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.form.link')}}</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[discord][link][text]'])
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[discord][link][url]'])
                </div>
            </fieldset>
        </div>
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.video')}}</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[video][title]'])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[video][text]'])
            @include('admin.components.forms.url', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[video][url]'])
        </div>
    </fieldset>
</div>
