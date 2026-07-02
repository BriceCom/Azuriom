<div class="col-md-6 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between gap-2">
                <div>
                    <h5 class="card-title">{{ $userObjective->objective->name }}</h5>
                    <p class="card-text mb-0">{{ $userObjective->objective->description }}</p>
                    <small>{{ trans('achievement::messages.current_progress') }}: {{ $userObjective->progress }} / {{ $userObjective->objective->amount }}</small>
                </div>
                <div>
                    @include('achievement::components.objective._circle-progress', [
                        'percent' => $userObjective->getProgressPercentage(),
                    ])
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-start gap-2 mt-3">
                @if(in_array($userObjective->status, ['completed', 'claimed']))
                    <span class="badge bg-success">
                        {{ trans('achievement::messages.status.'.$userObjective->status) }}
                    </span>
                @else
                    <span></span>
                @endif

                <div class="d-flex flex-column gap-2">
                    @if($userObjective->status !== 'claimed' && $userObjective->getProgressPercentage() === 100)
                        <form action="{{ route('achievement.objectives.claim', $userObjective->objective) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-check-circle"></i> {{ trans('achievement::messages.get_reward') }}
                            </button>
                        </form>
                    @endif

                    @if($userObjective->objective->rewards)
                        <button class="btn btn-sm btn-outline-primary ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#rewards-{{ $userObjective->id }}">
                            {{ trans('achievement::messages.rewards') }}
                        </button>
                    @endif
                </div>
            </div>

            @if($userObjective->objective->rewards)
                <div class="collapse mt-3" id="rewards-{{ $userObjective->id }}">
                    <div class="card card-body">
                        <h6>{{ trans('achievement::messages.rewards') }}</h6>
                        <ul class="list-unstyled mb-0">
                            @foreach($userObjective->objective->rewards as $reward)
                                <li>
                                    @if($reward['type'] === 'money')
                                        <i class="bi bi-coin"></i> {{ $reward['value'] }} {{ money_name() }}
                                    @elseif($reward['type'] === 'command')
                                        <i class="bi bi-terminal"></i> {{ $reward['name'] ?? trans('achievement::messages.rewards_types.command') }}
                                    @elseif($reward['type'] === 'trophy')
                                        <i class="bi bi-trophy"></i> {{ $reward['value'] }} {{ achievement_trophy_name() }}
                                    @elseif($reward['type'] === 'scratch_game')
                                        <i class="bi bi-ticket"></i> {{ trans('achievement::messages.rewards_types.scratch_game') }}
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if($userObjective->status === 'completed' && $userObjective->completed_at)
                <div class="mt-3 text-muted small">
                    <i class="bi bi-calendar-check"></i> {{ trans('achievement::messages.completed_at') }}: {{ $userObjective->completed_at->format('d/m/Y H:i') }}
                </div>
            @endif
        </div>
    </div>
</div>
