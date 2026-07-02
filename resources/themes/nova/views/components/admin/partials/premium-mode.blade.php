@if(!theme_config('premium.serveurliste.link') || (theme_config('premium.serveurliste.token') == null))
    <div class="alert alert-warning d-flex align-items-center flex-wrap gap-2 py-2 mb-3">
        <span class="d-flex align-items-center p-2 bg-warning bg-gradient bg-opacity-10 rounded-2" style="width: 33px; height: 33px">⭐</span>
        <span>{{trans('theme::admin.no_advanced_mode')}}</b></span>

        <button class="nav-link fw-bold text-warning"
                id="pill-premium-trigger"
                data-config-pill="pill-premium" data-bs-toggle="pill" data-bs-target="#pill-premium" type="button" role="tab" aria-controls="pill-premium">
            {{ trans('theme::admin.active_advanced_mode') }}
        </button>
    </div>
@endif
