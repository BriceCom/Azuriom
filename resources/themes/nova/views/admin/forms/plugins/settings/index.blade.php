<x-admin.card :title="trans('theme::admin.particles.title')">
    <div class="alert alert-info">{{ trans('theme::admin.particles.description') }}</div>

    <x-admin.fieldset :title="trans('theme::admin.particles.general')" class="flex-column">
        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.switch', [
                'id' => $id.'[particles][enabled]',
                'name' => trans('theme::admin.particles.enabled')
            ])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.number', [
                'id' => $id.'[particles][count]',
                'name' => trans('theme::admin.particles.count'),
                'min' => 10,
                'step' => 10,
                'max' => 200,
                'value' => 50
            ])

            @include('admin.components.forms.number', [
                'id' => $id.'[particles][density]',
                'name' => trans('theme::admin.particles.density'),
                'help' => trans('theme::admin.particles.density_help'),
                'min' => 400,
                'max' => 2000,
                'step' => 50,
                'value' => 800
            ])
        </div>
    </x-admin.fieldset>

    <x-admin.fieldset :title="trans('theme::admin.particles.appearance')" class="flex-column">
        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.image-azuriom', [
                'name' => trans('theme::admin.particles.image'),
                'id' => $id.'[particles][image]'
            ])
        </div>

        <div class="d-flex flex-wrap gap-3">
            @include('admin.components.forms.number', [
                'id' => $id.'[particles][speed]',
                'name' => trans('theme::admin.particles.speed'),
                'min' => 1,
                'max' => 10,
                'step' => 0.5,
                'value' => 3
            ])

            @include('admin.components.forms.number', [
                'id' => $id.'[particles][size]',
                'name' => trans('theme::admin.particles.size'),
                'min' => 1,
                'max' => 10,
                'step' => 0.5,
                'value' => 3
            ])
        </div>
    </x-admin.fieldset>
</x-admin.card>
