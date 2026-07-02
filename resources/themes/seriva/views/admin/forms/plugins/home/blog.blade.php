<x-admin.card :title="trans('theme::admin.menus.home.blog')">
    @include('admin.components.forms.switch', [
        'direction' => 'row',
        'id' => $id.'[off]',
        'name' => trans('theme::admin.disable')
    ])

    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.all_articles_label'), 'id' => $id.'[all_articles]'])

    <x-admin.fieldset :title="trans('theme::admin.form.placeholder_card_1')">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[placeholder_1_title]'])
        @include('admin.components.forms.textarea', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[placeholder_1_text]'])
    </x-admin.fieldset>

    <x-admin.fieldset :title="trans('theme::admin.form.placeholder_card_2')">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[placeholder_2_title]'])
        @include('admin.components.forms.textarea', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[placeholder_2_text]'])
    </x-admin.fieldset>
</x-admin.card>
