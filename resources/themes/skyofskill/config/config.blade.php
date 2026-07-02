@extends('admin.layouts.admin')

@section('title', trans('theme::admin.config.title'))

@push('styles')
    <link rel="stylesheet" href="{{ theme_asset('css/admin-styles.css') }}">
@endpush

{{-- Elements --}}
@include('admin.elements.editor')
@include('admin.elements.color-picker')

{{-- Partials --}}

@php
    // Get azuriom images
        $azuriomImages = \Azuriom\Models\Image::all();

    // Get menus
        $menus = [
            'settings' => [
                'not_a_plugin' => true,
                'is_enabled' => true,
                'multiple_page' => [
                    'index' =>['name'=> trans('theme::admin.menus.settings.name')],
                    'discord' => ['name' => trans('theme::admin.menus.settings.discord')],
                    'server' => ['name' => trans('theme::admin.menus.settings.server')],
                ]
            ],
            'style' => [
                'icon' => 'palette-fill',
                'not_a_plugin' => true,
                'is_enabled' => true,
                'multiple_page' => [
                    'index' =>['name'=> trans('theme::admin.menus.style.name')],
                    'colors' => ['name' => trans('theme::admin.menus.style.colors')],
                ]
            ],
            'header' => [
                'icon' => 'window',
                'not_a_plugin' => true,
                'is_enabled' => true,
                'multiple_page' => [
                    'index' =>['name'=> trans('theme::admin.menus.header.name')],
                    'modules' =>['name'=> trans('theme::admin.menus.modules')],
                ]
            ],
            'footer' => [
                'icon' => 'window-desktop',
                'not_a_plugin' => true,
                'is_enabled' => true,
                'multiple_page' => [
                    'index' =>['name'=> trans('theme::admin.menus.footer.name')]
                ]
            ],
            'home' => [
                'icon' => 'house-gear-fill',
                'not_a_plugin' => true,
                'is_enabled' => true,
                'multiple_page' => [
                    'index' =>['name'=> trans('theme::admin.menus.home.name')],
                    'bentobox' =>['name'=> "Bentobox"],
                    'welcome' =>['name'=> "Bienvenue"],
                    'carousel' =>['name'=> "Carousel"],
                    'hym' =>['name'=> "HYM section"],
                    'howToJoin' =>['name'=> "Comment nous rejoindre"],
                ]
            ],
            'vote' => [
                'icon' => 'hand-thumbs-up-fill',
                'is_enabled' => plugins()->isEnabled('vote'),
                'multiple_page' => [
                    'index' =>['name'=> trans('theme::admin.menus.home.name')]
                ]
            ],
        ];
@endphp
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row d-flex flex-column flex-md-row gap-3 align-items-start">
                <div class="col-md-2 nav flex-row flex-md-column nav-pills me-3" id="config-pills" role="tablist" aria-orientation="vertical">

                    {{--  Menu trigger --}}
                    @foreach($menus as $key => $menu)
                        <button class="nav-link py-3 text-start fw-bold {{ $key === 'premium' ? 'text-warning':"" }} {{$menu['is_enabled'] ? '':((isset($menu['is_supported']) ?? $menu['is_supported'] ? 'bg-body-secondary opacity-25': 'text-secondary'))}}"
                                id="pill-{{$key}}-trigger"
                                @if(!$menu['is_enabled'])
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    @if(isset($menu['is_supported']))
                                        data-bs-title="{{trans('theme::admin.plugin_cant_be_config')}}"
                                    @else
                                        data-bs-title="{{trans('theme::admin.plugin_required', ['name' => $key])}}"
                                    @endif
                                @endif
                                data-config-pill="pill-{{$key}}" data-bs-toggle="pill" data-bs-target="#pill-{{$key}}" type="button" role="tab" aria-controls="pill-{{$key}}">

                            <i class="d-inline fs-5 me-1 {{ isset($menu['icon']) ? 'bi bi-'. $menu['icon'] : "bi bi-gear-fill" }}"></i>
                            {{ isset($menu['not_a_plugin']) ? trans('theme::admin.menus.'.$key.'.name'):'Plugin ' . ucfirst($key) }}
                        </button>
                    @endforeach
                </div>
                <form id="configForm" class="col" action="{{ route('admin.themes.config', $theme) }}" method="POST">
                    @csrf

                    @include('components.admin.partials.configs-tabs')

                    <div class="sticky-bottom d-flex justify-content-end m-2 p-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>

    <script type="text/javascript">
        window.CONSTANTS = {
            image_url: "{{ image_url() }}"
        }
    </script>

    <script src="{{ theme_asset('js/admin/admin.js') }}"></script
    >
    <script>
        // For list-input.blade.php
        const addListener = function (el) {
            el.addEventListener('click', function () {
                const element = el.parentNode;

                element.parentNode.removeChild(element);
            });
        }
    </script>
@endpush

@push('footer-scripts')
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ theme_asset('js/admin/admin-footer.js') }}" defer></script>
@endpush

