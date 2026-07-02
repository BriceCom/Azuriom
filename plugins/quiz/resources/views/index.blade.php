@extends('layouts.app')

@section('title', trans('quiz::messages.title'))

@section('content')
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ trans('quiz::messages.title') }}</h5>
                        @if(setting('quiz.leaderboard', true))
                            <a href="{{ route('quiz.leaderboard') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-trophy"></i> {{ trans('quiz::messages.leaderboard') }}
                            </a>
                        @endif
                    </div>
                    <div class="card-body text-center">
                        @guest
                            <div class="alert alert-info text-start">
                                <i class="bi bi-info-circle me-2"></i> {{ trans('quiz::messages.login_to_participate') }}
                            </div>
                        @else
                            @if($userScore)
                                <p class="h5 mb-4 text-end">
                                    <span class="badge bg-primary">
                                        {{ trans('quiz::messages.score', ['score' => $userScore->score]) }}
                                    </span>
                                </p>
                            @endif
                        @endguest

                        @if($delayRemaining)
                            <div class="alert alert-warning text-start">
                                <i class="bi bi-clock-history me-2"></i> {{ trans('quiz::messages.delay_not_elapsed', ['remaining' => $delayRemainingText]) }}
                            </div>
                        @endif

                        @if($question)
                            <div class="quiz-container text-start">
                                <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                                    <h4 class="mb-0">{{ $question->question }}</h4>
                                    <span class="badge bg-{{ $question->difficulty === 'hard' ? 'danger' : ($question->difficulty === 'medium' ? 'warning text-dark' : 'success') }}">
                                        {{ trans('quiz::messages.difficulty.' . $question->difficulty) }}
                                    </span>
                                </div>

                                @if($question->time_limit && !$response && !$adminBlocked && !$delayRemaining)
                                    <div class="alert alert-info d-flex align-items-center justify-content-between" id="quiz-timer" data-remaining="{{ $timerRemaining ?? $question->time_limit }}">
                                        <div>
                                            <i class="bi bi-stopwatch me-2"></i> {{ trans('quiz::messages.time_limit') }}
                                        </div>
                                        <strong class="ms-3" id="quiz-timer-value">--:--</strong>
                                    </div>
                                @endif

                                @if($response)
                                    @php
                                        $status = $response->status ?? ($response->answer && $response->answer->is_correct ? 'correct' : 'wrong');
                                    @endphp
                                    <div class="alert alert-{{ $status === 'correct' ? 'success' : ($status === 'expired' ? 'warning' : 'danger') }}">
                                        <p class="mb-1 h5">
                                            <i class="bi bi-{{ $status === 'correct' ? 'check-circle' : ($status === 'expired' ? 'hourglass-split' : 'x-circle') }} me-2"></i>
                                            <strong>
                                                @if($status === 'correct')
                                                    {{ trans('quiz::messages.correct_answer', ['reward' => $response->reward_payload ? collect($response->reward_payload)->map(fn ($reward) => trans('quiz::messages.reward_' . $reward['type'], ['value' => $reward['value']]))->implode(', ') : trans('quiz::messages.reward_points', ['value' => $question->reward])]) }}
                                                @elseif($status === 'expired')
                                                    {{ trans('quiz::messages.time_expired') }}
                                                @else
                                                    {{ trans('quiz::messages.wrong_answer') }}
                                                @endif
                                            </strong>
                                        </p>
                                        @if($response->answer)
                                            <p class="mb-0 small mt-2 opacity-75">
                                                {{ trans('quiz::admin.fields.answers') }}: {{ $response->answer->answer }}
                                            </p>
                                        @endif
                                    </div>
                                @elseif(!Auth::check() || $adminBlocked || $delayRemaining)
                                    <div class="list-group mb-4 shadow-sm">
                                        @foreach($question->answers as $answer)
                                            <div class="list-group-item py-3">
                                                {{ $answer->answer }}
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($adminBlocked)
                                        <div class="alert alert-warning">
                                            <i class="bi bi-exclamation-triangle me-2"></i> {{ trans('quiz::messages.admin_not_allowed') }}
                                        </div>
                                    @endif
                                @else
                                    <form action="{{ route('quiz.answer', $question) }}" method="POST" id="quiz-form">
                                        @csrf
                                        <div class="list-group mb-4 shadow-sm">
                                            @foreach($question->answers as $answer)
                                                <label class="list-group-item list-group-item-action cursor-pointer py-3">
                                                    <input class="form-check-input me-3" type="radio" name="answer" value="{{ $answer->id }}" required>
                                                    {{ $answer->answer }}
                                                </label>
                                            @endforeach
                                        </div>

                                        <input type="hidden" name="expired" id="quiz-expired" value="0">

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                                <i class="bi bi-send me-2"></i> {{ trans('quiz::messages.submit') }}
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        @else
                            <div class="py-5">
                                <i class="bi bi-patch-question h1 text-muted"></i>
                                <p class="lead mt-3">{{ trans('quiz::messages.no_quiz') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-scripts')
    <script>
        const timerWrapper = document.getElementById('quiz-timer');
        const timerValue = document.getElementById('quiz-timer-value');
        const quizForm = document.getElementById('quiz-form');
        const quizExpiredInput = document.getElementById('quiz-expired');

        if (timerWrapper && timerValue) {
            let remaining = parseInt(timerWrapper.dataset.remaining || '0', 10);
            const updateTimer = () => {
                if (remaining <= 0) {
                    timerValue.textContent = '00:00';
                    if (quizExpiredInput) {
                        quizExpiredInput.value = '1';
                    }
                    if (quizForm) {
                        quizForm.submit();
                    }
                    return;
                }

                const minutes = Math.floor(remaining / 60);
                const seconds = remaining % 60;
                timerValue.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                remaining -= 1;
                setTimeout(updateTimer, 1000);
            };

            updateTimer();
        }
    </script>
@endpush
