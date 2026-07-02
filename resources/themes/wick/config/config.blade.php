@extends('admin.layouts.admin')
@php $version_theme = json_decode(file_get_contents(theme_path().'/theme.json'), true) @endphp
@section('title', 'Thème ' . $version_theme['name'])

@include('admin.elements.editor')
@php
    $menus = [
        'home' => [
            'not_a_plugin' => true,
            'is_enabled' => true,
        ],
        'invoicepro' => [
            'is_enabled' => plugins()->isEnabled('invoicepro'),
        ],
        'shop' => [
            'is_enabled' => plugins()->isEnabled('shop'),
            'multiple_page' => ['index' =>['name'=> trans('theme::admin.menus.shop.index')],
                                'cart' =>['name'=> trans('theme::admin.menus.shop.cart')],
                                'offersSelect' =>['name'=> trans('theme::admin.menus.shop.select_offers'), 'is_active' => setting('shop.use_site_money') === '1'],
                                'offersBuy' =>['name'=> trans('theme::admin.menus.shop.select_direct_payment_offers'), 'is_active' => setting('shop.use_site_money') === '1'],
                                'payments' =>['name'=> trans('theme::admin.menus.shop.payments'), 'is_active' => setting('shop.use_site_money') === '0'],
                                'shop_profile' =>['name'=> trans('theme::admin.menus.shop.my_purchases')],
                                ]
        ],
    ];

    $azuriomImages = \Azuriom\Models\Image::all();
@endphp
@section('content')
    <div class="col-12 mb-3 d-flex flex-column gap-2">
        <div class="d-flex gap-2">
            <div>
                <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" class="btn btn-primary fw-bold rounded-4 text-uppercase px-3"><i class="bi bi-discord"></i> SUPPORT</a>
            </div>
            <div>
                <button type="button" class="btn btn-success fw-bold rounded-4 text-uppercase px-3" data-bs-toggle="modal" data-bs-target="#donationModal"><i class="bi bi-heart-fill me-1"></i>DONATION</button>
            </div>
            <div>
                <a href="https://www.serveurliste.com" target="_blank" class="btn btn-warning fw-bold rounded-4 text-uppercase px-3"><i class="bi bi-search me-1"></i>LISTEZ VOS SERVEURS SUR SERVEURLISTE.COM</a>
            </div>
        </div>
        <hr>
        <div>
            <a href="{{ route('admin.images.create') }}" target="_blank" class="btn btn-secondary fw-bold rounded-4 text-uppercase px-3 my-1" style="font-size: 10px"><i class="bi bi-link"></i> Upload Image</a>
            <a href="https://icons.getbootstrap.com/" target="_blank" class="btn btn-secondary fw-bold rounded-4 text-uppercase px-3 my-1" style="font-size: 10px"><i class="bi bi-bootstrap-fill"></i> BOOSTRAP ICON</a>
        </div>
    </div>
    <div class="d-flex flex-column flex-md-row gap-3 align-items-start">
        <div class="nav flex-row flex-md-column nav-pills me-3 bg-white" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            @foreach($menus as $key=>$menu)
                <a class="nav-link {{$key == 'home' ? 'active':''}} {{$menu['is_enabled'] ? '':'text-secondary'}} text-start" @if(!$menu['is_enabled']) data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Plugin {{$key}} required" @else id="v-pills-{{$key}}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{$key}}" type="button" role="tab" aria-controls="v-pills-{{$key}}" aria-selected="false"@endif>{{ isset($menu['not_a_plugin']) ? trans('theme::admin.menus.'.$key.'.name'):'Plugin '.ucfirst($key) }}</a>
            @endforeach
        </div>
        <form class="w-100" action="{{ route('admin.themes.config', $theme) }}" method="POST">
        @csrf
            <div class="tab-content bg-white" id="v-pills-tabContent">
                @foreach($menus as $key=>$menu)
                    @if($menu['is_enabled'])
                        <div class="tab-pane fade show {{$key == 'home' ? 'active':''}}" id="v-pills-{{$key}}" role="tabpanel" aria-labelledby="v-pills-{{$key}}-tab" tabindex="0">
                                @if(isset($menu['multiple_page']))
                                    <div>
                                        <h2 class="text-primary p-2">{{trans('theme::admin.menus.'.$key.'.name')}}</h2>
                                        <div class="px-2">
                                            @foreach($menu['multiple_page'] as $keyPage=>$multi_page)
                                                @if(View::exists('admin.forms.plugins.'.$key.'.'.$keyPage))
                                                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#{{$keyPage}}" aria-expanded="false" aria-controls="{{$keyPage}}">{{$multi_page['name']}}</button>
                                                @endif
                                            @endforeach
                                            <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="">
                                                {{trans('theme::admin.menus.all_parameters')}}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        @foreach($menu['multiple_page'] as $keyPage=>$multi_page)
                                            @if(View::exists('admin.forms.plugins.'.$key.'.'.$keyPage))
                                                <div class="collapse multi-collapse {{$keyPage == 'index' ? 'show':''}}" id="{{$keyPage}}">
                                                    <div class="card">
                                                        <div class="card-header bg-light fw-bold">
                                                            {{mb_strtoupper($multi_page['name'])}}
                                                        </div>
                                                        <div class="card-body">
                                                            @include('admin.forms.plugins.'.$key.'.'.$keyPage, ['id' => $key.'['.$keyPage.']'])
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div>
                                        <h2 class="text-primary p-2">{{trans('theme::admin.menus.'.$key.'.name') ?? 'TRANSLATION ERROR'}}</h2>
                                        @includeIf('admin.forms.plugins.'.$key.'.index', ['id' => $key.'[index]'])
                                    </div>
                             @endif
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="d-flex justify-content-end m-2">
                <button type="submit" class="btn btn-success align-self-end">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </div>
        </form>
    </div>
    @includeIf('admin.components.donation')
