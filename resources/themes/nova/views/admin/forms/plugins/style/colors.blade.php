@php
    $colorPresetScopeId = str_replace(['[', '-', ']'], ['_', '_', ''], ($id ?? 'style_colors')).'_preset_scope';

    $colorPresets = [
        'Default' => [
            'light' => [
                'primary' => '#00B7FF',
                'secondary' => '#c8cccd',
                'tertiary' => '#F8CA47',
                'quaternary' => '#ECAF2D',
                'body' => '#f2f2f2',
                'black' => '#e2e2e2',
                'dark' => '#e3e2e2',
                'white' => '#a68dc3',
                'light' => '#fafafa',
                'color' => '#111111',
                'color-dark' => '#f2f2f2',
                'success' => '#BBF24B',
                'info' => '#0dcaf0',
                'warning' => '#F88934',
                'danger' => '#dc3545',
            ],
            'dark' => [
                'primary' => '#00B7FF',
                'secondary' => '#3E404D',
                'tertiary' => '#F8CA47',
                'quaternary' => '#FF6CBA',
                'body' => '#111111',
                'black' => '#070606',
                'dark' => '#17191B',
                'white' => '#21262c',
                'light' => '#111111',
                'color' => '#ffffff',
                'color-dark' => '#6c757d',
                'success' => '#BBF24B',
                'info' => '#3499F8',
                'warning' => '#ffc107',
                'danger' => '#dc3545',
            ],
        ],
        'Ocean' => [
            'light' => [
                'primary' => '#00A6FB',
                'secondary' => '#B8C6DB',
                'tertiary' => '#38BDF8',
                'quaternary' => '#0EA5E9',
                'body' => '#F0F7FF',
                'black' => '#DDE9F8',
                'dark' => '#C8DAF0',
                'white' => '#9DB4D6',
                'light' => '#FAFDFF',
                'color' => '#0C2740',
                'color-dark' => '#EAF3FF',
                'success' => '#22C55E',
                'info' => '#0EA5E9',
                'warning' => '#F59E0B',
                'danger' => '#E11D48',
            ],
            'dark' => [
                'primary' => '#38BDF8',
                'secondary' => '#2A3445',
                'tertiary' => '#22D3EE',
                'quaternary' => '#0EA5E9',
                'body' => '#0B1220',
                'black' => '#050A14',
                'dark' => '#111C30',
                'white' => '#223149',
                'light' => '#0F172A',
                'color' => '#E2EDFF',
                'color-dark' => '#8FA4C7',
                'success' => '#22C55E',
                'info' => '#38BDF8',
                'warning' => '#F59E0B',
                'danger' => '#F43F5E',
            ],
        ],
        'Sunset' => [
            'light' => [
                'primary' => '#F97316',
                'secondary' => '#F3D6C6',
                'tertiary' => '#FDBA74',
                'quaternary' => '#FB7185',
                'body' => '#FFF7F2',
                'black' => '#FFEBDD',
                'dark' => '#FFD9C4',
                'white' => '#F2B8A0',
                'light' => '#FFFDFC',
                'color' => '#3D1608',
                'color-dark' => '#FFF2EA',
                'success' => '#84CC16',
                'info' => '#38BDF8',
                'warning' => '#F59E0B',
                'danger' => '#EF4444',
            ],
            'dark' => [
                'primary' => '#FB923C',
                'secondary' => '#4A3230',
                'tertiary' => '#F59E0B',
                'quaternary' => '#EC4899',
                'body' => '#1B1110',
                'black' => '#120A09',
                'dark' => '#2A1714',
                'white' => '#3B2422',
                'light' => '#201513',
                'color' => '#FFE9DC',
                'color-dark' => '#BFA29A',
                'success' => '#A3E635',
                'info' => '#38BDF8',
                'warning' => '#FBBF24',
                'danger' => '#F87171',
            ],
        ],
        'Forest' => [
            'light' => [
                'primary' => '#16A34A',
                'secondary' => '#D1E7D6',
                'tertiary' => '#84CC16',
                'quaternary' => '#15803D',
                'body' => '#F4FBF4',
                'black' => '#E5F3E5',
                'dark' => '#D6EAD6',
                'white' => '#A5D6A7',
                'light' => '#FBFEFB',
                'color' => '#12301C',
                'color-dark' => '#F1F8F1',
                'success' => '#22C55E',
                'info' => '#06B6D4',
                'warning' => '#EAB308',
                'danger' => '#DC2626',
            ],
            'dark' => [
                'primary' => '#22C55E',
                'secondary' => '#33443A',
                'tertiary' => '#84CC16',
                'quaternary' => '#16A34A',
                'body' => '#0F1812',
                'black' => '#09100B',
                'dark' => '#17251B',
                'white' => '#25372A',
                'light' => '#111A14',
                'color' => '#E9F7EC',
                'color-dark' => '#9FB7A6',
                'success' => '#4ADE80',
                'info' => '#22D3EE',
                'warning' => '#EAB308',
                'danger' => '#F87171',
            ],
        ],
        'Royal' => [
            'light' => [
                'primary' => '#6366F1',
                'secondary' => '#D8DBF7',
                'tertiary' => '#A78BFA',
                'quaternary' => '#8B5CF6',
                'body' => '#F5F6FF',
                'black' => '#E7E9FA',
                'dark' => '#D9DDF7',
                'white' => '#B3B6E3',
                'light' => '#FCFCFF',
                'color' => '#1B1F4F',
                'color-dark' => '#F1F2FF',
                'success' => '#22C55E',
                'info' => '#60A5FA',
                'warning' => '#F59E0B',
                'danger' => '#EF4444',
            ],
            'dark' => [
                'primary' => '#818CF8',
                'secondary' => '#313550',
                'tertiary' => '#A78BFA',
                'quaternary' => '#C084FC',
                'body' => '#101225',
                'black' => '#070918',
                'dark' => '#1A1E35',
                'white' => '#2A2F4A',
                'light' => '#111329',
                'color' => '#E8E9FF',
                'color-dark' => '#9DA3CF',
                'success' => '#4ADE80',
                'info' => '#60A5FA',
                'warning' => '#FBBF24',
                'danger' => '#FB7185',
            ],
        ],
        'Neon' => [
            'light' => [
                'primary' => '#00E5FF',
                'secondary' => '#D0F7FA',
                'tertiary' => '#A3FF12',
                'quaternary' => '#FF2AD4',
                'body' => '#F3FFFF',
                'black' => '#E1FCFD',
                'dark' => '#CBF7F9',
                'white' => '#A8E9EE',
                'light' => '#FBFFFF',
                'color' => '#052D33',
                'color-dark' => '#E8FDFF',
                'success' => '#2EFF7E',
                'info' => '#00E5FF',
                'warning' => '#FFD600',
                'danger' => '#FF4D6D',
            ],
            'dark' => [
                'primary' => '#00E5FF',
                'secondary' => '#24434A',
                'tertiary' => '#A3FF12',
                'quaternary' => '#FF2AD4',
                'body' => '#060E11',
                'black' => '#020607',
                'dark' => '#0C181C',
                'white' => '#17333A',
                'light' => '#081216',
                'color' => '#E6FFFF',
                'color-dark' => '#8CB6BF',
                'success' => '#2EFF7E',
                'info' => '#22D3EE',
                'warning' => '#FACC15',
                'danger' => '#FF5C8A',
            ],
        ],
        'Monochrome' => [
            'light' => [
                'primary' => '#1F2937',
                'secondary' => '#D1D5DB',
                'tertiary' => '#6B7280',
                'quaternary' => '#374151',
                'body' => '#F9FAFB',
                'black' => '#E5E7EB',
                'dark' => '#D1D5DB',
                'white' => '#9CA3AF',
                'light' => '#FFFFFF',
                'color' => '#111827',
                'color-dark' => '#F3F4F6',
                'success' => '#10B981',
                'info' => '#3B82F6',
                'warning' => '#F59E0B',
                'danger' => '#EF4444',
            ],
            'dark' => [
                'primary' => '#E5E7EB',
                'secondary' => '#374151',
                'tertiary' => '#9CA3AF',
                'quaternary' => '#D1D5DB',
                'body' => '#111827',
                'black' => '#030712',
                'dark' => '#1F2937',
                'white' => '#4B5563',
                'light' => '#1A2233',
                'color' => '#F9FAFB',
                'color-dark' => '#9CA3AF',
                'success' => '#34D399',
                'info' => '#60A5FA',
                'warning' => '#FBBF24',
                'danger' => '#F87171',
            ],
        ],
    ];
