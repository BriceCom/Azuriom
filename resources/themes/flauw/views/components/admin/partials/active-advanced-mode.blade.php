@if(!theme_config('premium.serveurliste.link') || (theme_config('premium.serveurliste.token') == null))
    <button class="nav-link fw-bold text-warning"
            id="pill-premium-trigger"
            data-config-pill="pill-premium" data-bs-toggle="pill" data-bs-target="#pill-premium" type="button" role="tab" aria-controls="pill-premium">
        {{ trans('theme::admin.active_advanced_mode') }}
    </button>
@endif
