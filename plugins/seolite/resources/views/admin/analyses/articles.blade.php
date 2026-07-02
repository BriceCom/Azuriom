@extends('admin.layouts.admin')

@section('title', trans('seolite::messages.articles'))

@section('content')

    @if($posts->count() > 0)
        <div class="row">
            <div class="col-sm-6 col-xxl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title mb-0">{{ trans('seolite::messages.total_articles') }}</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat text-primary h3">
                                    <i class="bi bi-newspaper"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ $posts->total() }}</h1>
                    </div>
                </div>
            </div>

            @php
                $avgFleschScore = $posts->avg(function($post) { return $post->seo_data['flesch_score']; });
            @endphp
            <div class="col-sm-6 col-xxl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title mb-0">{{ trans('seolite::messages.avg_flesch_score') }}</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat text-primary h3">
                                    <i class="bi bi-book"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ round($avgFleschScore) }}/100</h1>
                    </div>
                </div>
            </div>

            @php
                $needsImprovement = $posts->filter(function($post) {
                    return $post->seo_data['text_counter_score'] < 70 || $post->seo_data['flesch_score'] < 60;
                })->count();
            @endphp
            <div class="col-sm-6 col-xxl-3">
                <div class="card bg-danger bg-opacity-10 border border-danger">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title mb-0">{{trans('seolite::messages.posts_need_improvement')}}</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat bg-danger bg-opacity-10 text-danger h3">
                                    <i class="bi bi-cone-striped"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{$needsImprovement}}</h1>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">{{ trans('seolite::messages.articles') }} - {{ trans('seolite::messages.seo_analysis') }}</h6>
                    <div class="d-flex align-items-center">
                        <form method="GET" action="{{ route('seolite.admin.analyses.articles') }}" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm me-2"
                                   placeholder="{{ trans('seolite::messages.search_articles_placeholder') }}" value="{{ $search }}" style="width: 200px;">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                            @if($search)
                                <a href="{{ route('seolite.admin.analyses.articles') }}" class="btn btn-sm btn-secondary ms-1">
                                    <i class="bi bi-x"></i>
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if($posts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col" width="60">#</th>
                                        <th scope="col">{{ trans('seolite::messages.post_title') }}</th>
                                        <th scope="col" width="140" class=" text-nowrap">{{ trans('seolite::messages.published_at') }}</th>
                                        <th scope="col" width="140" class=" text-nowrap">{{ trans('seolite::messages.text_counter_score') }}</th>
                                        <th scope="col" width="140" class="text-center">{{ trans('seolite::messages.flesch_score') }}</th>
                                        <th scope="col" width="100" class="text-center">{{ trans('messages.fields.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $post)
                                        <tr>
                                            <th scope="row">{{ $post->id }}</th>
                                            <td>
                                                <strong>{{ Str::limit($post->title, 60) }}</strong>
                                            </td>
                                            <td>
                                                {{ $post->published_at }}
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $textScore = $post->seo_data['text_counter_score'];
                                                    $textScoreClass = $textScore >= 70 ? 'success' : ($textScore >= 40 ? 'warning' : 'danger');
                                                @endphp
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="badge bg-{{ $textScoreClass }}">{{ $textScore }}/100</span>
                                                    <small class="text-muted mt-1">{{ $post->seo_data['word_count'] }} {{ trans('seolite::messages.words_suffix') }}</small>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $fleschScore = $post->seo_data['flesch_score'];
                                                    $fleschClass = $fleschScore >= 60 ? 'success' : ($fleschScore >= 40 ? 'warning' : 'danger');
                                                    $fleschLevel = $fleschScore >= 80 ? trans('seolite::messages.very_easy') :
                                                                  ($fleschScore >= 60 ? trans('seolite::messages.easy') :
                                                                  ($fleschScore >= 40 ? trans('seolite::messages.standard') :
                                                                  ($fleschScore >= 20 ? trans('seolite::messages.difficult') : trans('seolite::messages.very_difficult'))));
                                                @endphp
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="badge bg-{{ $fleschClass }}">{{ $fleschScore }}/100</span>
                                                    <small class="text-muted mt-1">{{ $fleschLevel }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary btn-sm"
                                                   title="{{ trans('seolite::messages.edit_post') }}" data-bs-toggle="tooltip">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-info btn-sm"
                                                   title="{{ trans('messages.actions.show') }}" data-bs-toggle="tooltip" target="_blank">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                {{ trans('seolite::messages.pagination_showing', ['from' => $posts->firstItem(), 'to' => $posts->lastItem(), 'total' => $posts->total()]) }}
                            </div>
                            {{ $posts->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-file-earmark-text fs-1 text-muted mb-3"></i>
                            <h5 class="text-muted">{{ trans('seolite::messages.no_posts_found') }}</h5>
                            @if($search)
                                <p class="text-muted">{{ trans('seolite::messages.no_articles_found_matching', ['search' => $search]) }}</p>
                                <a href="{{ route('seolite.admin.analyses.articles') }}" class="btn btn-primary">
                                    {{ trans('seolite::messages.view_all_articles') }}
                                </a>
                            @else
                                <p class="text-muted">{{ trans('seolite::messages.create_first_post_cta') }}</p>
                                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus me-2"></i>
                                    {{ trans('seolite::messages.create_new_post') }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
