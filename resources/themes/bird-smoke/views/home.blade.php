@extends('layouts.base')

@section('title', trans('messages.home'))

@section('content')
    @php($message = $message ?? null)

    @if(is_string($message) && trim($message) !== '')
        <div class="card mb-4">
            <div class="card-body">
                {{ $message }}
            </div>
        </div>
    @endif
@endsection
