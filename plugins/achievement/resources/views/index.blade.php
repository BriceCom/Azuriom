@extends('layouts.app')

@section('title', setting('achievement.leaderboard_title', 'Leaderboard'))

@section('content')
    <h1>{{ setting('achievement.leaderboard_title', 'Leaderboard') }}</h1>

    <div class="card">
        <div class="card-body">
            <h2 class="card-title">
                {{ trans('achievement::messages.leaderboard.top', ['count' => $topUsers->count()]) }}
            </h2>

            <table class="table mb-0">
                <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ trans('messages.fields.name') }}</th>
                    <th scope="col">{{ trans('achievement::messages.leaderboard.points', ['name' => achievement_trophy_name()]) }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($topUsers as $index => $user)
                    <tr class="align-middle">
                        <th scope="row">#{{ $index + 1 }}</th>
                        <td><div class="d-flex align-items-center gap-1">
                                <img src="{{ $user->getAvatar(32) }}" alt="{{ $user->name }}" style="width: 32px; height: 32px;">
                                {{ $user->name }}
                            </div></td>
                        <td>{{ $user->trophy_points }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            @if($topUsers->isEmpty())
                <div class="alert alert-info mt-3" role="alert">
                    {{ trans('achievement::messages.leaderboard.empty', ['name' => achievement_trophy_name()]) }}
                </div>
            @endif

            @auth
                <p class="mt-3 mb-0">{{ trans('achievement::messages.leaderboard.your_position', ['position' => $userPosition ?? '—', 'points' => $userTrophyPoints, 'name' => achievement_trophy_name()]) }}</p>
            @endauth
        </div>
    </div>
@endsection
