<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card border-success h-100">
            <div class="card-header bg-success bg-opacity-10 border-success">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="card-title mb-0">{{ trans('seolite::messages.freemium_features') }}</h3>
                    <span class="badge bg-success">{{ trans('seolite::messages.plan_freemium') }}</span>
                </div>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">{{ trans('seolite::messages.freemium_features_desc') }}</p>

                <div class="list-group list-group-flush">
                    @foreach($seoLiteNextPlansByPlan['freemium'] ?? [] as $feature)
                        <div class="list-group-item px-0">
                            <div class="d-flex align-items-start gap-3">
                                <i class="{{ $feature['icon'] }} text-success fs-5"></i>
                                <div>
                                    <div class="fw-semibold">{{ trans($feature['label']) }}</div>
                                    <p class="text-muted mb-0">{{ trans($feature['description']) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card border-warning h-100">
            <div class="card-header bg-warning bg-opacity-10 border-warning">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="card-title mb-0">{{ trans('seolite::messages.premium_features') }}</h3>
                    <span class="badge bg-warning text-dark">{{ trans('seolite::messages.plan_premium') }}</span>
                </div>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">{{ trans('seolite::messages.premium_features_desc') }}</p>

                <div class="list-group list-group-flush">
                    @foreach($seoLiteNextPlansByPlan['premium'] ?? [] as $feature)
                        <div class="list-group-item px-0">
                            <div class="d-flex align-items-start gap-3">
                                <i class="{{ $feature['icon'] }} text-warning fs-5"></i>
                                <div>
                                    <div class="fw-semibold">{{ trans($feature['label']) }}</div>
                                    <p class="text-muted mb-0">{{ trans($feature['description']) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
