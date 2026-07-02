@extends('layouts.app')

@section('title', trans('daily-reward::messages.title'))

@section('content')
    <h1>{{ trans('daily-reward::messages.title') }}</h1>

    @if(! $enabled)
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> {{ trans('daily-reward::messages.disabled') }}
        </div>
    @elseif($status === null)
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> {{ trans('daily-reward::messages.login_required') }}
        </div>
    @else
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <div class="text-muted small">{{ trans('daily-reward::messages.fields.streak') }}</div>
                        <div class="fs-4 fw-semibold">{{ $status['streak'] }}</div>
                    </div>

                    <div class="col-md-3">
                        <div class="text-muted small">{{ trans('daily-reward::messages.fields.max_streak') }}</div>
                        <div class="fs-4 fw-semibold">{{ $status['max_streak'] }}</div>
                    </div>

                    <div class="col-md-3">
                        <div class="text-muted small">{{ trans('daily-reward::messages.fields.next_day') }}</div>
                        <div class="fs-4 fw-semibold">{{ $status['next_day_number'] }}</div>
                    </div>

                    <div class="col-md-3 text-md-end">
                        @if($status['can_claim'])
                            <form action="{{ route('daily-reward.claim') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-gift"></i> {{ trans('daily-reward::messages.actions.claim') }}
                                </button>
                            </form>
                        @else
                            <div class="text-muted small">{{ trans('daily-reward::messages.fields.next_claim') }}</div>
                            <div>{{ $status['next_claim_at'] ? format_date_compact($status['next_claim_at']) : trans('messages.unknown') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($leaderboardEnabled)
        <div class="mb-3 text-end">
            <a href="{{ route('daily-reward.leaderboard') }}" class="btn btn-outline-primary">
                <i class="bi bi-trophy"></i> {{ trans('daily-reward::messages.actions.leaderboard') }}
            </a>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ trans('daily-reward::messages.cycle.title') }}</h5>
        </div>
        <div class="card-body p-0">
            @if($days->isEmpty())
                <div class="p-3 text-muted">{{ trans('daily-reward::messages.cycle.empty') }}</div>
            @else
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                        <tr>
                            <th>{{ trans('daily-reward::messages.fields.day') }}</th>
                            <th>{{ trans('daily-reward::messages.fields.label') }}</th>
                            <th>{{ trans('daily-reward::messages.fields.rewards') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($days as $day)
                            @php
                                $isCurrent = $status !== null && $status['next_day_number'] === $day->day_number;
                                $isClaimed = $status !== null && $claimedDays->contains($day->day_number) && ! $isCurrent;
                            @endphp
                            <tr @class([
                                'table-primary' => $isCurrent,
                                'table-success' => $isClaimed,
                            ])>
                                <td>{{ $day->day_number }}</td>
                                <td>{{ $day->label ?? trans('daily-reward::messages.day_label', ['day' => $day->day_number]) }}</td>
                                <td>
                                    @if($isClaimed)
                                        <span class="badge bg-success me-1">{{ trans('daily-reward::messages.states.claimed') }}</span>
                                    @elseif($isCurrent && $status !== null && $status['can_claim'])
                                        <span class="badge bg-primary me-1">{{ trans('daily-reward::messages.states.available') }}</span>
                                    @elseif($isCurrent)
                                        <span class="badge bg-secondary me-1">{{ trans('daily-reward::messages.states.cooldown') }}</span>
                                    @else
                                        <span class="badge bg-light text-dark border me-1">{{ trans('daily-reward::messages.states.locked') }}</span>
                                    @endif

                                    @if($day->rewards->isEmpty())
                                        <span class="text-muted">{{ trans('messages.none') }}</span>
                                    @else
                                        @foreach($day->rewards as $reward)
                                            <span class="badge bg-light text-dark border me-1 mb-1">
                                                @if($reward->type === \Azuriom\Plugin\DailyReward\Models\DailyRewardReward::TYPE_MONEY)
                                                    {{ trans('daily-reward::messages.reward.money', ['money' => $reward->money]) }}
                                                @elseif($reward->type === \Azuriom\Plugin\DailyReward\Models\DailyRewardReward::TYPE_COMMAND)
                                                    {{ trans('daily-reward::messages.reward.commands_count', ['count' => count($reward->commands ?? [])]) }}
                                                @else
                                                    {{ $reward->name }}
                                                @endif
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
