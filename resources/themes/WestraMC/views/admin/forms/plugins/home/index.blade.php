<div class="p-2 d-flex flex-column gap-3">
    <div class="row container gap-md-3">
        <div class="col-lg-6 d-flex gap-3">
            @include('admin.components.forms.image-azuriom', ['name' => 'Image discord', 'id' => $id.'[discord][image][url]'])
            @include('admin.components.forms.range', ['name' => 'Taille en hauteur', 'id' => $id.'[discord][image][height]', 'value' => 210,'max' => 600, 'min' => 0, 'step' => 1])
        </div>
    </div>

    @for($i=1;$i<=3;$i++)
        <fieldset class="d-flex flex-column flex-md-row gap-3 border p-2 w-50">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">En savoir plus {{$i}}</legend>
            <div class='d-flex gap-3'>
                @include('admin.components.forms.text', ['name' => 'Icon bootstrap', 'id' => $id.'[more]['.$i.'][icon]', 'placeholder' => 'bi bi-person'])
                @include('admin.components.forms.text', ['name' => 'Titre', 'id' => $id.'[more]['.$i.'][title]', 'placeholder' => 'Mon Titre'])
                @include('admin.components.forms.text', ['name' => 'Texte', 'id' => $id.'[more]['.$i.'][text]', 'placeholder' => 'Paragraphe'])
            </div>
        </fieldset>
    @endfor
</div>
