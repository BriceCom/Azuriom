@extends('admin.layouts.admin')

@section('title', 'Bird - Theme Editor Live')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="mb-3">Theme Editor Live</h3>
            <p class="text-muted mb-0">
                Utilisez le bouton flottant <strong>✏ Éditer</strong> sur le front-end (connecté en administrateur)
                pour prévisualiser et sauvegarder les paramètres du thème Bird.
            </p>
        </div>
    </div>

    @include('theme-editor.partials.config-form')
@endsection
