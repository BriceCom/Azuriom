@if(!theme_config('premium.serveurliste.link') || (theme_config('premium.serveurliste.token') == null))
    <div class="alert alert-warning d-flex align-items-center flex-wrap gap-2 py-2 mb-3">
        <span class="d-flex align-items-center p-2 bg-warning bg-gradient bg-opacity-10 rounded-2" style="width: 33px; height: 33px">⭐</span>
        <span>{{trans('theme::admin.no_premium')}}</b></span>
    </div>
@endif
