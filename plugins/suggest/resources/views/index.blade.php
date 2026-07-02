@extends('layouts.app')

@section('title', trans('suggest::messages.title'))

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
        <hgroup class="mb-4">
            <h1>{{ setting('suggest.index.title', trans('suggest::messages.title')) }}</h1>
            <p>{{ setting('suggest.index.subtitle', trans('suggest::messages.description')) }}</p>
        </hgroup>

        <div class="row">
            <!-- Sidebar / Filters -->
            <div class="col-lg-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-funnel-fill"></i> {{ trans('suggest::messages.actions.filter') }}
                    </div>
                   <div class="card-body">
                       @include('suggest::components.filters', [
                           'filter' => $filter,
                           'categories' => $categories,
                           'selectedCategory' => $selectedCategory,
                           'categoryQuery' => $categoryQuery,
                           'disableCategoryFilters' => $disableCategoryFilters,
                       ])
                   </div>
                </div>

                <div class="mt-3">
                    @auth
                        @php
                            $createQuery = ['filter' => $filter];
                            if (!empty($selectedCategory)) {
                                $createQuery['category'] = $selectedCategory;
                            }
                        @endphp
                        <a href="{{ route('suggest.create', $createQuery) }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> {{ trans('suggest::messages.create') }}
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                @if($suggestions->isEmpty())
                    <div class="alert alert-info" role="alert">
                        <i class="bi bi-info-circle"></i> {{ trans('suggest::messages.empty') }}
                    </div>
                @else
                    <div class="d-flex flex-column gap-4">
                        @foreach($suggestions as $suggestion)
                            @include('suggest::components.suggest-card', ['suggestion' => $suggestion])
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $suggestions->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
