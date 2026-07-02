<section class="py-5" id="features">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-5">
            <div class="col-lg-4 mb-5 mb-lg-0">
                <h2 class="fw-bolder mb-0">{{ $featuresTitle }}</h2>
            </div>
            <div class="col-lg-8">
                <div class="row gx-5 row-cols-1 row-cols-md-2">
                    @foreach($featureItems as $item)
                        @php
                            $rawIcon = trim((string) ($item['icon'] ?? 'bi-shield-check'));
                            if (str_starts_with($rawIcon, 'bi bi-')) {
                                $iconClass = $rawIcon;
                            } elseif (str_starts_with($rawIcon, 'bi-')) {
                                $iconClass = 'bi '.$rawIcon;
                            } else {
                                $iconClass = 'bi bi-'.$rawIcon;
                            }
                        @endphp
                        <div class="col mb-5 h-100">
                            <div class="pomodoro-feature-icon rounded-3 mb-3">
                                <i class="{{ $iconClass }}"></i>
                            </div>
                            <h3 class="h5">{{ $item['title'] ?? trans('theme::theme.home.features.item_fallback_title') }}</h3>
                            <p class="mb-0 text-body-secondary">{{ $item['text'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
