@extends('admin.layouts.admin')

@section('title', trans('hunt::admin.hunts.edit', ['hunt' => $hunt->name]))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            <i class="bi bi-gift"></i> {{ $hunt->name }}
            @if($hunt->is_archived)
                <span class="badge bg-dark ms-2">{{ trans('hunt::admin.hunts.archived') }}</span>
            @elseif($hunt->is_active && $hunt->isCurrentlyActive())
                <span class="badge bg-success ms-2">{{ trans('hunt::admin.hunts.active') }}</span>
            @elseif($hunt->is_active)
                <span class="badge bg-info ms-2">{{ trans('messages.scheduled') }}</span>
            @else
                <span class="badge bg-secondary ms-2">{{ trans('hunt::admin.hunts.inactive') }}</span>
            @endif
        </h1>
        <div>
            <a href="{{ route('hunt.admin.hunts.edit', $hunt) }}" class="btn btn-primary me-2">
                <i class="bi bi-pencil"></i> {{ trans('hunt::admin.buttons.edit') }}
            </a>
            <a href="{{ route('hunt.show', $hunt) }}" class="btn btn-outline-success me-2" target="_blank">
                <i class="bi bi-eye"></i> {{ trans('hunt::messages.view_leaderboard_btn') }}
            </a>
            <a href="{{ route('hunt.admin.hunts.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> {{ trans('hunt::admin.buttons.back') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="row mb-4">
                @include('hunt::admin.components._stats_card', [
                    'title' => trans('hunt::admin.hunts.total_claims'),
                    'icon' => 'bi bi-cursor-fill',
                    'value' => $stats['total_claims'] ?? 0
                ])

                @include('hunt::admin.components._stats_card', [
                    'title' => trans('hunt::admin.hunts.total_players'),
                    'icon' => 'bi bi-people',
                    'value' => $stats['unique_participants'] ?? 0
                ])

                @include('hunt::admin.components._stats_card', [
                    'title' => trans('hunt::messages.total_money_given'),
                    'icon' => 'bi bi-currency-dollar',
                    'value' => number_format($stats['total_money'] ?? 0, 2) . ' ' . money_name()
                ])

                @include('hunt::admin.components._stats_card', [
                    'title' => trans('hunt::admin.logs.stats.today'),
                    'icon' => 'bi bi-calendar-day',
                    'value' => $stats['today_claims'] ?? 0
                ])
            </div>


            @if($hunt->rewards->isNotEmpty())
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-gift"></i> {{ trans('hunt::admin.rewards.title') }}
                        </h5>
                        <a href="{{ route('hunt.admin.rewards.create', ['hunt_id' => $hunt->id]) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-plus-lg"></i> {{ trans('hunt::admin.rewards.add_reward') }}
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($hunt->rewards as $reward)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card border @if(!$reward->is_enabled) border-secondary @endif">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title mb-0">{{ $reward->name }}</h6>
                                                @if($reward->is_enabled)
                                                    <span class="badge bg-success">{{ trans('hunt::admin.rewards.enabled') }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ trans('hunt::admin.rewards.disabled') }}</span>
                                                @endif
                                            </div>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    {{ trans('hunt::admin.rewards.fields.chance_percentage') }}: {{ $reward->chances }}%
                                                </small>
                                                @if($reward->money > 0)
                                                    <br><small class="text-success">{{ $reward->money }} {{ money_name() }}</small>
                                                @endif
                                                @if($reward->commands && count($reward->commands) > 0)
                                                    <br><small class="text-info">{{ count($reward->commands) }} {{ trans('hunt::admin.rewards.fields.commands') }}</small>
                                                @endif
                                            </p>
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('hunt.admin.rewards.edit', $reward) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <small class="text-muted align-self-center">{{ $reward->logs()->count() }} {{ trans('hunt::admin.common.claims') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-clock-history"></i> {{ trans('hunt::admin.common.recent_activity') }}
                    </h5>
                    <a href="{{ route('hunt.admin.logs.index', ['hunt_id' => $hunt->id]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-list-ul"></i> {{ trans('hunt::admin.dashboard.view_all') }}
                    </a>
                </div>
                <div class="card-body">
                    @if($recentLogs->isNotEmpty())
                        <div class="list-group list-group-flush">
                            @foreach($recentLogs as $log)
                                <div class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $log->user->getAvatar() }}" alt="{{ $log->user->name }}" class="rounded-circle me-2" width="24" height="24">
                                        <div class="flex-grow-1">
                                            <div class="fw-bold">{{ $log->user->name }}</div>
                                            <small class="text-muted">
                                                @if($log->reward)
                                                    {{ trans('hunt::messages.reward_received', ['reward' => $log->reward->name]) }}
                                                @else
                                                    {{ trans('hunt::messages.no_reward_this_time') }}
                                                @endif
                                                @if($log->money_received > 0)
                                                    - {{ $log->money_received }} {{ money_name() }}
                                                @endif
                                            </small>
                                        </div>
                                        <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-clock-history" style="font-size: 2rem; color: #6c757d;"></i>
                            <p class="mt-2 mb-0 text-muted">{{ trans('hunt::admin.dashboard.no_recent_claims') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="position-sticky top-0 card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning"></i> {{ trans('hunt::admin.common.actions') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('hunt.admin.hunts.edit', $hunt) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> {{ trans('hunt::admin.buttons.edit') }} {{ trans('hunt::admin.hunts.title') }}
                        </a>
                        <a href="{{ route('hunt.admin.rewards.index', ['hunt_id' => $hunt->id]) }}" class="btn btn-outline-primary">
                            <i class="bi bi-gift"></i> {{ trans('hunt::admin.rewards.title') }} ({{ $hunt->rewards()->count() }})
                        </a>
                        <a href="{{ route('hunt.admin.logs.index', ['hunt_id' => $hunt->id]) }}" class="btn btn-outline-info">
                            <i class="bi bi-list-ul"></i> {{ trans('hunt::admin.logs.title') }}
                        </a>
                        @if($hunt->is_archived)
                            <form method="POST" action="{{ route('hunt.admin.hunts.restore', $hunt) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-warning w-100">
                                    <i class="bi bi-arrow-clockwise"></i> {{ trans('hunt::admin.hunts.restore') }}
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('hunt.admin.hunts.archive', $hunt) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-warning w-100" onclick="return confirm('{{ trans('hunt::admin.hunts.confirm_archive') }}')">
                                    <i class="bi bi-archive"></i> {{ trans('hunt::admin.hunts.archive') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    @if($hunt->global_cap && $hunt->global_cap > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-graph-up"></i> {{ trans('hunt::messages.global_progress', [
                        'current' => $stats['total_claims'] ?? 0,
                        'total' => $hunt->global_cap
                    ]) }}
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>{{ trans('hunt::messages.global_progress', [
                        'current' => $stats['total_claims'] ?? 0,
                        'total' => $hunt->global_cap
                    ]) }}</span>
                    <span><strong>{{ $stats['total_claims'] ?? 0 }} / {{ $hunt->global_cap }}</strong></span>
                </div>
                <div class="progress" style="height: 20px;">
                    @php
                        $percentage = $hunt->global_cap > 0 ? min(100, (($stats['total_claims'] ?? 0) / $hunt->global_cap) * 100) : 0;
                    @endphp
                    <div class="progress-bar @if($percentage >= 100) bg-danger @elseif($percentage >= 80) bg-warning @else bg-success @endif"
                         role="progressbar"
                         style="width: {{ $percentage }}%"
                         aria-valuenow="{{ $stats['total_claims'] ?? 0 }}"
                         aria-valuemin="0"
                         aria-valuemax="{{ $hunt->global_cap }}">
                        {{ number_format($percentage, 1) }}%
                    </div>
                </div>
                @if($hunt->hasReachedGlobalCap())
                    <div class="alert alert-warning mt-3 mb-0">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>{{ trans('hunt::admin.hunts.cap_reached') }}</strong> - {{ trans('hunt::messages.hunt_cap_reached') }}
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection
