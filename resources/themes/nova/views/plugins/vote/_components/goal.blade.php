@if($goalEnabled ?? false)
    <div class="card mb-4" id="vote-goal">
        <div class="card-body py-3">
            <p class="mb-1 text-uppercase fw-bold">
                {{ trans('vote::messages.sections.goal') }}
            </p>

            <div class="progress mb-1">
                <div class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar"
                     style="width: {{ min($goalPercentage, 100) }}%"
                     aria-valuenow="{{ $goalProgress }}"
                     aria-valuemin="0"
                     aria-valuemax="{{ $goalTarget }}">
                </div>
            </div>

            <small class="text-center mb-0" id="goal-text">
                {{ trans('vote::messages.goal', ['current' => $goalProgress, 'target' => $goalTarget]) }}
            </small>
        </div>
    </div>
@endif
