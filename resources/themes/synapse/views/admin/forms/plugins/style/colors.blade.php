<div class="p-2 d-flex flex-column gap-5">
{{--    <div class="alert alert-info">{{trans('theme::admin.style.colors.prevent')}}</div>--}}

{{--    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">--}}
{{--        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.style.colors.theme_light')}}</legend>--}}
{{--        <div class="d-flex flex-wrap gap-3">--}}
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.primary'), 'id' => $id.'[light][primary]', 'value' => '#0d6efd'])--}}
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.secondary'), 'id' => $id.'[light][secondary]', 'value' => '#6c757d'])--}}
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.tertiary'), 'id' => $id.'[light][tertiary]', 'value' => '#54cbaa'])--}}
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.quaternary'), 'id' => $id.'[light][quaternary]', 'value' => '#9344e7'])--}}
{{--        </div>--}}

{{--        <div class="d-flex flex-wrap gap-3">--}}
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body'), 'id' => $id.'[light][body]', 'value' => '#212529'])--}}

{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_dark'), 'id' => $id.'[light][black]', 'value' => '#000000'])--}}
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_darkness'), 'id' => $id.'[light][dark]', 'value' => '#212529'])--}}

{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_light'), 'id' => $id.'[light][white]', 'value' => '#ffffff'])--}}
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_lightness'), 'id' => $id.'[light][light]', 'value' => '#f8f9fa'])--}}
{{--        </div>--}}

{{--        <div class="d-flex flex-wrap gap-3">--}}
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.text'), 'id' => $id.'[light][color]', 'value' => '#ffffff'])--}}
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.text_bg'), 'id' => $id.'[light][color-dark]', 'value' => '#6c757d'])--}}
{{--        </div>--}}

{{--        <div class="d-flex flex-wrap gap-3">--}}
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_success'), 'id' => $id.'[light][success]', 'value' => '#198754'])--}}
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_info'), 'id' => $id.'[light][info]', 'value' => '#0dcaf0'])--}}
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_warning'), 'id' => $id.'[light][warning]', 'value' => '#ffc107'])--}}
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_danger'), 'id' => $id.'[light][danger]', 'value' => '#dc3545'])--}}
{{--        </div>--}}
{{--    </fieldset>--}}

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.style.colors.theme_dark')}}</legend>
        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.primary'), 'id' => $id.'[dark][primary]', 'value' => '#E2A218'])
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.secondary'), 'id' => $id.'[dark][secondary]', 'value' => '#6c757d'])--}}
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.tertiary'), 'id' => $id.'[dark][tertiary]', 'value' => '#FFF883'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body'), 'id' => $id.'[dark][body]', 'value' => '#212529'])
        </div>

        <div class="d-flex flex-wrap gap-3">
{{--            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.text'), 'id' => $id.'[dark][color]', 'value' => '#ffffff'])--}}
        </div>
    </fieldset>
</div>
