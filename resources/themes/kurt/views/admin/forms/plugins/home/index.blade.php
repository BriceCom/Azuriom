<div class="p-2 d-flex flex-column gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.gap_between_blocks')}}</legend>
        @include('admin.components.forms.range', ['name' => trans('theme::admin.pixel'), 'id' => $id.'[gap]', 'value' => 248,'max' => 526, 'min' => 16, 'step' => 1])

    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.home.news')}}</legend>
        @include('admin.components.forms.switch', [
            'direction' => 'row',
            'id' => $id.'[news][off]',
            'name' => trans('theme::admin.disable')
        ])
    </fieldset>
</div>
