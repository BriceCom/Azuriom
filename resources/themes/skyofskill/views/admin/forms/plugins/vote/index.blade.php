<x-admin.card title="Vote section">
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]', 'placeholder' => 'Comment voter ?'])
    @include('admin.components.forms.text', ['name' => "Texte captcha", 'placeholder' => "Complétez le captcha et validez le vote.", 'id' => $id.'[captchaText]'])
    @include('admin.components.forms.text', ['name' => "Infos récompenses", 'placeholder' => "Vos récompenses arriverons sous 5 minutes.", 'id' => $id.'[rewardInfosText]'])
    @include('admin.components.forms.image-azuriom', [
        'name' => trans('theme::admin.particles.image'),
        'id' => $id.'[voteCardImg]'
    ])


    <x-admin.fieldset title="Comment rejoindre un serveur MC">
        @include('admin.components.forms.text', ['name' => trans('theme::admin.form.icon'), 'icon' => true, 'id' => $id.'[howToVoteIcon]', 'placeholder' => 'bi bi-play-btn-fill'])
        @include('admin.components.forms.textarea', ['name' => trans('theme::admin.form.title'), 'wysiwyg' => true, 'placeholder' => "Clique ici pour pour voir comment voter en vidéo !", 'id' => $id.'[howToVoteText]'])
        @include('admin.components.forms.url', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[howToVoteHref]', 'placeholder' => 'https://www.youtube.com/'])
    </x-admin.fieldset>


</x-admin.card>

<x-admin.card :title="trans('theme::admin.vote.reward_section')">
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[rewardTitle]', 'placeholder' => 'Récompenses top voteurs'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[rewardText]', 'placeholder' => '/'])
    @include('admin.components.forms.textarea', ['name' => "Text d'infos", 'wysiwyg' => true, 'id' => $id.'[infosText]', 'placeholder' => 'Faites /vote en jeu pour consulter le classement et ses récompenses !'])
    @include('admin.components.forms.text', ['name' => "Texte du bas", 'placeholder' => "Le classement est hebdomadaire", 'id' => $id.'[bottomText]'])
</x-admin.card>

<x-admin.card title="FAQ">
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[faqTitle]', 'placeholder' => 'Foire aux questions'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[faqText]', 'placeholder' => 'Retrouvez ici les réponses aux questions les plus fréquemment posées.'])
</x-admin.card>
