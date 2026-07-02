@php($gscFeature = $seoLiteNextPlans['gsc_connect'] ?? null)

<div class="offcanvas offcanvas-start show small" tabindex="-1" id="seoliteOffcanvas" aria-labelledby="seoliteOffcanvasLabel">
    <div class="offcanvas-header border-bottom">
        <p class="offcanvas-title d-flex align-items-center gap-2" id="seoliteOffcanvasLabel">
            @include('seolite::components.logo')
            <span class="fw-bold">SEO</span>
            <span class="badge-brand badge bg-secondary">Lite</span>
        </p>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column p-0">
        <div class="p-3 border-bottom">
            <div class="d-flex align-items-center justify-content-between">
                <span class="fw-semibold text-muted">{{ trans('seolite::messages.seo_score') }}</span>

                <div class="d-flex align-items-center gap-1">
                    <span class="text-primary fs-5 fw-semibold" id="SEOLITE-score">0</span>
                    <span class="text-muted">/100</span>
                </div>
            </div>
        </div>

        <div class="accordion accordion-flush" id="SEOLITE-accordions">
            @include('seolite::components.accordions.accordion-item', [
               'id' => 'SEOLITE_keywords',
               'title' => trans('seolite::messages.keyword_analysis'),
               'content' => view('seolite::components.accordions.accordion-content-keywords'),
               'showScore' => false
            ])

            @include('seolite::components.accordions.accordion-item', [
               'id' => 'SEOLITE_metas',
               'title' => trans('seolite::messages.metadata'),
               'content' => view('seolite::components.accordions.accordion-content-metas')
            ])

            @include('seolite::components.accordions.accordion-item', [
               'id' => 'SEOLITE_headings',
               'title' => trans('seolite::messages.headings'),
               'content' => view('seolite::components.accordions.accordion-content-headings')
            ])

            @include('seolite::components.accordions.accordion-item', [
               'id' => 'SEOLITE_readability',
               'title' => trans('seolite::messages.readability_score'),
               'content' => view('seolite::components.accordions.accordion-content-readability')
            ])

            @include('seolite::components.accordions.accordion-item', [
               'id' => 'SEOLITE_imgAlt',
               'title' => trans('seolite::messages.alternative_text_images'),
               'content' => view('seolite::components.accordions.accordion-content-imgAlt')
            ])

            @include('seolite::components.accordions.accordion-item', [
               'id' => 'SEOLITE_imageOptimization',
               'title' => trans('seolite::messages.image_optimization'),
               'content' => view('seolite::components.accordions.accordion-content-image-optimization')
            ])

            @include('seolite::components.accordions.accordion-item', [
               'id' => 'SEOLITE_recommendations',
               'title' => trans('seolite::messages.recommendations'),
               'content' => view('seolite::components.accordions.accordion-content-recommendations'),
               'showScore' => false
            ])
        </div>
        <div class="p-3 border-top">
            <div class="d-grid gap-2">
                <button class="btn btn-outline-warning btn-sm" disabled>
                    <i class="bi bi-google me-1"></i>
                    {{ trans('seolite::messages.connect_google_console') }}
                    @if($gscFeature && $gscFeature['is_premium'])
                        <span class="badge bg-warning text-dark ms-2">{{ trans('seolite::messages.plan_premium') }}</span>
                    @endif
                </button>
                <small class="text-center {{ $gscFeature && $gscFeature['is_premium'] ? 'text-warning' : 'text-info' }}">
                    <i class="bi {{ $gscFeature && $gscFeature['is_premium'] ? 'bi-lock' : 'bi-clock' }} me-1"></i>
                    {{ trans($gscFeature && $gscFeature['is_premium'] ? 'seolite::messages.available_in_seo_pro' : 'seolite::messages.soon_seo_pro') }}
                </small>
            </div>
        </div>

        <div class="position-sticky bottom-0 mt-auto p-3 border-top bg-body">
            <div class="d-flex align-items-center justify-content-between gap-2">
                <a class="btn btn-primary btn-sm text-sm" href="https://discord.gg/4feP35urSB" target="_blank">
                    <i class="bi bi-question-circle me-1"></i>
                    {{ trans('seolite::messages.support') }}
                </a>

                <a href="https://bryx-agency.fr/azuriom" target="_blank">
                    <img src="{{ plugin_asset('seolite', 'img/bryx.webp') }}" title="Bryx Agency" class="rounded-2" alt="Bryx Agency logo" width="32">
                </a>
            </div>
        </div>
    </div>
</div>
