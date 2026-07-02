@php
    $teContentBlocksForRoute = $teContentBlocksForRoute ?? view()->shared('teContentBlocksForRoute', collect());
    if (!($teContentBlocksForRoute instanceof \Illuminate\Support\Collection)) {
        $teContentBlocksForRoute = collect(is_array($teContentBlocksForRoute) ? $teContentBlocksForRoute : []);
    }

    $teBlockViews = isset($teBlockViews) && is_array($teBlockViews)
        ? $teBlockViews
        : (is_array(view()->shared('teBlockViews')) ? view()->shared('teBlockViews') : []);

    $tePageContentView = isset($tePageContentView) && is_string($tePageContentView)
        ? $tePageContentView
        : (is_string(view()->shared('tePageContentView')) ? view()->shared('tePageContentView') : null);
@endphp

<div class="container content d-flex flex-column" data-te-block-container>
    @include('elements.session-alerts')

    @if(! $tePageContentView)
        @yield('content')
    @endif

    @php($teNativePageContentRendered = false)

    @foreach($teContentBlocksForRoute as $block)
        @if(($block['id'] ?? null) === 'page_content')
            @php($teNativePageContentRendered = true)
            @if($tePageContentView)
                @component($tePageContentView, ['params' => $block['params'] ?? []])
                    @yield('content')
                @endcomponent
            @else
                @yield('content')
            @endif
            @continue
        @endif

        @if(isset($teBlockViews[$block['id']]))
            @include($teBlockViews[$block['id']], ['params' => $block['params'] ?? []])
        @endif
    @endforeach

    @if(! $teNativePageContentRendered && $tePageContentView)
        @component($tePageContentView, ['params' => []])
            @yield('content')
        @endcomponent
    @endif
</div>
