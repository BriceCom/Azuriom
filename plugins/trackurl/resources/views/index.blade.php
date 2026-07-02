@extends('layouts.app')

@section('title', trans('trackurl::messages.title'))

@section('content')
    <div class="container content">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h3 class="card-title mb-0">{{ trans('trackurl::messages.title') }}</h3>
            </div>
            <div class="card-body">
                <p class="card-text">{{ trans('trackurl::messages.description') }}</p>

                <div class="alert alert-info">
                    <p>{{ trans('trackurl::messages.your_link') }}</p>
                    <div class="input-group mt-2">
                        <input type="text" class="form-control" id="shortUrl" value="{{ route('trackurl.index') }}" readonly>
                        <button class="btn btn-outline-primary" type="button" id="copyButton" onclick="copyToClipboard()">
                            <i class="bi bi-clipboard"></i> {{ trans('trackurl::messages.copy') }}
                        </button>
                    </div>
                </div>

                <p>{{ trans('trackurl::messages.no_links') }}</p>

                @auth
                    @if(auth()->user()->can('admin.access'))
                        <a href="{{ route('trackurl.admin.index') }}" class="btn btn-primary">
                            <i class="bi bi-gear"></i> {{ trans('messages.admin.title') }}
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function copyToClipboard() {
            const copyText = document.getElementById("shortUrl");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");

            const copyButton = document.getElementById("copyButton");
            const originalHTML = copyButton.innerHTML;
            copyButton.innerHTML = '<i class="bi bi-clipboard-check"></i> {{ trans('trackurl::messages.copied') }}';

            setTimeout(function() {
                copyButton.innerHTML = originalHTML;
            }, 2000);
        }
    </script>
@endpush
