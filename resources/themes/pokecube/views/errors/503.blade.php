@extends('layouts.app')
@section('title', "Page introuvable")

@section('content')

@include('elements.section')

<div class="profile-spacer"></div>

<div class="error-wrapper">

    <div class="error-card">

        <h1 class="error-code">503</h1>

        <p class="error-message">
            Oups… La page que tu cherches n’existe pas ou a été déplacée.
        </p>

        <a href="{{ url('/') }}" class="error-btn">
            <i class="fas fa-arrow-left"></i> Retour à l’accueil
        </a>

    </div>

</div>

<div class="profile-bottom-spacer"></div>

@endsection
