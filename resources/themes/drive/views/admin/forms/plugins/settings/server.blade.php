<x-admin.card :title="trans('theme::admin.menus.settings.server')">
    @include('admin.components.forms.switch', [
        'direction' => 'row',
        'id' => $id.'[launcher][on]',
        'name' => trans('theme::admin.server_with_launcher')
    ])

    @include('admin.components.forms.text', [
            'id' => $id.'[url]',
            'name' => trans('theme::admin.form.link_of_page_to_download_launcher')
     ])

    <div class="d-flex flex-wrap gap-3">
        @include('admin.components.forms.text', [
            'id' => $id.'[text]',
            'name' => trans('theme::admin.form.button_text')
        ])

    @include('admin.components.forms.text', [
            'id' => $id.'[ip]',
            'name' => trans('theme::admin.server_address_ip')
        ])
    </div>
</x-admin.card>
