<x-admin.card title="Bentobox">
    @include('admin.components.forms.switch', [
                  'direction' => 'row',
                  'id' => $id.'[off]',
                  'name' => trans('theme::admin.disable')
              ])

    <x-admin.fieldset title="Bento boutique">
        @include('admin.components.forms.image-azuriom', ['name' => 'Image de droite', 'id' => $id.'[shop][bg]'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[shop][title]', 'placeholder' => 'Boutique'])
        @include('admin.components.forms.text', ['name' => 'Lien', 'id' => $id.'[shop][href]', 'placeholder' => 'https//website.fr/shop'])
    </x-admin.fieldset>

    <x-admin.fieldset title="Bento Discord">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[discord][title]', 'placeholder' => '+7000'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[discord][text]', 'placeholder' => 'membres'])
    </x-admin.fieldset>

    <x-admin.fieldset title="Bento vote">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[vote][title]', 'placeholder' => 'Voter'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[vote][text]', 'placeholder' => 'Cadeaux gratuits'])
        @include('admin.components.forms.text', ['name' => 'Lien', 'id' => $id.'[vote][href]', 'placeholder' => '/vote'])
    </x-admin.fieldset>

    <x-admin.fieldset title="Bento Comment nous rejoindre">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[howToJoin][title]', 'placeholder' => 'Comment jouer'])
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[howToJoin][text]', 'placeholder' => 'Au serveur minecraft SkyBlock OpPrison n°1 en France ?'])
        @include('admin.components.forms.image-azuriom', ['name' => 'Image de fond', 'id' => $id.'[howToJoin][bg]'])
        @include('admin.components.forms.text', ['name' => 'Lien', 'id' => $id.'[howToJoin][href]', 'placeholder' => "/#comment-nous-rejoindre"])
    </x-admin.fieldset>
</x-admin.card>

<x-admin.fieldset title="Comment rejoindre un serveur MC">
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.icon'), 'icon' => true, 'id' => $id.'[howToJoinServerIcon]', 'placeholder' => 'bi bi-play-btn-fill'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'wysiwyg' => true, 'placeholder' => "Clique ici pour pour voir comment rejoindre un Serveur Minecraft en vidéo !", 'id' => $id.'[howToJoinServerText]'])
    @include('admin.components.forms.url', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[howToJoinServerHref]', 'placeholder' => 'https://youtube.com'])
</x-admin.fieldset>
