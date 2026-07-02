<div class="p-2 d-flex flex-column flex-md-row gap-3">

    <div class="d-flex flex-wrap gap-3">
        <fieldset class="d-flex flex-column gap-3 border border-warning p-2">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">⭐ {{trans('theme::admin.header.module.announceBar.name')}}</legend>
                @include('admin.components.forms.switch', [
                'direction' => 'row',
                'id' => $id.'[announceBar][on]',
                'name' => trans('theme::admin.active')
            ])
            <div>
                @include('admin.components.forms.textaera', [
                    'id' => $id.'[announceBar][text]',
                    'wysiwyg' => true,
                    'name' => trans('theme::admin.header.module.announceBar.text'),
                ])
            </div>
            <div class="d-flex gap-3">
                @include('admin.components.forms.color', ['name' => trans('theme::admin.header.module.announceBar.bg'), 'id' => $id.'[announceBar][bg]', 'value' => '#892958'])
            </div>
        </fieldset>
    </div>

    <div class="d-flex flex-wrap gap-3">
        <fieldset class="d-flex flex-column gap-3 border border-warning p-2">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">⭐ {{trans('theme::admin.header.module.pageHeight.name')}}</legend>
                @include('admin.components.forms.switch', [
                'direction' => 'row',
                'id' => $id.'[pageHeight][on]',
                'name' => trans('theme::admin.active')
            ])
            <div>
                @include('admin.components.forms.range', [
                    'id' => $id.'[pageHeight][height]',
                    'step' => 1,
                    'min' => 1,
                    'max' => 16,
                    'value' => 8,
                    'name' => trans('theme::admin.header.module.pageHeight.height'),
                ])
            </div>
            <div class="d-flex gap-3">
                @include('admin.components.forms.color', ['name' => trans('theme::admin.header.module.pageHeight.colorBg'), 'id' => $id.'[pageHeight][colorBg]', 'value' => '#6c5e8f'])
                @include('admin.components.forms.color', ['name' => trans('theme::admin.header.module.pageHeight.color'), 'id' => $id.'[pageHeight][color]', 'value' => '#531cdb'])
            </div>
        </fieldset>
    </div>
</div>
