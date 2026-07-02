<div class="p-2 d-flex flex-column flex-md-row gap-3">
    @for($i = 1; $i <= 2; $i++)
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Lien {{ $i }}</legend>
            <div class="d-flex flex-column gap-2">
                @include('admin.components.forms.text', ['name' => 'Texte', 'id' => $id.'[linksLeft]['.$i.'][text]'])
                @include('admin.components.forms.text', ['name' => 'Lien', 'id' => $id.'[linksLeft]['.$i.'][url]'])
            </div>
        </fieldset>
    @endfor
</div>
