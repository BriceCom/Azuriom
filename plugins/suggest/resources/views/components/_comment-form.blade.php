@auth
    @if($suggestion->status === 'pending')
        <div class="comment-form mt-5 pt-5 border-top">
            <form method="POST" action="{{ route('suggest.comments.store', $suggestion) }}">
                @csrf
                <div class="mb-3">
                    <label for="content" class="form-label">{{ trans('suggest::messages.comments.add') }}</label>
                    <textarea class="form-control html-editor @error('content') is-invalid @enderror"
                              id="content"
                              name="content"
                              rows="4">{{ old('content') }}</textarea>
                    @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    {{ trans('suggest::messages.comments.submit') }}
                </button>
            </form>
        </div>
    @else
        <div class="alert alert-info mt-3">
            <i class="bi bi-info-circle"></i> {{ trans('suggest::messages.comments.closed') }}
        </div>
    @endif
@else
    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle"></i> {{ trans('suggest::messages.comments.login_required') }}
        <a href="{{ route('login') }}" class="btn btn-sm btn-primary ms-2">{{ trans('auth.login') }}</a>
    </div>
@endauth