@endphp

<x-admin.card :title="trans('theme::admin.menus.style.colors')">
    <div id="{{ $colorPresetScopeId }}">
        <div class="alert alert-info">{{trans('theme::admin.style.colors.prevent')}}</div>

        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
            <span class="fw-bold">Presets :</span>
            @foreach($colorPresets as $presetName => $presetValues)
                <button type="button" class="btn btn-sm btn-outline-primary js-color-preset" data-preset="{{ $presetName }}">
                    {{ $presetName }}
                </button>
            @endforeach
        </div>

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
            @include('admin.components.forms.color', ['name' => trans('theme::admin.style.colors.primary'), 'id' => $id.'[dark][primary]', 'value' => '#00B7FF'])
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
    </div>
</x-admin.card>

@push('footer-scripts')
    <script>
        (() => {
            const presetScope = document.getElementById(@json($colorPresetScopeId));

            if (!presetScope) {
                return;
            }

            const presets = @json($colorPresets);
            const inputRoot = @json($id);

            const applyColor = (input, color) => {
                if (!input || typeof color !== 'string') {
                    return;
                }

                input.value = color;
                input.setAttribute('value', color);
                input.dispatchEvent(new Event('input', {bubbles: true}));
                input.dispatchEvent(new Event('change', {bubbles: true}));
            };

            const applyPreset = (preset) => {
                ['light', 'dark'].forEach((themeMode) => {
                    const values = preset[themeMode] || {};

                    Object.entries(values).forEach(([key, color]) => {
                        const inputName = `${inputRoot}[${themeMode}][${key}]`;
                        const targetInput = document.getElementsByName(inputName)[0];

                        applyColor(targetInput, color);
                    });
                });
            };

            presetScope.querySelectorAll('.js-color-preset').forEach((button) => {
                button.addEventListener('click', () => {
                    const presetName = button.dataset.preset;

                    if (!presetName || !presets[presetName]) {
                        return;
                    }

                    applyPreset(presets[presetName]);
                });
            });
        })();
    </script>
@endpush
