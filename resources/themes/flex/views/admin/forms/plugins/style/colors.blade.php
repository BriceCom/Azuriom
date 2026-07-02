<x-admin.card :title="trans('theme::admin.menus.style.colors')">
    <div class="alert alert-info">{{trans('theme::admin.style.colors.prevent')}}</div>

    <x-admin.fieldset :title="trans('theme::admin.style.colors.theme_light')" class="flex-column">
        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.primary'), 'id' => $id.'[light][primary]', 'value' => '#00B7FF'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.secondary'), 'id' => $id.'[light][secondary]', 'value' => '#c8cccd'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.tertiary'), 'id' => $id.'[light][tertiary]', 'value' => '#F8CA47'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.quaternary'), 'id' => $id.'[light][quaternary]', 'value' => '#ECAF2D'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body'), 'id' => $id.'[light][body]', 'value' => '#f2f2f2'])

            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_dark'), 'id' => $id.'[light][black]', 'value' => '#e2e2e2'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_darkness'), 'id' => $id.'[light][dark]', 'value' => '#e3e2e2'])

            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_light'), 'id' => $id.'[light][white]', 'value' => '#a68dc3'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_lightness'), 'id' => $id.'[light][light]', 'value' => '#fafafa'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.text'), 'id' => $id.'[light][color]', 'value' => '#111111'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.text_bg'), 'id' => $id.'[light][color-dark]', 'value' => '#f2f2f2'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_success'), 'id' => $id.'[light][success]', 'value' => '#BBF24B'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_info'), 'id' => $id.'[light][info]', 'value' => '#0dcaf0'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_warning'), 'id' => $id.'[light][warning]', 'value' => '#F88934'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_danger'), 'id' => $id.'[light][danger]', 'value' => '#dc3545'])
        </div>
    </x-admin.fieldset>

    <x-admin.fieldset :title="trans('theme::admin.style.colors.theme_dark')" class="flex-column">
        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.primary'), 'id' => $id.'[dark][primary]', 'value' => '#F4C438'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.secondary'), 'id' => $id.'[dark][secondary]', 'value' => '#3E404D'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.tertiary'), 'id' => $id.'[dark][tertiary]', 'value' => '#F8CA47'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.quaternary'), 'id' => $id.'[dark][quaternary]', 'value' => '#FF6CBA'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body'), 'id' => $id.'[dark][body]', 'value' => '#111111'])

            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_dark'), 'id' => $id.'[dark][black]', 'value' => '#070606'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_darkness'), 'id' => $id.'[dark][dark]', 'value' => '#17191B'])

            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_light'), 'id' => $id.'[dark][white]', 'value' => '#21262c'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.bg_body_lightness'), 'id' => $id.'[dark][light]', 'value' => '#111111'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.text'), 'id' => $id.'[dark][color]', 'value' => '#ffffff'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.text_bg'), 'id' => $id.'[dark][color-dark]', 'value' => '#6c757d'])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_success'), 'id' => $id.'[dark][success]', 'value' => '#BBF24B'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_info'), 'id' => $id.'[dark][info]', 'value' => '#3499F8'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_warning'), 'id' => $id.'[dark][warning]', 'value' => '#ffc107'])
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.alert_danger'), 'id' => $id.'[dark][danger]', 'value' => '#dc3545'])
        </div>
    </x-admin.fieldset>

</x-admin.card>
