<x-admin.card :title="trans('theme::admin.menus.home.cta')">
    @include('admin.components.forms.switch', [
          'direction' => 'row',
          'id' => $id.'[on]',
          'name' => trans('theme::admin.enable')
      ])

    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.icon'), 'id' => $id.'[icon]', 'icon' => true, 'placeholder' => 'bi bi-megaphone'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])

    <x-admin.fieldset :title="trans('theme::admin.form.button')">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[link][text]'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[link][url]'])
    </x-admin.fieldset>
</x-admin.card>
