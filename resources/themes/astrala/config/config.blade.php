@extends('admin.layouts.admin')
@section('title', 'Thème Astrala')
@php ($azuriomImages = \Azuriom\Models\Image::all())

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
    </div>
    <div>
        <form class="w-100" action="{{ route('admin.themes.config', $theme) }}" method="POST">
            @csrf
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">HAUT DE PAGE</h2>
                </div>
                <div class="card-body d-flex flex-column flex-md-row gap-3">
                    @include('admin.header', ['id'=> 'header'])
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">ACCUEIL</h2>
                </div>
                <div class="card-body d-flex flex-column flex-md-row gap-3">
                    @includeIf('admin.home', ['id'=> 'home'])
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">REGLEMENT</h2>
                </div>
                <div class="card-body d-flex flex-column flex-md-row gap-3">
                    @includeIf('admin.reglement', ['id'=> 'rules'])
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">FAQ</h2>
                </div>
                <div class="card-body d-flex flex-column flex-md-row gap-3">
                    @includeIf('admin.faq', ['id'=> 'faq'])
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">VOTE</h2>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    @includeIf('admin.vote', ['id'=> 'vote'])
                </div>
            </div>
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">PIED DE PAGE</h2>
                </div>
                <div class="card-body d-flex flex-column gap-3">
                    @includeIf('admin.footer', ['id'=> 'footer'])
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
