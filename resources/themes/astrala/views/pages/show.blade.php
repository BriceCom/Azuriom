@extends('layouts.app')

@section('title', $page->title)
@section('description', $page->description)

@section('content')
    <h1>{{ $page->title }}</h1>
    <p class="w-75 opacity-75 mx-auto text-center">{{ $page->description }}</p>
    @if(request()->route()->parameters['path'] === "reglements")
        <a href="{{ theme_asset('pdf/'.(theme_config('reglement.filename') ?? 'reglement.pdf')) }}" download target="_blank" rel="noopener noreferrer" class="w-fit d-flex justify-content-center align-items-center btn btn-primary mx-auto">
            {{theme_config('reglement.filetitle') ?? 'Télécharger en .pdf'}}
        </a>
    @endif

    <div class="card">
        <div class="card-body">
            {!! $page->content !!}
            @if(request()->route()->parameters['path'] === "reglements")
                <a href="{{ theme_asset('pdf/'.(theme_config('reglement.filename') ?? 'reglement.pdf')) }}" download target="_blank" rel="noopener noreferrer" class="w-fit d-flex justify-content-center align-items-center btn btn-primary me-auto mt-8">
                    {{theme_config('reglement.filetitle') ?? 'Télécharger en .pdf'}}
                </a>
            @endif
        </div>
    </div>
@endsection
