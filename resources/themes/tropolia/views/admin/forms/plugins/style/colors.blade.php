<div class="p-2 d-flex flex-column gap-5">
    <div class="alert alert-info">{{trans('theme::admin.style.colors.prevent')}}</div>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.style.colors.theme_dark')}}</legend>
        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.primary'), 'id' => $id.'[dark][primary]', 'value' => '#4CAF50'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.secondary'), 'id' => $id.'[dark][secondary]', 'value' => '#757575'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.tertiary'), 'id' => $id.'[dark][tertiary]', 'value' => '#FCA500'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.quaternary'), 'id' => $id.'[dark][quaternary]', 'value' => '#D96D3C'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body'), 'id' => $id.'[dark][body]', 'value' => '#0B0907'])

            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_dark'), 'id' => $id.'[dark][black]', 'value' => '#111111'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_darkness'), 'id' => $id.'[dark][dark]', 'value' => '#111111'])

            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_light'), 'id' => $id.'[dark][white]', 'value' => '#ffffff'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_lightness'), 'id' => $id.'[dark][light]', 'value' => '#1E1E1E'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.text'), 'id' => $id.'[dark][color]', 'value' => '#ffffff'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.text_bg'), 'id' => $id.'[dark][color-dark]', 'value' => '#6c757d'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_success'), 'id' => $id.'[dark][success]', 'value' => '#198754'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_info'), 'id' => $id.'[dark][info]', 'value' => '#0dcaf0'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_warning'), 'id' => $id.'[dark][warning]', 'value' => '#ffc107'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_danger'), 'id' => $id.'[dark][danger]', 'value' => '#dc3545'])
        </div>
    </fieldset>
</div>
