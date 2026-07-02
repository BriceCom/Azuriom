@extends('admin.layouts.admin')

@section('title', trans('seolite::messages.admin_dashboard'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title mb-0">{{ trans('seolite::messages.introduction') }}</h3>
                    </div>
                    <div class="card-body">
                        <h3>{{ trans('seolite::messages.seo_not_exact_science') }}</h3>
                        <p>{{ trans('seolite::messages.plugin_description') }}</p>
                    </div>
                </div>

                <!-- The 3 Pillars of SEO Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title mb-0">{{ trans('seolite::messages.three_pillars_seo') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img class="img-fluid" alt="{{ trans('seolite::messages.three_pillars_seo') }}" src="{{ plugin_asset('seolite', '/img/seo_explain.webp')}}" width="750"/>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <h2>{{ trans('seolite::messages.content_pillar') }}</h2>
                                    <p class="mb-0">{{ trans('seolite::messages.content_pillar_desc') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <h2>{{ trans('seolite::messages.technical_pillar') }}</h2>
                                    <p class="mb-0">{{ trans('seolite::messages.technical_pillar_desc') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-3 h-100">
                                    <h2>{{ trans('seolite::messages.popularity_pillar') }}</h2>
                                    <p class="mb-0">{{ trans('seolite::messages.popularity_pillar_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title mb-0">{{ trans('seolite::messages.general_recommendations') }}</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">{{ trans('seolite::messages.tips_intro') }}</p>
                        <ul>
                            <li class="mb-2">{{ trans('seolite::messages.tip_optimize_images') }}</li>
                            <li class="mb-2">{{ trans('seolite::messages.tip_title_length') }}</li>
                            <li class="mb-2">{!! trans('seolite::messages.tip_list_site') !!}</li>
                            <li class="mb-2">{{ trans('seolite::messages.tip_content_length') }}</li>
                            <li class="mb-2">{{ trans('seolite::messages.tip_test_speed') }}</li>
                        </ul>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <p>{{ trans('seolite::messages.lite_version_limitation') }}</p>
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                            {{ trans('seolite::messages.analyze_page_now') }}
                        </a>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title mb-0">{{ trans('seolite::messages.next_plans_title') }}</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-4">{{ trans('seolite::messages.next_plans_intro') }}</p>
                        @include('seolite::components.next-plans.list')
                    </div>
                </div>

                <div class="alert alert-info">
                    <h5 class="alert-heading">{{ trans('seolite::messages.seo_takes_time') }}</h5>
                    <p class="mb-0">{{ trans('seolite::messages.seo_focus_advice') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
