@extends('admin.layouts.admin')
@php $version_theme = json_decode(file_get_contents(theme_path().'/theme.json'), true) @endphp
@section('title', 'Thème ' . $version_theme['name'])

@include('admin.elements.editor')
@php
    $azuriomImages = \Azuriom\Models\Image::all();
@endphp
@section('content')
    <div class="col-12 mb-3 d-flex flex-column gap-2">
        <div class="d-flex gap-2">
            <div>
                <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" class="btn btn-primary fw-bold rounded-4 text-uppercase px-3"><i class="bi bi-discord"></i> {{trans('theme::admin.config.our_discord')}}</a>
            </div>
            <div>
                <button type="button" class="btn btn-success fw-bold rounded-4 text-uppercase px-3" data-bs-toggle="modal" data-bs-target="#donationModal"><i class="bi bi-heart-fill me-1"></i>{{trans('theme::admin.config.don')}}</button>
            </div>
            <div>
                <a href="https://www.serveurliste.com" target="_blank" class="btn btn-warning fw-bold rounded-4 text-uppercase px-3"><i class="bi bi-search me-1"></i>{{trans('theme::admin.config.serveurliste')}}</a>
            </div>
        </div>
        <hr>
        <div>
            <a href="https://icons.getbootstrap.com/" target="_blank" class="btn btn-secondary fw-bold rounded-4 text-uppercase px-3 my-1" style="font-size: 10px"><i class="bi bi-bootstrap-fill"></i> BOOSTRAP ICON</a>
            <a href="{{ route('admin.images.create') }}" target="_blank" class="btn btn-secondary fw-bold rounded-4 text-uppercase px-3 my-1" style="font-size: 10px"><i class="bi bi-link"></i> Upload Image</a>
        </div>
    </div>
    <div>
        <form class="w-100" action="{{ route('admin.themes.config', $theme) }}" method="POST">
            @csrf

            <div class="alert alert-warning w-100 mb-3">
                <label class="form-label m-0" for="general-serverliste">{{trans('theme::admin.link_of_your_server_on')}} <a href="https://www.serveurliste.com/" target="_blank" rel="noopener, nofollow">ServeurListe.com</a></label>
                <input type="url" class="form-control @error('block-button-text') is-invalid @enderror" id="block-button-text" name="general[serveurliste]" value="{{old('general-serverliste', config('theme.general.serveurliste'))}}" aria-describedby="block-button-text-Label">
                @error('general-serverliste')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
{{--            <div id="getId" class="alert alert-info w-100 mb-3">--}}
{{--                <label class="form-label m-0" for="general-discord-id">{{trans('theme::admin.your_id_discord')}} <a href="https://www.youtube.com/watch?v=7CXfutvFdsE" target="_blank" rel="noopener, nofollow">{{trans('theme::admin.how_to_get_our_id')}}</a></label>--}}
{{--                <input type="text" class="form-control @error('block-button-text') is-invalid @enderror" id="block-button-text" name="general[discord][id]" value="{{old('general-discord-id', config('theme.general.discord.id'))}}" aria-describedby="block-button-text-Label">--}}
{{--                @error('general-discord-id')--}}
{{--                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--                @enderror--}}
{{--            </div>--}}
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">{{trans('theme::admin.general')}}</h2>
                </div>
                <div class="card-body d-flex flex-wrap flex-column flex-md-row gap-3">
                    @includeIf('admin.general')
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">{{trans('theme::admin.colors')}}</h2>
                    <small class="fs-5 fst-italic"><i class="bi bi-info-circle"></i> {{trans('theme::admin.form.colors.desc')}}</small>
                </div>
                <div class="card-body d-flex flex-wrap flex-column flex-md-row gap-3">
                    @includeIf('admin.colors')
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">Header</h2>
                </div>
                <div class="card-body d-flex flex-wrap flex-column flex-md-row gap-3">
                    @includeIf('admin.header')
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">{{trans('theme::admin.hero')}}</h2>
                </div>
                <div class="card-body d-flex flex-column flex-md-row gap-3">
                    @includeIf('admin.hero')
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">{{trans('theme::admin.footer')}}</h2>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    @includeIf('admin.footer')
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">{{trans('theme::admin.home')}}</h2>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    @includeIf('admin.home')
                </div>
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

