@extends('layouts.app')

@section('title', trans('messages.home'))

@section('content')
    <div class="home-background d-flex align-items-center justify-content-center flex-column text-white mb-4 rounded-4"
         style="background: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') center / cover no-repeat; min-height: 500px;">
        <h1>{{ trans('messages.welcome', ['name' => site_name()]) }}</h1>

        @if($server)
            @if($server->isOnline())
                <h2>{{ trans_choice('messages.server.online', $server->getOnlinePlayers()) }}</h2>
            @else
                <h2>{{ trans('messages.server.offline') }}</h2>
            @endif

            @if($server->join_url)
                <a href="{{ $server->join_url }}" class="btn btn-secondary btn-lg">
                    {{ trans('messages.server.join') }}
                </a>
            @else
                <h3>{{ $server->fullAddress() }}</h3>
            @endif
        @endif
    </div>

    @if($message)
        <div class="card mb-4">
            <div class="card-body">
                {{ $message }}
            </div>
        </div>
    @endif

    @auth
        @if(auth()->user()->isAdmin())
            <div class="alert alert-info text-center">
                <strong>{{ trans('theme::reborn.admin_notice') }}</strong>
                {{ trans('theme::reborn.no_page_content') }}
                {{ trans('theme::reborn.edit_page_hint') }}
            </div>
        @endif
    @endauth
@endsection
