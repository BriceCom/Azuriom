<div>
    <div class="mb-3">
        <label for="SEOLITE_keyword_input" class="form-label small fw-semibold">
            <i class="bi bi-search me-1"></i>
            {{ trans('seolite::messages.keyword_to_analyze') }}
        </label>
        <div class="input-group">
            <input type="text"
                   class="form-control"
                   id="SEOLITE_keyword_input"
                   autocomplete="off">
            <button class="btn btn-outline-primary" type="button" id="SEOLITE_keyword_analyze">
                <i class="bi bi-play-fill"></i>
            </button>
        </div>
        <small class="form-text text-muted">
            {{ trans('seolite::messages.enter_main_keyword') }}
        </small>
    </div>

    <div id="SEOLITE_keyword_results" class="d-none">
        <div class="card border-0">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fw-semibold small">{{ trans('seolite::messages.keyword_density') }}</span>
                    <span id="SEOLITE_keyword_density" class="badge fs-6">0%</span>
                </div>
                <div class="progress mb-2" style="height: 8px;">
                    <div id="SEOLITE_keyword_progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                </div>
                <div id="SEOLITE_keyword_diagnostic" class="small">
                </div>
            </div>
        </div>

        <div class="mt-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-semibold text-muted">{{ trans('seolite::messages.detailed_statistics') }}</span>
            </div>
            <div class="row g-2">
                <div class="col-6">
                    <div class="text-center p-2 rounded">
                        <div class="fw-bold" id="SEOLITE_keyword_count">0</div>
                        <small class="text-muted">{{ trans('seolite::messages.occurrences') }}</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-center p-2 rounded">
                        <div class="fw-bold" id="SEOLITE_total_words">0</div>
                        <small class="text-muted">{{ trans('seolite::messages.total_words') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
