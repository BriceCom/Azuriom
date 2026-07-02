<section class="py-5" id="trailer">
    <div class="container px-4 px-lg-5">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <h2 class="fw-bolder">{{ $trailer['title'] }}</h2>
                <p class="text-body-secondary mb-4">{{ $trailer['subtitle'] }}</p>
                @if(!empty($trailer['button_text']) && !empty($trailer['button_url']))
                    <a href="{{ $trailer['button_url'] }}" class="btn btn-outline-primary" target="_blank" rel="noopener noreferrer">
                        {{ $trailer['button_text'] }}
                    </a>
                @endif
            </div>
            <div class="col-lg-7">
                @if(!empty($trailer['video_url']))
                    <div class="ratio ratio-16x9 pomodoro-trailer-frame">
                        <iframe src="{{ $trailer['video_url'] }}" title="{{ $trailer['title'] }}" allowfullscreen></iframe>
                    </div>
                @else
                    <div class="bg-light rounded-3 p-5 text-center">
                        <p class="mb-0 text-muted">{{ trans('theme::theme.home.trailer.missing_video') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
