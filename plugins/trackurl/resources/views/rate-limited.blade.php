@extends('layouts.app')

@section('title', trans('trackurl::messages.rate_limit.title'))

@section('content')
    <div class="container content">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h3 class="card-title mb-0">{{ trans('trackurl::messages.rate_limit.title') }}</h3>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ trans('trackurl::messages.rate_limit.message', ['minutes' => $minutes]) }}
                </div>
                <p>{{ trans('trackurl::messages.rate_limit.explanation') }}</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-house-door"></i> {{ trans('messages.home') }}
                </a>
            </div>
        </div>
    </div>
@endsection
