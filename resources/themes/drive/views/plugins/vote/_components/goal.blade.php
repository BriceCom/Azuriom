@if($goalEnabled ?? false)
    <div class="card mb-4" id="vote-goal">
        <div class="card-body">
            <h2 class="card-title">
                {{ trans('vote::messages.sections.goal') }}
            </h2>

            <div class="progress mb-1">
                <div class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar"
                     style="width: {{ min($goalPercentage, 100) }}%"
                     aria-valuenow="{{ $goalProgress }}"
                     aria-valuemin="0"
                     aria-valuemax="{{ $goalTarget }}">
                </div>
            </div>

            <p class="text-center mb-0" id="goal-text">
                {{ trans('vote::messages.goal', ['current' => $goalProgress, 'target' => $goalTarget]) }}
            </p>
        </div>
    </div>
@endif
