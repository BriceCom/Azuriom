@props([
    'edit' => false
])

<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-info-circle"></i> {{ trans('hunt::admin.common.information') }}
            </h5>
        </div>
        <div class="card-body">
            <h6>{{ trans('hunt::admin.hunts.fields.priority') }}</h6>
            <p class="text-muted small">{{ trans('hunt::admin.hunts.fields.priority_info') }}</p>

            <h6>{{ trans('hunt::admin.hunts.fields.spawn_rate') }}</h6>
            <p class="text-muted small">{{ trans('hunt::admin.hunts.fields.spawn_rate_info') }}</p>

            <h6>{{ trans('hunt::admin.hunts.fields.global_cap') }}</h6>
            <p class="text-muted small">{{ trans('hunt::admin.hunts.fields.global_cap_info') }}</p>

            <h6>{{ trans('hunt::admin.hunts.fields.cooldown_minutes') }}</h6>
            <p class="text-muted small">{{ trans('hunt::admin.hunts.fields.cooldown_minutes_info') }}</p>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-lightbulb"></i> {{ trans('hunt::admin.common.tips') }}
            </h5>
        </div>
        <div class="card-body">
            <ul class="list-unstyled mb-0">
                <li class="mb-2">
                    <i class="bi bi-check-circle text-success me-2"></i>
                    <small>{{ trans('hunt::admin.hunts.validation.priority_range') }}</small>
                </li>
                <li class="mb-2">
                    <i class="bi bi-check-circle text-success me-2"></i>
                    <small>{{ trans('hunt::admin.hunts.validation.spawn_rate_range') }}</small>
                </li>
                <li class="mb-2">
                    <i class="bi bi-check-circle text-success me-2"></i>
                    <small>{{ trans('hunt::admin.hunts.validation.max_per_day_min') }}</small>
                </li>
                <li class="mb-2">
                    <i class="bi bi-check-circle text-success me-2"></i>
                    <small>{{ trans('hunt::admin.hunts.validation.cooldown_min') }}</small>
                </li>
                <li>
                    <i class="bi bi-check-circle text-success me-2"></i>
                    <small>{{ trans('hunt::admin.hunts.validation.end_after_start') }}</small>
                </li>
            </ul>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-danger bg-opacity-10">
            <h5 class="card-title mb-0">
                <i class="bi bi-exclamation-triangle"></i> {{ trans('hunt::admin.common.important') }}
            </h5>
        </div>
        <div class="card-body">
            <p class="mb-2">
                <strong>{{ trans('hunt::admin.hunts.validation.cannot_modify_dates') }}</strong>
            </p>
            <p class="text-muted small mb-0">
                {{ trans('hunt::admin.hunts.validation.date_overlap') }}
            </p>
        </div>
    </div>

    @if($edit)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning"></i> {{ trans('hunt::admin.common.actions') }}
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('hunt.admin.rewards.index', ['hunt_id' => $hunt->id]) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-gift"></i> {{ trans('hunt::admin.rewards.title') }}
                    </a>
                    <a href="{{ route('hunt.admin.logs.index', ['hunt_id' => $hunt->id]) }}" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-list-ul"></i> {{ trans('hunt::admin.logs.title') }}
                    </a>
                    <a href="{{ route('hunt.show', $hunt) }}" class="btn btn-outline-success btn-sm" target="_blank">
                        <i class="bi bi-eye"></i>  {{ trans('hunt::messages.view_leaderboard_btn') }}
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
