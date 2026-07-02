<x-admin.card title="Bienvenue">
    @include('admin.components.forms.switch', [
                  'direction' => 'row',
                  'id' => $id.'[off]',
                  'name' => trans('theme::admin.disable')
              ])

    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]', 'placeholder' => 'Bienvenue sur SkyOfSKill !'])
    @include('admin.components.forms.textarea', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[description]', 'wysiwyg' => true, 'placeholder' => 'SkyOfSkill est le premier serveur Minecraft Prison français. C’est l’unique serveur à le fusionner au SkyBlock pour une experience immersive. Progresse en prison, améliore ton île, débloque des récompenses exclusives et gagne les classements.'])

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
        @include('admin.components.forms.text', ['name' => 'Texte du bouton', 'id' => $id.'[button][label]', 'placeholder' => 'Comment jouer sur le serveur ?'])
        @include('admin.components.forms.text', ['name' => 'Lien du bouton', 'id' => $id.'[button][href]', 'placeholder' => '/#comment-nous-rejoindre'])
    </x-admin.fieldset>

    <x-admin.fieldset :title="'Image dans le texte'">
        @include('admin.components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[imgInText][src]'])
        @include('admin.components.forms.text', ['name' => 'Texte alternatif', 'id' => $id.'[imgInText][alt]'])
    </x-admin.fieldset>

    <x-admin.fieldset :title="'Badges'" class="flex-column">
        @include('admin.components.forms.list-input', [
            'name' => $id.'[badges]',
            'id' => 'welcome-badges',
            'inputIcon' => true,
            'inputWysiwyg' => true,
            'inputWysiwygHeight' => 170,
            'values' => theme_config('home.welcome.badges') ?? [
                                    [
                                        'icon' => 'bi-star-fill',
                                        'htmlContent' => 'Record de joueurs: <strong>721</strong>',
                                    ],
                                    [
                                        'icon' => 'bi-calendar3',
                                        'htmlContent' => 'Ouvert depuis <strong>2019</strong>',
                                    ],
                                    [
                                        'icon' => 'bi-heart-fill',
                                        'htmlContent' => '<strong>+117000</strong> joueurs uniques',
                                    ],
                                ],
        ])
    </x-admin.fieldset>
</x-admin.card>
