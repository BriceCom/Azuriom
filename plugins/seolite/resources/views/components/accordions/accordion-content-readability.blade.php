<div>
    <div id="SEOLITE_readability_results">
        <div class="card border-0">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fw-semibold small">{{ trans('seolite::messages.flesch_readability_score') }}</span>
                    <span id="SEOLITE_readability_score" class="badge fs-6 bg-secondary">0</span>
                </div>
                <div class="progress mb-2" style="height: 8px;">
                    <div id="SEOLITE_readability_progress" class="progress-bar bg-secondary" role="progressbar" style="width: 0%"></div>
                </div>
                <div id="SEOLITE_readability_level" class="small text-center mb-2">
                    <span class="fw-semibold">{{ trans('seolite::messages.difficulty_level') }}:</span>
                    <span id="SEOLITE_readability_level_text">{{ trans('seolite::messages.analyzing') }}</span>
                </div>
                <div id="SEOLITE_readability_message" class="small text-muted text-center">
                </div>
            </div>
        </div>

        <div class="mt-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-semibold text-muted">Detailed Statistics</span>
            </div>
            <div class="row g-2">
                <div class="col-4">
                    <div class="text-center p-2 rounded">
                        <div class="fw-bold" id="SEOLITE_readability_words">0</div>
                        <small class="text-muted">{{ trans('seolite::messages.words') }}</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center p-2 rounded">
                        <div class="fw-bold" id="SEOLITE_readability_sentences">0</div>
                        <small class="text-muted">{{ trans('seolite::messages.sentences') }}</small>
                    </div>
                </div>
                <div class="col-4">
                    <div class="text-center p-2 rounded">
                        <div class="fw-bold" id="SEOLITE_readability_syllables">0</div>
                        <small class="text-muted">{{ trans('seolite::messages.syllables') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 p-2 bg-info bg-opacity-10 rounded">
        <small class="text-info">
            <i class="bi bi-info-circle me-1"></i>
            {{ trans('seolite::messages.readability_info') }}
        </small>
    </div>

    <div class="mt-4">
        <p class="fw-semibold">{{ trans('seolite::messages.test_text_readability') }}</p>
        <div class="form-group">
            <textarea id="SEOLITE_readability_test_text" class="form-control mb-2" rows="4" placeholder="{{ trans('seolite::messages.enter_text_to_test') }}"></textarea>
            <button id="SEOLITE_readability_test_button" class="btn btn-primary btn-sm">{{ trans('seolite::messages.analyze_readability') }}</button>
        </div>
        <div id="SEOLITE_readability_test_results" class="mt-2 d-none">
            <div class="alert alert-info">
                <div class="d-flex align-items-center justify-content-between">
                    <span>{{ trans('seolite::messages.readability_score_prefix') }}</span>
                    <span id="SEOLITE_readability_test_score" class="badge bg-info">0</span>
                </div>
                <div class="progress mt-2 mb-2" style="height: 8px;">
                    <div id="SEOLITE_readability_test_progress" class="progress-bar bg-info" role="progressbar" style="width: 0%"></div>
                </div>
                <div class="small">
                    <span>{{ trans('seolite::messages.level') }}: </span>
                    <span id="SEOLITE_readability_test_level">{{ trans('seolite::messages.analyzing') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
