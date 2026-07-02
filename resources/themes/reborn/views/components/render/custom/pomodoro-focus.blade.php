@php
    $settings = is_array($settings ?? null) ? $settings : [];
    $title = trim((string) ($settings['title'] ?? 'Session Focus'));
    $subtitle = trim((string) ($settings['subtitle'] ?? ''));
    $workMinutes = max(1, (int) ($settings['work_minutes'] ?? 25));
    $shortBreak = max(1, (int) ($settings['short_break'] ?? 5));
    $longBreak = max(1, (int) ($settings['long_break'] ?? 15));
    $cycles = max(1, (int) ($settings['cycles'] ?? 4));
    $buttonLabel = trim((string) ($settings['button_label'] ?? 'Démarrer'));
    $buttonUrl = trim((string) ($settings['button_url'] ?? '#'));
@endphp

<section class="container my-5">
    <article class="card border-0 shadow-sm reborn-pomodoro">
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">
                <div class="col-lg-7">
                    <h2 class="h3 mb-2">{{ $title }}</h2>
                    @if($subtitle !== '')
                        <p class="text-muted mb-3">{{ $subtitle }}</p>
                    @endif

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge text-bg-primary">{{ $workMinutes }} min focus</span>
                        <span class="badge text-bg-secondary">{{ $shortBreak }} min pause</span>
                        <span class="badge text-bg-dark">{{ $longBreak }} min pause longue</span>
                        <span class="badge text-bg-info">{{ $cycles }} cycles</span>
                    </div>

                    @if($buttonLabel !== '')
                        <a href="{{ $buttonUrl }}" class="btn btn-primary">{{ $buttonLabel }}</a>
                    @endif
                </div>

                <div class="col-lg-5">
                    <div class="reborn-pomodoro-clock">
                        <div class="reborn-pomodoro-ring"></div>
                        <div class="reborn-pomodoro-time">{{ str_pad((string) $workMinutes, 2, '0', STR_PAD_LEFT) }}:00</div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</section>
