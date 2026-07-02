<div class="p-2 d-flex flex-column gap-3">
    <div class="d-flex flex-wrap gap-3">

        <fieldset class="d-flex w-100 gap-3 border p-2">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Bandeau</legend>
            <div class="w-100 d-flex flex-column gap-3">
                @include('admin.components.forms.text', [
                    'id' => $id.'[bandeau][text]',
                    'name' => "Texte"
                ])
                @include('admin.components.forms.url', [
                    'id' => $id.'[bandeau][url]',
                    'name' => "Lien",
                ])
            </div>
        </fieldset>

        <fieldset class="d-flex w-100 gap-3 border p-2">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">A propos</legend>
            <div class="w-100 d-flex flex-column gap-3">
                @include('admin.components.forms.text', [
                    'id' => $id.'[about][title]',
                    'name' => "Titre",
                    'placeholder' => "A propos"
                ])
                @include('admin.components.forms.textaera', [
                    'id' => $id.'[about][text]',
                    'name' => "Texte",
                ])
            </div>
        </fieldset>

        <fieldset class="row gap-3 border p-2">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS</legend>
            @for($i=1;$i<6;$i++)
                <fieldset class="col-md-5 d-flex flex-column flex-xl-row gap-3 border p-2">
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
        </fieldset>

        <fieldset class="row gap-3 border p-2">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS IMPORTANT</legend>
            @for($i=1;$i<3;$i++)
                <fieldset class="col-md-5 d-flex flex-column flex-lg-row gap-3 border p-2">
                    @include('admin.components.forms.switch', [
                        'direction' => 'row',
                        'id' => $id.'[link-important]['.$i.'][blank]',
                        'name' => "Nouvel onglet"
                    ])
                    <div class='d-flex gap-3'>
                        @include('admin.components.forms.url', ['name' => 'Lien', 'id' => $id.'[link-important]['.$i.'][url]', 'placeholder' => 'https://serveurliste.com'])
                        @include('admin.components.forms.text', ['name' => 'Texte', 'id' => $id.'[link-important]['.$i.'][text]', 'placeholder' => 'Serveurliste'])
                    </div>
                </fieldset>
            @endfor
        </fieldset>
    </div>
</div>
