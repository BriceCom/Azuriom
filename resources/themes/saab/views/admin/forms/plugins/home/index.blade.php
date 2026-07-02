<div class="p-2 d-flex flex-column gap-3">
    <fieldset class="d-flex w-100 gap-3 border p-2">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Trailer</legend>
        @include('admin.components.forms.text', [
                       'id' => $id.'[trailer][title]',
                       'name' => "Titre",
                       'placeholder' => "Plongez dans notre trailer",
                   ])
        @include('admin.components.forms.text', [
                            'id' => $id.'[trailer][subtitle]',
                            'name' => "Sous-titre"
                    ])
        @include('admin.components.forms.url', [
                            'id' => $id.'[trailer][url]',
                            'name' => "Lien du trailer"
                    ])
    </fieldset>
    <fieldset class="d-flex w-100 gap-3 border p-2">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Article</legend>
        @include('admin.components.forms.text', [
                       'id' => $id.'[article][title]',
                       'name' => "Titre",
                       'placeholder' => "Nos derniers articles",
                   ])
        @include('admin.components.forms.text', [
                            'id' => $id.'[article][subtitle]',
                            'name' => "Sous-titre"
                    ])
    </fieldset>
</div>
