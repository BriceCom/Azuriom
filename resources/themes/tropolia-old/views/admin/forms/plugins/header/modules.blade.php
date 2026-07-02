<div class="p-2 d-flex flex-column flex-md-row gap-3">
    <div class="d-flex flex-wrap gap-3">
        <fieldset class="d-flex flex-column gap-3 border border p-2">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.header.module.announceBar.name')}}</legend>
                @include('admin.components.forms.switch', [
                'direction' => 'row',
                'id' => $id.'[announceBar][on]',
                'name' => trans('theme::admin.active')
            ])
            <div>
                @include('admin.components.forms.textarea', [
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
</div>
