<div class="d-flex flex-column gap-5">

    <div class="d-flex flex-column gap-5">
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Taille du texte</legend>
            <div class="d-flex flex-column gap-2">
                @include('admin.components.forms.range', ['name' => '0.5 = normal', 'max' => 1, 'min' => 0, 'step' => 0.01, 'value'=>  0.53, 'id' => $id.'[fontSize]'])
            </div>
        </fieldset>
    </div>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Avis</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.text', ['name' => 'Titre', 'id' => $id.'[title]'])

            <div class="d-flex flex-wrap justify-content-between gap-4 border p-2 w-100">
                @for($i = 1; $i <= 16; $i++)
                    <fieldset class="w-25 d-flex gap-3">
                        <legend class="float-none p-2 py-0 bg-dark text-white text-lg">Avis {{$i}}</legend>
                        <div class="d-flex flex-column gap-2">
                            @include('admin.components.forms.text', ['name' => 'Nom', 'id' => $id.'[players]['.$i.'][name]'])
                            @include('admin.components.forms.text', ['name' => 'Tag', 'id' => $id.'[players]['.$i.'][tag]'])
                            @include('admin.components.forms.text', ['name' => 'Text', 'id' => $id.'[players]['.$i.'][text]'])
                        </div>
                    </fieldset>
                @endfor
            </div>
        </div>
    </fieldset>
</div>
