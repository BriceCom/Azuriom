<div class="p-2 d-flex flex-column gap-3">
    <div class="d-flex flex-wrap gap-3">

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">A propos</legend>
        @include('admin.components.forms.text', ['name' => 'Paragraphe', 'id' => $id.'[about_us][paragraph]'])
    </fieldset>


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

    @endfor


    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Boutton</legend>
        @include('admin.components.forms.text', ['name' => 'Text', 'id' => $id.'[button][text]'])
        @include('admin.components.forms.text', ['name' => 'Lien', 'id' => $id.'[button][link]'])
    </fieldset>
    </div>

</div>
