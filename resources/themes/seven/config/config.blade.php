@extends('admin.layouts.admin')
@php
    // Get theme
        $themes = collect(app(Azuriom\Extensions\UpdateManager::class)->getThemes(false));

        $current_theme = $themes->where('extension_id', $theme)->first();

@endphp
@section('title', trans('theme::admin.config.title') .' '. $current_theme['name'])

@php
    $authors = ['Bricec6', 'Bryx Agency'];

    // Get azuriom images
        $azuriomImages = \Azuriom\Models\Image::all();

    // Get themes
        $themes_own = collect(app(Azuriom\Extensions\UpdateManager::class)->getThemes(false))->whereIn('author.name', $authors);

    // Get plugins
        $plugin_installed = plugins()->plugins();

        $plugins_own = collect(app(Azuriom\Extensions\UpdateManager::class)->getPlugins(false))->whereIn('author.name', $authors);

    // Get images
        $azuriomImages = \Azuriom\Models\Image::all()
@endphp

@include('admin.elements.editor')
@php
    $plugin_installed = plugins()->plugins();

    $menus = [
        'premium' => [
            'not_a_plugin' => true,
            'is_enabled' => true,
        ],
        'settings' => [
            'not_a_plugin' => true,
            'is_enabled' => true,
        ],
        'style' => [
            'not_a_plugin' => true,
            'is_enabled' => true,
            'multiple_page' => [
                'index' =>['name'=> trans('theme::admin.menus.style.name')],
                'colors' => ['name' => trans('theme::admin.menus.style.colors')],
                'ui' =>['name'=> trans('theme::admin.menus.style.ui')],
            ]
        ],
        'header' => [
            'not_a_plugin' => true,
            'is_enabled' => true,
            'multiple_page' => [
                'index' =>['name'=> trans('theme::admin.menus.header.name')],
                'modules' =>['name'=> trans('theme::admin.menus.modules')],
            ]
        ],
        'footer' => [
            'not_a_plugin' => true,
            'is_enabled' => true,
            'multiple_page' => [
                'index' =>['name'=> trans('theme::admin.menus.footer.name')],
                'modules' =>['name'=> trans('theme::admin.menus.modules')],
            ]
        ],
        'home' => [
            'not_a_plugin' => true,
            'is_enabled' => true,
            'multiple_page' => [
                'index' =>['name'=> trans('theme::admin.menus.home.name')],
                'bentobox' =>['name'=> trans('theme::admin.menus.home.bentobox')],
                'discord' =>['name'=> trans('theme::admin.menus.home.discord')],
                'video' =>['name'=> trans('theme::admin.menus.home.video')]
            ]
        ],
        'shop' => [
            'is_enabled' => plugins()->isEnabled('shop'),
        ],
        'vote' => [
            'is_enabled' => plugins()->isEnabled('vote'),
        ],
    ];

    foreach ($plugin_installed as $plugin) {
        if (!array_key_exists($plugin->id, $menus)) {
            $menus[$plugin->name] = ['is_enabled' => false, 'is_supported' => false];
        }
    }

    $azuriomImages = \Azuriom\Models\Image::all();