@endsection
@push('scripts')
    <script>
        function addFields(e, id, need){

            let inputIdNumber = 0
            let elm = e.previousElementSibling.lastElementChild;

            console.log(e.previousElementSibling.lastElementChild)

            if(!elm.classList.contains('bi') && elm != null){
                inputIdNumber = elm.getElementsByTagName('input')[0].id.replace(/[^0-9]/g,'')
            }

            let addElement = `
                <div class="position-relative border border-2 p-2 mt-1">
                <div class="position-absolute text-danger fs-3 cursor-pointer" style="top: 5px; right: 5px;" onclick="deleteField(this)"><i class="bi bi-x-circle"></i></div>
                <h2 class="fs-3">{{trans('theme::admin.multiple-input.title_new')}}</h2>
                <div class="d-flex flex-column gap-2">
            `;

            Object.entries(need).forEach(([key, value]) => {
                if(key.includes('text')){
                    addElement +=`@include('admin.components.forms.text', ['nameToUpper' => false, 'name' => '${value.name.toUpperCase()}', 'id' => '${id}[${parseInt(inputIdNumber)+1}][${key}]'])`;
                }
                switch(key){
                    case 'select':
                        addElement += `@include('admin.components.forms.select', ['nameToUpper' => false, 'name' => '${value.name.toUpperCase()}', 'amountOption' => 3, 'value1' => '${value.value1}','value2' => '${value.value2}', 'value3' => '${value.value3}','id' => '${id}[${parseInt(inputIdNumber)+1}][type]'])`;
                        break;
                    case 'url':
                        addElement += `@include('admin.components.forms.url', ['nameToUpper' => false, 'name' => '${value.name.toUpperCase()}', 'placeholder' => '${value.placeholder}' ,'id' => '${id}[${parseInt(inputIdNumber)+1}][url]'])`;
                        break;
                }
            });
            e.previousElementSibling.outerHTML += addElement;
        }

        function deleteField(e){ e.parentElement.remove(); }

        function showPreview(id){
            let img = document.getElementById('img-preview-'+id);
            let option = document.getElementById(id);

            if(option.value === ''){
                img.parentNode.style.display = 'none';
            } else {
                if(img.parentNode.style.display === 'none') img.parentNode.style.display = null;
                img.setAttribute('src', '{{ image_url() }}/' + option.value);
            }
        }

        function inputColorDefaultValue(e, value, config_value){ e.previousElementSibling.value != e.value ? e.previousElementSibling.value = e.value:e.previousElementSibling.value = config_value; }

    </script>
@endpush
@push('styles')
    <style>
        /*Jennifer Louie*/
        div.switcher + div.switcher {
            margin-top: 10px;
        }
        div.switcher label {
            padding: 0;
        }
        div.switcher label * {
            vertical-align: middle;
        }
        div.switcher label input {
            display: none;
        }
        div.switcher label input + span {
            position: relative;
            display: inline-block;
            margin-right: 10px;
            width: 40px;
            height: 17px;
            background: var(--bs-gray);
            border: 2px solid var(--bs-gray);
            border-radius: 50px;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }
        div.switcher label input + span small {
            position: absolute;
            display: block;
            width: 36%;
            height: 100%;
            background: #fff;
            border-radius: 50%;
            transition: all 0.1s ease-in-out;
            left: 0;
        }
        div.switcher label input:checked + span {
            background: var(--bs-primary);
            border-color: var(--bs-primary);
        }
        div.switcher label input:checked + span small {
            left: 60%;
        }
    </style>
@endpush

