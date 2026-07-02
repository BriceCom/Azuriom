@extends('admin.layouts.admin')

@section('title', trans('seolite::messages.analyses'))

@section('content')
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card border-left-primary h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="card-title"><i class="bi bi-file-text text-primary"></i> {{ trans('seolite::messages.articles') }}</h5>
                            <p class="card-text">{{ trans('seolite::messages.articles_analysis_desc') }}</p>
                            <a href="{{ route('seolite.admin.analyses.articles') }}" class="btn btn-primary">
                                <i class="bi bi-bar-chart me-2"></i>
                                {{ trans('seolite::messages.view_articles_analysis') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="position-relative card bg-warning bg-opacity-10 border border-warning h-100" style="z-index: 0;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="position-absolute end-0 top-50 translate-middle-y mr-5 opacity-25" style="z-index: -1;">
                            <i class="bi bi-rocket text-warning" style="font-size: 8rem;"></i>
                        </div>
                        <div>
                            <h5 class="card-title">{{ trans('seolite::messages.seo_pro_title') }}</h5>
                            <p class="small">{{ trans('seolite::messages.seo_pro_description') }}</p>
                            <button class="btn btn-warning disabled">
                                {{ trans('seolite::messages.coming_soon') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title mb-0">{{ trans('seolite::messages.next_plans_title') }}</h3>
        </div>
        <div class="card-body">
            <p class="mb-4">{{ trans('seolite::messages.next_plans_intro') }}</p>
            @include('seolite::components.next-plans.list')
        </div>
    </div>
@endsection