@endphp
@section('content')

    @include('components.admin.partials.intro')


    @if(!theme_config('premium.serveurliste.link') || (theme_config('premium.serveurliste.token') == null))
        <p class="w-100 alert alert-warning mb-3">⭐ {{trans('theme::admin.no_premium')}}</p>
    @endif
    <div class="d-flex flex-column flex-md-row gap-3 align-items-start">
        <div class="nav-plugin nav flex-row flex-md-column nav-pills me-3 bg-white" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            @foreach($menus as $key=>$menu)
                <a class="nav-link mt-1 {{$key == 'settings' ? 'active':''}} {{$menu['is_enabled'] ? '':((isset($menu['is_supported']) ?? $menu['is_supported'] ? 'bg-body-secondary opacity-25': 'text-secondary'))}} fw-bold text-start" @if(!$menu['is_enabled']) data-bs-toggle="tooltip" data-bs-placement="top"
                   @if(isset($menu['is_supported']))
                       data-bs-title="{{trans('theme::admin.plugin_cant_be_config')}}"
                   @else
                       data-bs-title="{{trans('theme::admin.plugin_required', ['name' => $key])}}"
                   @endif
                   @else id="v-pills-{{$key}}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{$key}}" type="button" role="tab" aria-controls="v-pills-{{$key}}" aria-selected="false"@endif>{{ isset($menu['not_a_plugin']) ? trans('theme::admin.menus.'.$key.'.name'):'Plugin '.ucfirst($key) }}</a>
            @endforeach
        </div>
        <form class="w-100" action="{{ route('admin.themes.config', $theme) }}" method="POST">
        @csrf
            <div class="tab-content bg-white" id="v-pills-tabContent">
                @foreach($menus as $key=>$menu)
                    @if($menu['is_enabled'])
                        <div class="tab-pane fade show {{$key == 'settings' ? 'active':''}}" id="v-pills-{{$key}}" role="tabpanel" aria-labelledby="v-pills-{{$key}}-tab" tabindex="0">
                                @if(isset($menu['multiple_page']))
                                    <div>
                                        <h2 class="text-primary p-2">{{trans('theme::admin.menus.'.$key.'.name')}}</h2>
                                        <div class="px-2">
                                            @foreach($menu['multiple_page'] as $keyPage=>$multi_page)
                                                @if(View::exists('admin.forms.plugins.'.$key.'.'.$keyPage))
                                                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#{{$keyPage}}" aria-expanded="{{$loop->first ? 'true':'false'}}" aria-controls="{{$keyPage}}">{{$multi_page['name']}}</button>
                                                @endif
                                            @endforeach
{{--                                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="true" aria-controls="">--}}
{{--                                                {{trans('theme::admin.menus.all_parameters')}}--}}
{{--                                            </button>--}}
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        @foreach($menu['multiple_page'] as $keyPage=>$multi_page)
                                            @if(View::exists('admin.forms.plugins.'.$key.'.'.$keyPage))
                                                <div class="collapse multi-collapse {{$loop->first ? 'show':''}} {{$keyPage == 'index' ? 'show':''}}" id="{{$keyPage}}">
                                                    <div class="card">
                                                        <div class="card-header fw-bold">
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
                                        @includeIf('admin.forms.plugins.'.$key.'.index', ['id' => $key])
                                    </div>
                             @endif
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="d-flex justify-content-end m-2">
                <button type="submit" class="btn btn-success">
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
        .nav-plugin{
            @media (min-width: 1200px) {
                width: 20%
            }
        }

        .tab-pane{
            .btn-primary[aria-expanded="false"]{
                background: var(--bs-white) !important;
                color: var(--bs-primary) !important
            }
            .btn-primary[aria-expanded="true"]{
                background: var(--bs-primary) !important;
            }
        }

        [data-bs-theme=dark]{
            .text-primary, .btn-outline-primary{
                color: #ffff !important
            }

            .bg-white{
                background-color: #434343 !important
            }

            /*.bg-secondary{*/
            /*    background-color: #000000 !important*/
            /*}*/
        }
    </style>
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
    <style>
        /*********** Baseline, reset styles ***********/
        input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            background: transparent;
            cursor: pointer;
            width: 25rem;
        }

        /* Removes default focus */
        input[type="range"]:focus {
            outline: none;
        }

        /******** Chrome, Safari, Opera and Edge Chromium styles ********/
        /* slider track */
        input[type="range"]::-webkit-slider-runnable-track {
            background-color: #b3b3b3;
            border-radius: 0.5rem;
            height: 0.5rem;
        }

        /* slider thumb */
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none; /* Override default look */
            appearance: none;
            margin-top: -4px; /* Centers thumb on the track */
            background-color: #000000;
            border-radius: 0.5rem;
            height: 1rem;
            width: 1rem;
        }

        input[type="range"]:focus::-webkit-slider-thumb {
            outline: 3px solid #000000;
            outline-offset: 0.125rem;
        }

        /*********** Firefox styles ***********/
        /* slider track */
        input[type="range"]::-moz-range-track {
            background-color: #b3b3b3;
            border-radius: 0.5rem;
            height: 0.5rem;
        }

        /* slider thumb */
        input[type="range"]::-moz-range-thumb {
            background-color: #000000;
            border: none; /*Removes extra border that FF applies*/
            border-radius: 0.5rem;
            height: 1rem;
            width: 1rem;
        }

        input[type="range"]:focus::-moz-range-thumb{
            outline: 3px solid #000000;
            outline-offset: 0.125rem;
        }
    </style>
@endpush

