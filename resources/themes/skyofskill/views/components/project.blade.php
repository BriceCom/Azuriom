@props([
    'title' => 'WorldOfSkill',
    'description' => 'Premier PvP/Cheat Français',
    'ip' => 'play.worldofskill.fr',
    'logo' => null,
    'bgImage' => null,
    'colorStart' => '#9C0C0F',
    'colorEnd' => '#DC4C4F'
])

<div class="project overflow-hidden position-relative px-3 pb-3 pt-7 rounded-5 bg-primary"
     style="
        --linear-end: {{ $colorEnd }};
        --linear-start: {{ $colorStart }};
     "
>
    <img src="{{ $bgImage ? image_url($bgImage) : site_logo() }}" alt="" class="position-absolute top-50 start-50 translate-middle object-fit-contain project-bg"/>

    <div class="d-flex flex-column align-items-center gap-4">
        <div>
            <h3 class="h2 mb-0">{{ $title }}</h3>
            <p class="mb-0 mt-2 text-center">{{ $description }}</p>
        </div>

        <div class="project-ip">
            {{ $ip }}
        </div>
    </div>
    <div class="flex-grow-1 mt-3 text-center">
        <img src="{{ $logo ? image_url($logo) : site_logo() }}" alt="Logo" class="object-fit-contain project-img" />
    </div>
</div>
