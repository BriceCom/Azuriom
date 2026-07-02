@if(request()->routeIs('shop.categories.show') && isset($category) && $category)
    @php
        $pagebuilderShopPackages = $category->packages ?? [];
    @endphp

    <div class="row gy-4">
        @forelse($pagebuilderShopPackages as $package)
            <div class="col-md-4">
                <div class="card h-100">
                    @if($package->hasImage())
                        <a href="#" data-package-url="{{ route('shop.packages.show', $package) }}">
                            <img class="card-img-top" src="{{ $package->imageUrl() }}" alt="{{ $package->name }}">
                        </a>
                    @endif

                    <div class="card-body">
                        <h4 class="card-title">{{ $package->name }}</h4>
                        <h5 class="card-subtitle mb-3">
                            @if($package->isDiscounted())
                                <del class="small">{{ $package->getOriginalPrice() }}</del>
                            @endif
                            {{ shop_format_amount($package->getPrice()) }}
                        </h5>

                        <a href="#" class="btn btn-primary" data-package-url="{{ route('shop.packages.show', $package) }}">
                            {{ trans('shop::messages.buy') }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ trans('shop::messages.categories.empty') }}
                </div>
            </div>
        @endforelse
    </div>

    @php
        $pagebuilderShopItemModalRendered = $pagebuilderShopItemModalRendered ?? false;
    @endphp
    @if(!$pagebuilderShopItemModalRendered)
        <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true"></div>
        @php $pagebuilderShopItemModalRendered = true; @endphp
    @endif
@else
    <div class="alert alert-warning mb-0">
        {{ trans('theme::pagebuilder.page_component_unavailable', ['component' => trans('theme::pagebuilder.page_shop_category_packages')]) }}
    </div>
@endif
