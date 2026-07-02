@extends('admin.layouts.admin')

@section('title', trans('tasks::admin.statuses.create'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('tasks::admin.statuses.create') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('tasks.admin.statuses.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">{{ trans('tasks::admin.fields.name') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="color" class="form-label">{{ trans('tasks::admin.fields.color') }}</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <input type="color" id="color-picker" value="{{ old('color', '#6c757d') }}" class="form-control form-control-color p-0 border-0">
                        </span>
                        <input type="text" class="form-control @error('color') is-invalid @enderror" id="color" name="color" value="{{ old('color', '#6c757d') }}" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$" required>
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">{{ trans('tasks::messages.validation.status.color.format') }}</div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
                <a href="{{ route('tasks.admin.statuses.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> {{ trans('messages.actions.cancel') }}
                </a>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const colorPicker = document.getElementById('color-picker');
                const colorInput = document.getElementById('color');

                // Update text input when color picker changes
                colorPicker.addEventListener('input', function() {
                    colorInput.value = this.value;
                });

                // Update color picker when text input changes
                colorInput.addEventListener('input', function() {
                    if (this.value.match(/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/)) {
                        colorPicker.value = this.value;
                    }
                });
            });
        </script>
    @endpush
@endsection
