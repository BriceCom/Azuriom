@if($goalEnabled)
    <div class="card w-full" id="vote-goal">
        <div class="card-body py-md-3">
            <h2 class="card-title fs-6 mb-2">
                {{ trans('vote::messages.sections.goal') }}
            </h2>

            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated"
                     role="progressbar"
                     style="width: {{ min($goalPercentage, 100) }}%"
                     aria-valuenow="{{ $goalProgress }}"
                     aria-valuemin="0"
                     aria-valuemax="{{ $goalTarget }}">
                </div>
            </div>

            <small class="text-center mb-0 text-xs" id="goal-text">
                {{ trans('vote::messages.goal', ['current' => $goalProgress, 'target' => $goalTarget]) }}
            </small>
        </div>
    </div>
@endif
