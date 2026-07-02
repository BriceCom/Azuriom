<x-admin.card :title="trans('theme::admin.sidebar.buttons')">

    <x-admin.fieldset :title="trans('theme::admin.sidebar.vote_button')">
        @include('admin.components.forms.text', [
                    'name' => trans('theme::admin.form.text'),
                    'placeholder' => "Voter",
                    'id' => $id.'[vote_button][text]'
                ])
        @include('admin.components.forms.text', [
                    'name' => trans('theme::admin.form.link'),
                    'placeholder' => "Voter",
                    'id' => $id.'[vote_button][url]'
                ])
    </x-admin.fieldset>

    <x-admin.fieldset :title="trans('theme::admin.sidebar.shop_button')">
        @include('admin.components.forms.text', [
                'name' => trans('theme::admin.form.text'),
                'placeholder' => "Shop",
                'id' => $id.'[shop_button][text]'
            ])

        @include('admin.components.forms.text', [
            'name' => trans('theme::admin.form.link'),
            'placeholder' => "Shop",
            'id' => $id.'[shop_button][url]'
        ])
    </x-admin.fieldset>

</x-admin.card>

<x-admin.card :title="trans('theme::admin.sidebar.sidebar')">

    <x-admin.fieldset :title="trans('theme::admin.sidebar.vote')" class="flex-column">
        @include('admin.components.forms.switch', [
               'id' => $id.'[vote][off]',
               'name' => trans('theme::admin.disable')
           ])

        @include('admin.components.forms.text', [
            'name' => trans('theme::admin.form.title'),
            'placeholder' => "Top voters",
            'id' => $id.'[vote][title]'
        ])
    </x-admin.fieldset>

    <x-admin.fieldset :title="trans('theme::admin.sidebar.discord')" class="flex-column">
        @include('admin.components.forms.switch', [
                'id' => $id.'[discord][off]',
                'name' => trans('theme::admin.disable')
            ])


        @include('admin.components.forms.text', [
            'name' => trans('theme::admin.form.title'),
            'placeholder' => "Discord",
            'id' => $id.'[discord][title]'
        ])
    </x-admin.fieldset>

    <x-admin.fieldset :title="trans('theme::admin.sidebar.shop_article')" class="flex-column">
        @include('admin.components.forms.switch', [
                'id' => $id.'[article][off]',
                'name' => trans('theme::admin.disable')
            ])

        @include('admin.components.forms.text', [
            'name' => trans('theme::admin.form.title'),
            'placeholder' => "Article",
            'id' => $id.'[article][title]'
        ])

        @if(plugins()->isEnabled('shop'))
            @php
                $articles = Azuriom\Plugin\Shop\Models\Package::all();
                foreach ($articles as $article) {
                    $articles[$article->id] = [
                        "value" => $article->id,
                        "text" => $article->name
                    ];
                }
            @endphp

            @include('admin.components.forms.select', [
                'name' => trans('theme::admin.sidebar.article_hightlight'),
                'placeholder' => trans('theme::admin.form.select_placeholder'),
                'id' => $id.'[article][id]',
                'options' => $articles
            ])
        @endif
    </x-admin.fieldset>

</x-admin.card>
