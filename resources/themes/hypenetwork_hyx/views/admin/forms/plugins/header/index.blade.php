<div class="d-flex flex-column gap-5 px-2">
    <div class="w-50">
        @include('admin.components.forms.range', ['name' => 'Hauteur image', 'id' => $id.'[img][height]', 'value' => 99,'max' => 250, 'min' => 10, 'step' => 2,])
        @include('admin.components.forms.range', ['name' => 'Marge du haut', 'id' => $id.'[img][marge]', 'value' => 0,'max' => 100, 'min' => 0, 'step' => 1,])
    </div>

    <fieldset class="d-flex flex-column flex-md-row gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">NAVIGATION</legend>
        @for($i = 1; $i <= 5; $i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Lien {{ $i }}</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => 'Texte', 'id' => $id.'[link]['.$i.'][text]', 'placeholder' => 'Discord'])
                    @include('admin.components.forms.text', ['name' => 'Lien', 'id' => $id.'[link]['.$i.'][url]'])
                    @include('admin.components.forms.switch', ['name' => 'Nouvel onglet', 'id' => $id.'[link]['.$i.'][newTab]', 'direction' => 'row'])
                </div>
            </fieldset>
        @endfor
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">HERO</legend>
        <div class="d-flex flex-column gap-4">

            <div class="d-flex gap-3">
                @for($i = 1; $i <= 8; $i++)
                    @include('admin.components.forms.text', ['name' => 'Tag'.$i, 'id' => $id.'[hero][tags]['.$i.'][text]'])
                @endfor
            </div>

            @include('admin.components.forms.text', ['name' => 'Titre', 'id' => $id.'[hero][title]'])

            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Bouton</legend>
                <div class="d-flex flex-column gap-2">
                    @include('admin.components.forms.text', ['name' => 'Texte bouton', 'id' => $id.'[hero][button][text]'])
                    @include('admin.components.forms.text', ['name' => 'Lien bouton', 'id' => $id.'[hero][button][url]'])
                </div>
            </fieldset>
        </div>
    </fieldset>
</div>
