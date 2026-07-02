<fieldset class="p-2 d-flex flex-column gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">TAG</legend>
        @include('admin.components.forms.text', ['name' => 'Tag top acheteur', 'id' => $id.'[tag]'])
        <p class="text-danger">Activez le paramètre dans le plugin boutique pour afficher le top acheteur</p>
    </fieldset>
</fieldset>

<fieldset class="p-2 d-flex flex-column gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">ARTICLE</legend>
        @include('admin.components.forms.image-azuriom', ['name' => 'Image article', 'id' => $id.'[art-image]'])
    </fieldset>
</fieldset>


<fieldset class="p-2 d-flex flex-column gap-3">
    <fieldset class="d-flex flex-row flex-wrap gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">OFFRES</legend>

        @for($i=1; $i<=10; $i++)
            <fieldset class="w-25 d-flex flex-column gap-3 border p-2">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Article boutique {{$i}}</legend>
                @include('admin.components.forms.text', ['name' => "Texte ".$i, 'id' => $id.'[offer]['.$i.'][text]'])
                @include('admin.components.forms.color', ['name' => "Couleur ".$i, 'id' => $id.'[offer]['.$i.'][hex]', 'value' => '#ff0000'])
            </fieldset>
        @endfor
    </fieldset>
</fieldset>
