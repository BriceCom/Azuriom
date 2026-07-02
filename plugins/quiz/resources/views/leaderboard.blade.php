@extends('layouts.app')

@section('title', trans('quiz::messages.leaderboard'))

@section('content')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ trans('quiz::messages.leaderboard') }}</h5>
                        <a href="{{ route('quiz.home') }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-arrow-left"></i> {{ trans('quiz::messages.back_to_quiz') }}
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ trans('quiz::messages.player') }}</th>
                                    <th scope="col">{{ trans('quiz::messages.points') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($scores as $index => $score)
                                    <tr>
                                        <th scope="row">{{ $index + 1 + ($scores->currentPage() - 1) * $scores->perPage() }}</th>
                                        <td>
                                            <img src="{{ $score->user->getAvatar() }}" class="rounded-circle me-2" alt="{{ $score->user->name }}" width="32" height="32">
                                            {{ $score->user->name }}
                                        </td>
                                        <td>{{ $score->score }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $scores->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
