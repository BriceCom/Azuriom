<x-admin.card :title="trans('theme::admin.header.module.announceBar.name')" :advanced="true">
    @include('admin.components.forms.switch', [
                   'direction' => 'row',
                   'id' => $id.'[announceBar][on]',
                   'name' => trans('theme::admin.active')
               ])

    @include('admin.components.forms.textarea', [
                    'id' => $id.'[announceBar][text]',
                    'wysiwyg' => true,
                    'name' => trans('theme::admin.header.module.announceBar.text'),
                ])

    @include('admin.components.forms.color', ['name' => trans('theme::admin.header.module.announceBar.bg'), 'id' => $id.'[announceBar][bg]', 'value' => '#892958'])
</x-admin.card>

<x-admin.card :title="trans('theme::admin.header.module.pageHeight.name')" :advanced="true">
    @include('admin.components.forms.switch', [
                'direction' => 'row',
                'id' => $id.'[pageHeight][on]',
                'name' => trans('theme::admin.active')
            ])

    @include('admin.components.forms.range', [
                    'id' => $id.'[pageHeight][height]',
                    'step' => 1,
                    'min' => 1,
                    'max' => 16,
                    'value' => 8,
                    'name' => trans('theme::admin.header.module.pageHeight.height'),
                ])

    <div class="d-flex gap-3">
        @include('admin.components.forms.color', ['name' => trans('theme::admin.header.module.pageHeight.colorBg'), 'id' => $id.'[pageHeight][colorBg]', 'value' => '#6c5e8f'])
        @include('admin.components.forms.color', ['name' => trans('theme::admin.header.module.pageHeight.color'), 'id' => $id.'[pageHeight][color]', 'value' => '#531cdb'])
    </div>
</x-admin.card>
