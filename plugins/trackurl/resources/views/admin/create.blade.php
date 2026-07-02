@extends('admin.layouts.admin')

@section('title', trans('trackurl::admin.links.create'))

@section('content')

    <a href="{{ route('trackurl.admin.index') }}" class="btn btn-secondary mb-4">
        <i class="bi bi-arrow-left"></i> {{ trans('messages.actions.back') }}
    </a>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('trackurl.admin.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="nameInput">{{ trans('trackurl::admin.fields.name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name') }}" required>

                    @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="destinationUrlInput">{{ trans('trackurl::admin.fields.destination_url') }}</label>
                    <input type="url" class="form-control @error('destination_url') is-invalid @enderror" id="destinationUrlInput" name="destination_url" value="{{ old('destination_url') }}" required>

                    @error('destination_url')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="shortCodeInput">{{ trans('trackurl::admin.fields.short_code') }}</label>
                    <input type="text" class="form-control @error('short_code') is-invalid @enderror" id="shortCodeInput" name="short_code" value="{{ old('short_code') }}">
                    <small class="form-text text-muted">{{ trans('trackurl::admin.fields.short_code_help') }}</small>

                    @error('short_code')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
