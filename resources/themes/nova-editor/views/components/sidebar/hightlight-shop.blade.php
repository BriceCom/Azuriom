@if(!theme_config('sidebar.article.off'))
    @if(plugins()->isEnabled('shop'))
        <div class="card"
             style="--di-card-bg: rgba(var(--di-tertiary-rgb), 0.1); --di-border-color-translucent: rgba(var(--di-tertiary-rgb), 0.2);">
            <div class="card-body">
                <h2 class="h3">{{ theme_config('sidebar.article.title') ?? trans('theme::theme.highlight_article') }}</h2>

                @php
                    $package = Azuriom\Plugin\Shop\Models\Package::find(theme_config('sidebar.article.id'));
                @endphp

                @if($package)
                    <div class="d-flex align-items-center gap-2 mb-3">
                        @if($package->hasImage())
                            <a href="#" data-package-url="{{ route('shop.packages.show', $package) }}">
                                <img class="object-fit-contain" src="{{ $package->imageUrl() }}" width="64"
                                     alt="{{ $package->name }}">
                            </a>
                        @endif

                        <div class="d-flex flex-column gap-1">
                            <p class="mb-0">{{ $package->name }}</p>

                            <p class="mb-0">
                                @if($package->isDiscounted())
                                    <del class="text-1xl text-danger">{{ $package->getOriginalPrice() }}</del>
                                @endif

                                <span class="text-tertiary">
                          {{ $package->getPrice() }}
                                    {{ shop_active_currency() }}
                      </span>
                            </p>
                        </div>

                    </div>
                @else
                    <div class="alert alert-danger">
                        Article not found
                    </div>
                @endif

                <a href="{{ route('shop.home') }}" class="btn btn-tertiary">{{ trans('shop::messages.title') }}</a>
            </div>
        </div>
    @endif
@endif
