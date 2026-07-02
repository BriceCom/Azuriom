@props([
    'advanced' => false,
    'icon' => null,
    'title' => null,
    'subtitle' => null,
    'class' => "flex-column"
])

<div class="card shadow-lg">
    <div class="card-header border border-bottom-0 {{ $advanced ? "bg-warning bg-opacity-10 border-warning":"bg-body" }}">
        <div class="card-title d-flex align-items-center gap-2 justify-content-between m-0">
            <div class="d-flex align-items-baseline gap-2">
                @if($icon) <i class="{{ $icon }}"></i> @endif
                    <div>
                        <h3 class="fs-5 m-0 text-secondary-emphasis fw-bold">{{ $title }}</h3>
                        @if($subtitle)
                            <small class="m-0">{{ $subtitle }}</small>
                        @endif
                    </div>
            </div>

            @if($advanced)
                @include('components.admin.partials.active-advanced-mode')
            @endif
        </div>
    </div>

    <div class="card-body d-flex gap-4 border @if($advanced) border-warning @endif {{ $class }}">
        {{ $slot }}
    </div>
</div>
