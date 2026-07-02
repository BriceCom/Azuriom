<div>
    <div class="mb-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="fw-semibold small text-muted">{{ __('seolite::messages.image_format_analysis') }}</span>
            <button class="btn btn-sm btn-outline-info p-1" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="{{ __('seolite::messages.webp_format_tooltip') }}">
                <i class="bi bi-question-circle"></i>
            </button>
        </div>
        <div class="alert alert-info small mb-3">
            <i class="bi bi-info-circle me-2"></i>
            {{ __('seolite::messages.webp_info_description') }}
        </div>
    </div>

    <ul id="SEOLITE_imageOptimization" class="list-unstyled mb-0">
    </ul>

    <div class="text-center text-muted small mt-3" id="SEOLITE_imageOptimization_placeholder">
        <i class="bi bi-image me-2"></i>
        {{ __('seolite::messages.click_to_analyze_image_formats') }}
    </div>

    <!-- Summary section -->
    <div id="SEOLITE_imageOptimization_summary" class="mt-3 d-none">
        <div class="mt-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-semibold text-muted">{{ trans('seolite::messages.detailed') }}</span>
            </div>
            <div class="row g-2">
                <div class="col-4">
                    <div class="text-center p-2 rounded">
                        <div class="fw-bold" id="SEOLITE_webp_count">0</div>
                        <small class="text-success">{{ __('seolite::messages.webp_images') }}</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center p-2 rounded">
                        <div class="fw-bold" id="SEOLITE_other_count">0</div>
                        <small class="text-muted">{{ __('seolite::messages.other_formats') }}</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center p-2 rounded">
                        <div class="fw-bold" id="SEOLITE_optimization_percentage">0</div>
                        <small class="text-muted">{{ __('seolite::messages.optimized') }}</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
