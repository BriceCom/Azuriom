<div class="p-2 d-flex flex-column gap-3">
    <fieldset class="d-flex w-100 gap-3 border p-2">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Vote</legend>
        @include('admin.components.forms.text', [
                       'id' => $id.'[title]',
                       'name' => "Titre",
                       'placeholder' => "Vote",
                   ])
        @include('admin.components.forms.text', [
                            'id' => $id.'[subtitle]',
                            'name' => "Sous-titre",
                            'placeholder' => "Votez pour Azuriom sur les différents sites proposés ci-dessous et obtenez des récompenses",
                        ])
    </fieldset>
    <fieldset class="d-flex w-100 gap-3 border p-2">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Classement</legend>
        @include('admin.components.forms.text', [
                       'id' => $id.'[classement][title]',
                       'name' => "Titre",
                       'placeholder' => "Classement",
                   ])
        @include('admin.components.forms.text', [
                            'id' => $id.'[classement][subtitle]',
                            'name' => "Sous-titre"
                    ])
    </fieldset>
</div>
