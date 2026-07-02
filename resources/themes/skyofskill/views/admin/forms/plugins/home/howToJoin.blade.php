<x-admin.card title="Comment nous rejoindre">
    @include('admin.components.forms.switch', [
                  'direction' => 'row',
                  'id' => $id.'[off]',
                  'name' => trans('theme::admin.disable')
              ])

    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]', 'placeholder' => 'Comment rejoindre le serveur minecraft ?'])
    @include('admin.components.forms.textarea', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[description]', 'wysiwyg' => true,'placeholder' => 'Pour rejoindre un serveur Minecraft comme SkyOfSkill, il suffit d’ouvrir Minecraft Java 1.20.1, puis d’aller dans le menu Multijoueur. Depuis cette interface, ajoute un nouveau serveur en cliquant sur « Ajouter un serveur ». Choisis le nom que tu veux et dans le champ Adresse du serveur indique PLAY.SKYOFSKILL.FR. Enfin valide l’ajout du serveur minecraft pour te connecter.'])

    @include('admin.components.forms.switch', [
                  'direction' => 'row',
                  'id' => $id.'[logo]',
                  'name' => 'Afficher le logo'
              ])

    @include('admin.components.forms.image-azuriom', ['name' => 'Image gauche', 'id' => $id.'[leftImgSrc]'])
    @include('admin.components.forms.image-azuriom', ['name' => 'Image droite', 'id' => $id.'[rightImgSrc]'])

    @include('admin.components.forms.switch', [
                  'direction' => 'row',
                  'id' => $id.'[joinButton]',
                  'name' => 'Afficher le bouton de connexion'
              ])

    <x-admin.fieldset :title="'Bouton personnalisé'">
        @include('admin.components.forms.text', ['name' => 'Texte du bouton', 'id' => $id.'[button][label]'])
        @include('admin.components.forms.text', ['name' => 'Lien du bouton', 'id' => $id.'[button][href]'])
    </x-admin.fieldset>

    <x-admin.fieldset :title="'Image dans le texte'">
        @include('admin.components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[imgInText][src]'])
        @include('admin.components.forms.text', ['name' => 'Texte alternatif', 'id' => $id.'[imgInText][alt]'])
    </x-admin.fieldset>

    <x-admin.fieldset :title="'Badges'">
        @include('admin.components.forms.list-input', [
            'name' => $id.'[badges]',
            'id' => 'how-to-join-badges',
            'inputIcon' => true,
            'inputWysiwyg' => true,
            'inputWysiwygHeight' => 170,
            'values' => theme_config('home.howToJoin.badges') ?? [
                        [
                            'icon' => 'bi-check2-circle',
                            'htmlContent' => 'Accès: Gratuit',
                        ],
                        [
                            'icon' => 'bi-info-circle-fill',
                            'htmlContent' => 'Versions: 1.8.8 à 1.20.1',
                        ],
                    ],
        ])
    </x-admin.fieldset>
</x-admin.card>
