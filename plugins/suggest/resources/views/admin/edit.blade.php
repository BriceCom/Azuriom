@extends('admin.layouts.admin')

@section('title', trans('suggest::admin.suggestions.title'))

@include('admin.elements.editor')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('suggest.admin.update', $suggestion) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title">{{ trans('messages.fields.title') }}</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $suggestion->title) }}" required>

                    @error('title')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content">{{ trans('messages.fields.content') }}</label>
                    <textarea class="form-control html-editor @error('content') is-invalid @enderror" id="content" name="content" rows="5" required>{{ old('content', $suggestion->content) }}</textarea>

                    @error('content')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id">{{ trans('suggest::messages.fields.category') }}</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        <option value="" disabled>{{ trans('suggest::messages.fields.select_category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $suggestion->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status">{{ trans('messages.fields.status') }}</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="pending" @selected(old('status', $suggestion->status) === 'pending')>{{ trans('suggest::messages.status.pending') }}</option>
                        <option value="approved" @selected(old('status', $suggestion->status) === 'approved')>{{ trans('suggest::messages.status.approved') }}</option>
                        <option value="rejected" @selected(old('status', $suggestion->status) === 'rejected')>{{ trans('suggest::messages.status.rejected') }}</option>
                    </select>
                    @error('status')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3 @if(old('status', $suggestion->status) !== 'rejected') d-none @endif" id="refusalReasonGroup">
                    <label for="refusal_reason">{{ trans('suggest::admin.suggestions.refusal_reason') }}</label>
                    <textarea class="form-control @error('refusal_reason') is-invalid @enderror" id="refusal_reason" name="refusal_reason" rows="3">{{ old('refusal_reason', $suggestion->refusal_reason) }}</textarea>

                    @error('refusal_reason')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>{{ trans('messages.fields.author') }}</label>
                    <div>{{ $suggestion->user->name }}</div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection

@push('footer-scripts')
    <script>
        const statusSelect = document.getElementById('status');
        const refusalReasonInput = document.getElementById('refusal_reason');
        const refusalReasonGroup = document.getElementById('refusalReasonGroup');

        statusSelect.addEventListener('change', function () {
            if (this.value === 'rejected') {
                refusalReasonGroup.classList.remove('d-none');
            } else {
                refusalReasonGroup.classList.add('d-none');
            }
        });

        refusalReasonInput.addEventListener('input', function () {
            if (this.value.trim().length > 0) {
                statusSelect.value = 'rejected';
                refusalReasonGroup.classList.remove('d-none');
            }
        });
    </script>
@endpush
