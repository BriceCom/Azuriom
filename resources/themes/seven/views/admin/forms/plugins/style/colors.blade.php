<div class="p-2 d-flex flex-column gap-5">
    <div class="alert alert-info">{{trans('theme::admin.style.colors.prevent')}}</div>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.style.colors.theme_light')}}</legend>
        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.primary'), 'id' => $id.'[light][primary]', 'value' => '#e22828'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.secondary'), 'id' => $id.'[light][secondary]', 'value' => '#e2b029'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.tertiary'), 'id' => $id.'[light][tertiary]', 'value' => '#f8f8    f8'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.quaternary'), 'id' => $id.'[light][quaternary]', 'value' => '#ECAF2D'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body'), 'id' => $id.'[light][body]', 'value' => '#f2f2f2'])

            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_dark'), 'id' => $id.'[light][black]', 'value' => '#e2e2e2'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_darkness'), 'id' => $id.'[light][dark]', 'value' => '#f2f2f2'])

            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_light'), 'id' => $id.'[light][white]', 'value' => '#a68dc3'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_lightness'), 'id' => $id.'[light][light]', 'value' => '#fafafa'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.text'), 'id' => $id.'[light][color]', 'value' => '#111111'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.text_bg'), 'id' => $id.'[light][color-dark]', 'value' => '#6c757d'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_success'), 'id' => $id.'[light][success]', 'value' => '#198754'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_info'), 'id' => $id.'[light][info]', 'value' => '#0dcaf0'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_warning'), 'id' => $id.'[light][warning]', 'value' => '#ffc107'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_danger'), 'id' => $id.'[light][danger]', 'value' => '#dc3545'])
        </div>
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.style.colors.theme_dark')}}</legend>
        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.primary'), 'id' => $id.'[dark][primary]', 'value' => '#e22828'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.secondary'), 'id' => $id.'[dark][secondary]', 'value' => '#e2b029'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.tertiary'), 'id' => $id.'[dark][tertiary]', 'value' => '#54cbaa'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.quaternary'), 'id' => $id.'[dark][quaternary]', 'value' => '#ECAF2D'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body'), 'id' => $id.'[dark][body]', 'value' => '#212529'])

            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_dark'), 'id' => $id.'[dark][black]', 'value' => '#1a1e21'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_darkness'), 'id' => $id.'[dark][dark]', 'value' => '#191c1f'])

            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_light'), 'id' => $id.'[dark][white]', 'value' => '#21262c'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_lightness'), 'id' => $id.'[dark][light]', 'value' => '#191c1f'])
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
