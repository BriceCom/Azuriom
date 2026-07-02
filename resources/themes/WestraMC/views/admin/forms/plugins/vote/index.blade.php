<div class="p-2 d-flex flex-column gap-3">
    <div class="row container gap-md-3">
        <div class="col-lg-6 d-flex gap-3">
            @include('admin.components.forms.image-azuriom', ['name' => 'Image vote', 'id' => $id.'[hero][image][url]'])
            @include('admin.components.forms.range', ['name' => 'Taille en hauteur', 'id' => $id.'[hero][image][height]', 'value' => 210,'max' => 600, 'min' => 0, 'step' => 1])
        </div>
    </div>

    <div class="row gap-3">
        @for($i=1;$i<=6;$i++)
            <fieldset class="col-md-5 d-flex flex-column flex-md-row gap-3 border p-2">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Image site de vote {{$i}}</legend>
                <div class='d-flex gap-3'>
                    @include('admin.components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[site]['.$i.'][image][url]'])
                </div>
            </fieldset>
        @endfor
    </div>
</div>
