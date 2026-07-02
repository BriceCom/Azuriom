<div class="p-2 d-flex flex-column flex-md-row gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Box exemlpe</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.text', ['name' => 'shop id', 'id' => $id.'[shop-id]'])
            @include('admin.components.forms.image-azuriom', ['name' => 'shop image', 'id' => $id.'[shop-image]'])
        </div>
    </fieldset>
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Checkbox exemple</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.checkbox', ['name' => 'Checkbox lol', 'multipleId' => [
                $id.'[check1]' => ['name' => 'check1', 'value' => '1'],
                $id.'[check2]'  => ['name' => 'check2', 'value' => '2'],
            ]])
        </div>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.color', ['name' => 'shop color', 'id' => $id.'[shop-color]', 'value' => '#ff6424'])
        </div>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.number', ['name' => 'shop num', 'id' => $id.'[shop-num]', 'max' => 100, 'min' => 10, 'step' => 2,])
            @include('admin.components.forms.range', ['name' => 'shop range', 'id' => $id.'[shop-range]', 'value' => 0,'max' => 100, 'min' => 10, 'step' => 2,])
        </div>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.url', ['name' => 'shop url', 'id' => $id.'[shop-url]', 'placeholder' => 'https://youtube.com'])
        </div>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.select', ['name' => 'shop select', 'id' => $id.'[shop-select]', 'values' => ['a','c','d']])
        </div>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.multiple_input', [
                'for' => 'create',
                'id' => $id.'[shop][box]',
                'need' => [
                    'text' => [
                        'name' => 'text1'
                    ],
                    'paragraph' => [
                        'name' => 'text2'
                    ],
                    'select' => [
                        'name' => 'Appel valeur plugin',
                        'values' => [
                            'Compteur vote',
                            'Compteur connecté',
                        ],
                    ],
                    'link' => [
                        'name' => 'link 2',
                        'placeholder' => 'https://youtube.com',
                    ],
                ],
            ])
        </div>
    </fieldset>
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">HERO BOX</legend>

        @if(isset(config('theme.'.str_replace(['[', ']'],['.',''],$id))['box']))
            @include('admin.components.forms.multiple_input', [
                'for' => 'result',
                'id' => $id.'[hero][box]',
                'select' => [
                    'name' => 'Type',
                    'values' => ['Compteur inscrits','Compteur discord','Compteur vote'],
                ],
                'url' => [
                    'placeholder' => 'https://youtube.com',
                ],
            ])
        @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle-fill"></i> {{trans('theme::admin.menus.shop.box.without_card')}}
            </div>
        @endif

        @include('admin.components.forms.multiple_input', [
            'for' => 'create',
            'id' => $id.'[box]',
            'need' => [
                'text_title' => [
                    'name' => trans('theme::admin.menus.shop.box.text_title')
                ],
                'text' => [
                    'name' => trans('theme::admin.menus.shop.box.text')
                ],
                'select' => [
                    'name' => trans('theme::admin.menus.shop.box.select'),
                    'amountOption' => 3,
                    'value1' => 'Compteur inscrits',
                    'value2' => 'Compteur discord',
                    'value3' => 'Compteur vote'
                ],
                'text_url' => [
                    'name' => trans('theme::admin.menus.home.shop.text_url'),
                ],
                'url' => [
                    'name' =>  trans('theme::admin.menus.home.shop.url'),
                    'placeholder' => 'https://youtube.com',
                ],
            ],
        ])
    </fieldset>
</div>
