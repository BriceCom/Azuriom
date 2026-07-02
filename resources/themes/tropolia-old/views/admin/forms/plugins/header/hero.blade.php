@include('admin.components.forms.text', ['name' => trans('theme::admin.form.joinText'), 'placeholder' => "Join {server_online} players !", 'id' => $id.'[joinText]'])

<fieldset class="d-flex flex-column gap-3 border border p-2 mt-4">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Carousel</legend>
    @for($i=0;$i<=5;$i++)
        @include('admin.components.forms.image-azuriom', ['name' => trans('theme::admin.form.image'), 'id' => $id.'[carousel]['.$i.']'])
    @endfor
</fieldset>
