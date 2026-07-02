@extends('layouts.app')

@section('title', trans('achievement::messages.profile.title'))

@section('content')
    <div class="container content">
        <h1>{{ trans('achievement::messages.profile.title') }}</h1>

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        @if(achievement_trophy_image())
                            <img src="{{ achievement_trophy_image_url() }}" alt="{{ achievement_trophy_name() }}" class="me-3" width="40" height="40">
                        @else
                            <i class="{{ achievement_trophy_icon() }} fs-1 me-3"></i>
                        @endif
                        <div>
                            <h5 class="card-title mb-0">{{ achievement_trophy_name() }}</h5>
                            <p class="card-text">{{ trans('achievement::messages.trophies.count', ['count' => achievement_user_trophy_points(auth()->user()), 'name' => achievement_trophy_name()]) }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('achievement.home') }}" class="btn btn-primary">
                            <i class="bi bi-trophy"></i> {{ trans('achievement::messages.leaderboard.leaderboard') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @include('achievement::components.objective.sidebar')

            <div class="col-lg-9">
                <div class="tab-content" id="objectives-tabContent">
                    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                        @if($all->isEmpty())
                            <div class="alert alert-info">
                                {{ trans('achievement::messages.profile.no_objectives') }}
                            </div>
                        @else
                            <div class="row">
                                @foreach($all as $userObjective)
                                    @include('achievement::components.objective._card', ['userObjective' => $userObjective])
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                        @if($completed->isEmpty())
                            <div class="alert alert-info">
                                {{ trans('achievement::messages.profile.no_completed') }}
                            </div>
                        @else
                            <div class="row">
                                @foreach($completed as $userObjective)
                                    @include('achievement::components.objective._card', ['userObjective' => $userObjective])
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="claimed" role="tabpanel" aria-labelledby="claimed-tab">
                        @if($claimed->isEmpty())
                            <div class="alert alert-info">
                                {{ trans('achievement::messages.profile.no_claimed') }}
                            </div>
                        @else
                            <div class="row">
                                @foreach($claimed as $userObjective)
                                    @include('achievement::components.objective._card', ['userObjective' => $userObjective])
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
