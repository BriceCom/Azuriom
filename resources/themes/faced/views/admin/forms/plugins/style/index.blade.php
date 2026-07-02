<div class="p-2 d-flex flex-column gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.theme_mode.title')}}</legend>
        <div class="d-flex gap-3">
            @include('admin.components.forms.switch', [
                'id' => $id.'[theme][dark][off]',
                'name' => trans('theme::admin.theme_mode.off')
                ])
            @include('admin.components.forms.switch', [
                'id' => $id.'[theme][dark][prefer]',
                'name' => trans('theme::admin.theme_mode.dark_priority')
                ])
        </div>
    </fieldset>
    <fieldset class="d-flex flex-column gap-3 border border-warning p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">⭐ {{trans('theme::admin.font.title')}}</legend>
        @include('admin.components.forms.switch', [
            'direction' => 'row',
            'id' => $id.'[font][on]',
            'name' => trans('theme::admin.font.on')
        ])
        <div class="d-flex gap-3">
            @include('admin.components.forms.url', [
                'id' => $id.'[font][url]',
                'nameToUpper' => false,
                'name' => strtoupper(trans('theme::admin.font.link_of_font')).' <a target="_blank" href="https://fonts.bunny.net/">'.trans('theme::admin.font.find_custom_font').'</a>',
                'placeholder' => "https://fonts.bunny.net/css?family=poppins:100,200,300,400,500,600,700,700i,800,900&display=swap",
                'class' => 'w-50'
            ])
            @include('admin.components.forms.text', [
                'id' => $id.'[font][name]',
                'nameToUpper' => false,
                'name' => 'Nom de la police',
                'placeholder' => "Poppins",
            ])
        </div>
    </fieldset>
</div>
