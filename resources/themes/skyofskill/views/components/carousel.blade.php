@if(!theme_config('home.carousel.off'))
@php
    $projects = theme_config('home.carousel.projects') ?? [];
    $projectsChunks = array_chunk($projects, 3);
@endphp

<div class="carousel-section d-flex flex-column gap-4 gap-md-7">
    <hgroup class="text-center">
        <h2>{{ theme_config('home.carousel.title') ?? 'Nos serveurs minecraft' }}</h2>
        <p>{!! theme_config('home.carousel.description') ?? 'Tu apprécies notre travail ? Découvre tous nos projets :' !!}</p>
    </hgroup>

    @if(count($projects) > 0)
    <div>
        <!-- Desktop Carousel -->
        <div id="carouselDesktop" class="carousel slide d-none d-xl-flex align-items-center gap-4" data-bs-ride="carousel">

            <button class="carousel-btn anim-hover-up" type="button" data-bs-target="#carouselDesktop" data-bs-slide="prev">
                <i class="bi bi-arrow-left-short"></i>
                <span class="visually-hidden">Précédent</span>
            </button>

            <div class="carousel-inner">
                @foreach($projectsChunks as $chunkIndex => $projectChunk)
                <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                    <div class="row">
                        @foreach($projectChunk as $project)
                        <div class="col-4">
                            @include('components.project', [
                                'title' => $project['title'] ?? 'WorldOfSkill',
                                'description' => $project['description'] ?? 'Premier PvP/Cheat Français',
                                'ip' => $project['ip'] ?? 'play.worldofskill.fr',
                                'logo' => $project['logo'] ?? null,
                                'bgImage' => $project['bgImage'] ?? null,
                                'colorStart' => $project['colorStart'] ?? '#9C0C0F',
                                'colorEnd' => $project['colorEnd'] ?? '#DC4C4F'
                            ])
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <button class="carousel-btn anim-hover-up" type="button" data-bs-target="#carouselDesktop" data-bs-slide="next">
                <i class="bi bi-arrow-right-short"></i>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>

        <!-- Mobile Carousel -->
        <div id="carouselMobile" class="position-relative carousel slide d-flex d-xl-none align-items-center gap-3" data-bs-ride="carousel">

            <div class="carousel-inner">
                @foreach($projects as $index => $project)
                <div class="carousel-item px-1 {{ $index === 0 ? 'active' : '' }}">
                    @include('components.project', [
                        'title' => $project['title'] ?? 'WorldOfSkill',
                        'description' => $project['description'] ?? 'Premier PvP/Cheat Français',
                        'ip' => $project['ip'] ?? 'play.worldofskill.fr',
                        'logo' => $project['logo'] ?? null,
                        'bgImage' => $project['bgImage'] ?? null,
                        'colorStart' => $project['colorStart'] ?? '#9C0C0F',
                        'colorEnd' => $project['colorEnd'] ?? '#DC4C4F'
                    ])
                </div>
                @endforeach
            </div>

            <button class="position-absolute top-50 start-0 translate-middle-y carousel-btn anim-hover-up" type="button" data-bs-target="#carouselMobile" data-bs-slide="prev">
                <i class="bi bi-arrow-left-short"></i>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="position-absolute top-50 end-0 translate-middle-y carousel-btn anim-hover-up" type="button" data-bs-target="#carouselMobile" data-bs-slide="next">
                <i class="bi bi-arrow-right-short"></i>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>

    </div>
    @endif
</div>
@endif
