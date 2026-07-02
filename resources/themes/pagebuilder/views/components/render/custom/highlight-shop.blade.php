@php
    $attributes = $component['attributes'] ?? [];
    $classes = $component['classes'] ?? [];
    $style = $component['style'] ?? [];
    $id = $attributes['id'] ?? '';

    $title = trim((string) ($attributes['data-title'] ?? 'Article mis en avant'));
    if ($title === '') {
        $title = 'Article mis en avant';
    }

    $buttonLabel = trim((string) ($attributes['data-button-label'] ?? 'Voir la boutique'));
    if ($buttonLabel === '') {
        $buttonLabel = 'Voir la boutique';
    }

    $packageId = (int) ($attributes['data-package-id'] ?? 0);
    static $shopAvailableCache = null;
    static $packageByIdCache = [];

    if ($shopAvailableCache === null) {
        $shopAvailableCache = plugins()->isEnabled('shop') && class_exists(\Azuriom\Plugin\Shop\Models\Package::class);
    }

    $shopAvailable = $shopAvailableCache;
    $package = null;

    if ($shopAvailable && $packageId > 0) {
        if (!array_key_exists($packageId, $packageByIdCache)) {
            $packageByIdCache[$packageId] = \Azuriom\Plugin\Shop\Models\Package::find($packageId);
        }

        $package = $packageByIdCache[$packageId];
    }

    $styleString = '';
    if (!empty($style)) {
        $styleString = collect($style)->map(fn($value, $prop) => e($prop) . ':' . e($value))->implode(';');
    }

    $cleanClasses = array_values(array_filter($classes, static fn($class) => is_string($class) && $class !== ''));
    if (empty($cleanClasses)) {
        $cleanClasses = ['card', 'border-warning-subtle', 'shadow-sm'];
    }
@endphp

@if(!$shopAvailable)
    <div class="alert alert-warning mb-0">
        Plugin Shop requis pour ce composant.
    </div>
@elseif($package === null)
    <div class="alert alert-warning mb-0">
        Article introuvable. Vérifie l'article sélectionné.
    </div>
@else
    <div
        @if($id) id="{{ e($id) }}" @endif
        @class($cleanClasses)
        @if($styleString) style="{{ $styleString }}" @endif
    >
        <div class="card-body">
            <h2 class="h4 mb-3">{{ $title }}</h2>

            <div class="d-flex align-items-center gap-3 mb-3">
                @if($package->hasImage())
                    <img
                        src="{{ $package->imageUrl() }}"
                        alt="{{ $package->name }}"
                        width="64"
                        height="64"
                        style="object-fit: cover; border-radius: 10px;"
                    >
                @endif

                <div>
                    <p class="mb-1 fw-semibold">{{ $package->name }}</p>
                    <p class="mb-0">
                        @if($package->isDiscounted())
                            <del class="text-danger me-2">{{ $package->getOriginalPrice() }}</del>
                        @endif
                        <span class="text-primary">{{ shop_format_amount($package->getPrice()) }}</span>
                    </p>
                </div>
            </div>

            <a href="{{ route('shop.home') }}" class="btn btn-primary">
                {{ $buttonLabel }}
            </a>
        </div>
    </div>
@endif
