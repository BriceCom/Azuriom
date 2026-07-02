<div class="p-2 d-flex flex-column gap-3">
    <div class="d-flex flex-wrap gap-3">
        <div class="col-lg-6 d-flex gap-3">
            @include('admin.components.forms.image-azuriom', ['name' => 'Logo', 'id' => $id.'[logo][url]'])
            @include('admin.components.forms.range', ['name' => 'Taille en hauteur', 'id' => $id.'[logo][height]', 'value' => 121,'max' => 300, 'min' => 0, 'step' => 1])
        </div>

            @for($i=1;$i<6;$i++)
            <fieldset class="d-flex flex-column flex-md-row gap-3 border p-2 w-50">

                @include('admin.components.forms.switch', [
                    'direction' => 'row',
                    'id' => $id.'[link]['.$i.'][blank]',
                    'name' => "Nouvel onglet"
                ])
                <div class='d-flex gap-3'>
                    @include('admin.components.forms.url', ['name' => 'Lien', 'id' => $id.'[link]['.$i.'][url]', 'placeholder' => 'https://serveurliste.com'])
                    @include('admin.components.forms.text', ['name' => 'Texte', 'id' => $id.'[link]['.$i.'][text]', 'placeholder' => 'Serveurliste'])
                </div>
            </fieldset>

        @endfor</div>
</div>
