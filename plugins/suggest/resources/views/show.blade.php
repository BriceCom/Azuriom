@extends('layouts.app')

@section('title', $suggestion->title)

@include('admin.elements.editor')

@push('scripts')
    <script src="{{ plugin_asset('suggest', 'js/suggest.js') }}"></script>
    <script>
        // Set translation variables for the JavaScript
        upvoteText = "{{ trans('suggest::messages.upvote') }}";
        downvoteText = "{{ trans('suggest::messages.downvote') }}";
        upvotedText = "{{ trans('suggest::messages.upvoted') }}";
        downvotedText = "{{ trans('suggest::messages.downvoted') }}";
    </script>
@endpush

@section('content')
    <div class="container content">
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('suggest.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> {{ trans('suggest::messages.back') }}
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                @if($suggestion->status === 'rejected' && $suggestion->refusal_reason)
                    <div class="card mb-3">
                        <div class="card-header text-danger">
                            <i class="bi bi-x-circle-fill"></i> {{ trans('suggest::messages.refusal_reason') }}
                        </div>

                        <div class="card-body">
                            <div class="wysiwyg-content">
                                {!! $suggestion->refusal_reason !!}
                            </div>
                        </div>
                    </div>
                @endif

                @include('suggest::components.suggest-card', ['suggestion' => $suggestion, 'show' => true])
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-info-circle"></i> {{ trans('suggest::messages.info') }}
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ trans('messages.fields.status') }}</span>
                                <span
                                    class="badge bg-{{ $suggestion->status === 'approved' ? 'success' : ($suggestion->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ trans('suggest::messages.status.' . $suggestion->status) }}
                            </span>
                            </div>
                            @if($suggestion->category)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ trans('suggest::messages.fields.category') }}</span>
                                    <span class="badge"
                                          style="background-color: {{ $suggestion->category->color }}">{{ $suggestion->category->name }}</span>
                                </div>
                            @endif
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ trans('messages.fields.date') }}</span>
                                <span>{{ $suggestion->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ trans('messages.fields.author') }}</span>
                                <span>{{ $suggestion->user->name }}</span>
                            </div>

                            @can('destroy', $suggestion)
                                @if($suggestion->upvotes_count < 1 || $suggestion->downvotes_count < 1)
                                    <form method="POST"
                                          action="{{ route('suggest.destroy', $suggestion) }}">
                                        @method('DELETE')
                                        @csrf

                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                                        </button>
                                    </form>
                                @endif
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('suggest::components.comments', ['suggestion' => $suggestion])
    </div>
@endsection
