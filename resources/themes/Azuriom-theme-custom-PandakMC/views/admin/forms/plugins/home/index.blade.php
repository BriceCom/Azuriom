<fieldset class="p-2 d-flex flex-column gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">GENERAL</legend>

        <div class="d-flex flex-column flex-md-row gap-2">
            @include('admin.components.forms.text', ['name' => 'ID Discord', 'id' => $id.'[discord][id]'])
            @include('admin.components.forms.text', ['name' => 'Lien Discord', 'id' => $id.'[discord][link]'])
        </div>

        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.text', ['name' => 'Ip du serveur', 'id' => $id.'[ip][text]'])
        </div>
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">NOUS REJOINDRE</legend>

        @include('admin.components.forms.textaera', ['name' => 'Titre', 'id' => $id.'[howjoin][title]', 'wysiwyg' => true, 'height' => '38'])
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">STATISTIQUES</legend>

        @for($i=1; $i<=2; $i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Stats {{$i}}</legend>
                @include('admin.components.forms.text', ['name' => 'Titre', 'id' => $id.'[stats]['.$i.'][title]'])
                @include('admin.components.forms.text', ['name' => 'Texte', 'id' => $id.'[stats]['.$i.'][text]'])
            </fieldset>
        @endfor

        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Stats Discord</legend>
            @include('admin.components.forms.text', ['name' => 'Nombre', 'id' => $id.'[stats][discord][title]'])
            @include('admin.components.forms.text', ['name' => 'Texte', 'id' => $id.'[stats][discord][text]'])
        </fieldset>

    </fieldset>
</fieldset>
