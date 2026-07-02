<div class="col-lg-3 mb-4">
    <div class="card">
        <div class="card-header">
            <i class="bi bi-funnel-fill"></i> {{ trans('achievement::messages.profile.objectives') }}
        </div>
        <div class="card-body">
            <div class="nav flex-column nav-pills" id="objectives-tab" role="tablist">
                <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
                    {{ trans('achievement::messages.status.all') }} ({{ $all->count() }})
                </button>
                <button class="nav-link" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">
                    {{ trans('achievement::messages.status.completed') }} ({{ $completed->count() }})
                </button>
                <button class="nav-link" id="claimed-tab" data-bs-toggle="pill" data-bs-target="#claimed" type="button" role="tab" aria-controls="claimed" aria-selected="false">
                    {{ trans('achievement::messages.status.claimed') }} ({{ $claimed->count() }})
                </button>

            </div>
        </div>
    </div>
</div>
