@extends('layouts.app')

@section('title', trans('trackurl::messages.blocked.title'))

@section('content')
    <div class="container content">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h3 class="card-title mb-0">{{ trans('trackurl::messages.blocked.title') }}</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-danger">
                    <i class="bi bi-shield-exclamation me-2"></i>
                    {{ trans('trackurl::messages.blocked.message') }}
                </div>
                <p>{{ trans('trackurl::messages.blocked.explanation') }}</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-house-door"></i> {{ trans('messages.home') }}
                </a>
            </div>
        </div>
    </div>
@endsection
