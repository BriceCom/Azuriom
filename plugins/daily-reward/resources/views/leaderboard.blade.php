@extends('layouts.app')

@section('title', trans('daily-reward::messages.leaderboard.title'))

@section('content')
    <h1>{{ trans('daily-reward::messages.leaderboard.title') }}</h1>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ trans('daily-reward::messages.leaderboard.current') }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('messages.fields.user') }}</th>
                                <th>{{ trans('daily-reward::messages.fields.streak') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($current as $index => $entry)
                                <tr @class(['table-primary' => auth()->check() && auth()->id() === $entry->user_id])>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $entry->user->name ?? trans('messages.unknown') }}</td>
                                    <td>{{ $entry->streak_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted">{{ trans('messages.none') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ trans('daily-reward::messages.leaderboard.best') }}</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('messages.fields.user') }}</th>
                                <th>{{ trans('daily-reward::messages.fields.max_streak') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($best as $index => $entry)
                                <tr @class(['table-primary' => auth()->check() && auth()->id() === $entry->user_id])>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $entry->user->name ?? trans('messages.unknown') }}</td>
                                    <td>{{ $entry->max_streak }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-muted">{{ trans('messages.none') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
