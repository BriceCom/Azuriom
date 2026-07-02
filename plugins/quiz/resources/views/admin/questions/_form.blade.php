@csrf

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="questionInput">{{ trans('quiz::admin.fields.question') }}</label>
            <input type="text" class="form-control @error('question') is-invalid @enderror" id="questionInput" name="question" value="{{ old('question', $question->question ?? '') }}" required>
            @error('question')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label" for="difficultySelect">{{ trans('quiz::admin.fields.difficulty') }}</label>
            <select class="form-select @error('difficulty') is-invalid @enderror" id="difficultySelect" name="difficulty" required>
                <option value="easy" @selected(old('difficulty', $question->difficulty ?? 'easy') === 'easy')>{{ trans('quiz::admin.difficulties.easy') }}</option>
                <option value="medium" @selected(old('difficulty', $question->difficulty ?? 'easy') === 'medium')>{{ trans('quiz::admin.difficulties.medium') }}</option>
                <option value="hard" @selected(old('difficulty', $question->difficulty ?? 'easy') === 'hard')>{{ trans('quiz::admin.difficulties.hard') }}</option>
            </select>
            @error('difficulty')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label" for="rewardInput">{{ trans('quiz::admin.fields.reward') }}</label>
            <input type="number" class="form-control @error('reward') is-invalid @enderror" id="rewardInput" name="reward" value="{{ old('reward', $question->reward ?? 0) }}" min="0" required>
            @error('reward')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="dateInput">{{ trans('quiz::admin.fields.activation_date') }}</label>
            <input type="date" class="form-control @error('activation_date') is-invalid @enderror" id="dateInput" name="activation_date" value="{{ old('activation_date', isset($question) ? $question->activation_date->format('Y-m-d') : '') }}" required>
            @error('activation_date')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label" for="timeLimitInput">{{ trans('quiz::admin.fields.time_limit') }}</label>
            <input type="number" class="form-control @error('time_limit') is-invalid @enderror" id="timeLimitInput" name="time_limit" value="{{ old('time_limit', $question->time_limit ?? '') }}" min="1">
            @error('time_limit')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label">{{ trans('quiz::admin.questions.status') }}</label>
            <div class="form-check form-switch">
                <input type="hidden" name="is_active" value="0">
                <input class="form-check-input" type="checkbox" id="activeSwitch" name="is_active" value="1" @checked(old('is_active', $question->is_active ?? true))>
                <label class="form-check-label" for="activeSwitch">{{ trans('quiz::admin.questions.active') }}</label>
            </div>
        </div>
    </div>
</div>

<hr>

<h5 class="mb-3">{{ trans('quiz::admin.fields.answers') }}</h5>

<div id="answersContainer">
    @for($i = 0; $i < 4; $i++)
        <div class="mb-3 answer-group {{ $i >= 2 && !isset($question->answers[$i]) && !old('answers.'.$i) ? 'd-none' : '' }}" id="answer-{{ $i }}">
            <div class="input-group">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="radio" name="correct_answer" value="{{ $i }}" @checked(old('correct_answer', isset($question) && isset($question->answers[$i]) ? $question->answers[$i]->is_correct : ($i === 0))) required>
                </div>
                <input type="text" class="form-control @error('answers.'.$i) is-invalid @enderror" name="answers[{{ $i }}]" value="{{ old('answers.'.$i, $question->answers[$i]->answer ?? '') }}" placeholder="{{ trans('quiz::admin.fields.answers') }} #{{ $i + 1 }}" @if($i < 2) required @endif>
                @if($i >= 2)
                    <button class="btn btn-outline-danger remove-answer" type="button" data-index="{{ $i }}"><i class="bi bi-x-lg"></i></button>
                @endif
            </div>
            @error('answers.'.$i)
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    @endfor
</div>

<button type="button" class="btn btn-sm btn-outline-success mb-3" id="addAnswer">
    <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
</button>

@push('footer-scripts')
    <script>
        document.getElementById('addAnswer').addEventListener('click', function() {
            const hiddenAnswers = document.querySelectorAll('.answer-group.d-none');
            if (hiddenAnswers.length > 0) {
                hiddenAnswers[0].classList.remove('d-none');
                hiddenAnswers[0].querySelector('input[type="text"]').required = true;
            }
            if (hiddenAnswers.length === 1) {
                this.classList.add('d-none');
            }
        });

        document.querySelectorAll('.remove-answer').forEach(function(button) {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                const group = document.getElementById('answer-' + index);
                group.classList.add('d-none');
                group.querySelector('input[type="text"]').value = '';
                group.querySelector('input[type="text"]').required = false;
                document.getElementById('addAnswer').classList.remove('d-none');
            });
        });
    </script>
@endpush
