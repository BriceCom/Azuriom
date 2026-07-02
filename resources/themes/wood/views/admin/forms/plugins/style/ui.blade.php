<div class="p-2 d-flex flex-column gap-3">

    <div class="d-flex flex-wrap gap-3">
        <fieldset class="d-flex flex-column gap-3 border p-2 w-50">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.style.ui.borderRadius.name')}}</legend>
            @include('admin.components.forms.range', ['name' => trans('theme::admin.pixel'), 'id' => $id.'[card][borderRadius]', 'value' => 0,'max' => 100, 'min' => 0, 'step' => 2])

            <div>
                <small>{{trans('theme::admin.preview')}} {{trans('theme::admin.no_exhaustif')}}</small>

                <div id="style_ui_borderRadius_radius_preview" class="card overflow-hidden border">
                    <div class="card-header">Title</div>
                    <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi, velit.
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>

<script>
    const radius = document.getElementById('style_ui_card_borderRadius')
    const preview = document.getElementById('style_ui_borderRadius_radius_preview')

    preview.style.borderRadius = "{{theme_config('style.ui.card.borderRadius')}}px"
    radius.addEventListener('input', () => {
        preview.style.borderRadius = radius.value + 'px'
    })

</script>
