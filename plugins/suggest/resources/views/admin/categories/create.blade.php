@extends('admin.layouts.admin')

@section('title', trans('suggest::admin.categories.create'))

@include('admin.elements.color-picker')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('suggest.admin.categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name">{{ trans('messages.fields.name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>

                    @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description">{{ trans('messages.fields.description') }}</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>

                    @error('description')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="colorInput">{{ trans('messages.fields.color') }}</label>
                    <input type="color" class="form-control form-control-color color-picker @error('color') is-invalid @enderror" id="colorInput" name="color" value="{{ old('color', '#2196f3') }}" required>

                    @error('color')
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
