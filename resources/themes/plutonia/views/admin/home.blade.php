@for($i = 1; $i <= $amount; $i++)
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Slider {{$i}}</legend>
        <div class="d-flex flex-column gap-2">
            @include('components.forms.textaera', ['name' => 'Texte Slider '.$i, 'id' => $id.'[slider]['.$i.'][text]'])
            @include('components.forms.image-azuriom', ['name' => 'Image Slider '.$i, 'id' => $id.'[slider]['.$i.'][image]'])
        </div>
    </fieldset>
@endfor

