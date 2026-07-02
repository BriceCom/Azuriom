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

@section('content')
    @include('components.admin.partials.intro')

    <div>
        <form class="w-100" action="{{ route('admin.themes.config', $theme) }}" method="POST">
            @csrf

            <div class="p-2 d-flex flex-column gap-3">
                <div class="row container gap-md-3">
                    <div class="col-lg-5 alert alert-warning">
                        <p class=" mb-2">{{trans('theme::admin.active_premium')}}</p>
                        @include('admin.components.forms.url', [
                            'id' => 'general[serveurliste][link]',
                            'name' => trans('theme::admin.link_of_your_server_on'),
                            'placeholder' => "https://www.serveurliste.com/minecraft/your_server",
                            'pattern' => '^https:\/\/www\.serveurliste\.com\/.*'
                        ])
                    </div>
                </div>
            </div>

            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">{{trans('theme::admin.colors')}}</h2>
                    <small class="fs-5 fst-italic"><i class="bi bi-info-circle"></i> {{trans('theme::admin.form.colors.desc')}}</small>
                </div>
                <div class="card-body d-flex flex-column flex-md-row gap-3">
                    @include('admin.general')
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">{{trans('theme::admin.userBar')}}</h2>
                </div>
                <div class="card-body d-flex flex-column flex-md-row gap-3">
                    @include('admin.userBar')
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">{{trans('theme::admin.hero')}}</h2>
                </div>
                <div class="card-body d-flex flex-column flex-md-row gap-3">
                    @include('admin.hero')
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0">EVENT</h2>
                </div>
                <div class="card-body d-flex flex-column flex-md-row gap-3">
                    @include('admin.event')
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">{{trans('theme::admin.body')}}</h2>
                </div>
                <div class="card-body d-flex flex-column flex-md-row gap-3">
                    @include('admin.block')
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">{{trans('theme::admin.home')}}</h2>
                </div>
                <div class="card-body d-flex flex-column flex-md-row gap-3">
                    @include('admin.home')
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">{{trans('theme::admin.footer')}}</h2>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    @include('admin.footer')
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">{{trans('theme::admin.header.title')}}</h2>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    @include('admin.header')
                </div>
            </div>
            <div class="d-flex justify-content-end m-2">
                <button type="submit" class="btn btn-success align-self-end">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </div>
        </form>
    </div>
    @includeIf('admin.autre.donation')
@endsection

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

@push('scripts')
    <script>
        function discordTypeChange(value){
            document.getElementById('discord-iframe').classList.toggle("d-none");
            document.getElementById('discord-custom').classList.toggle("d-none");
        }
    </script>
@endpush
