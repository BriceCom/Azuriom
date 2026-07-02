@php
    $type = $component['type'] ?? 'unknown';
    $attributes = $component['attributes'] ?? [];
    $classes = $component['classes'] ?? [];
    $components = $component['components'] ?? [];
    $style = $component['style'] ?? [];
    $content = $component['content'] ?? '';
    $settings = is_array($component['settings'] ?? null) ? $component['settings'] : [];
    $context = is_array($context ?? null) ? $context : [];
@endphp

@switch($type)
    @case('container')
        <x-render.container :component="$component" :context="$context" />
        @break

    @case('layout-row')
        <x-render.row :component="$component" :context="$context" />
        @break

    @case('column')
        <x-render.column :component="$component" :context="$context" />
        @break

    @case('text')
        <x-render.text :component="$component" :context="$context" />
        @break

    @case('bs-button')
        <x-render.button :component="$component" :context="$context" />
        @break

    @case('site-navigation')
        @include('components.render.site.navigation', ['component' => $component] + $context)
        @break

    @case('site-header-brand')
        @include('components.render.site.reborn-brand', ['component' => $component, 'settings' => $settings ?? []] + $context)
        @break

    @case('site-header-menu')
        @include('components.render.site.reborn-menu', ['component' => $component, 'settings' => $settings ?? []] + $context)
        @break

    @case('site-header-user')
        @include('components.render.site.reborn-user', ['component' => $component, 'settings' => $settings ?? []] + $context)
        @break

    @case('site-user-navigation')
        @include('components.render.site.user-navigation', ['component' => $component] + $context)
        @break

    @case('site-logo')
        @include('components.render.site.logo', ['component' => $component] + $context)
        @break

    @case('site-theme-toggle')
        @include('components.render.site.theme-toggle', ['component' => $component] + $context)
        @break

    @case('site-notifications')
        {{-- Deprecated / removed component: intentionally no output --}}
        @break

    @case('site-social-links')
        @include('components.render.site.social-links', ['component' => $component] + $context)
        @break

    @case('site-copyright')
        @include('components.render.site.copyright', ['component' => $component] + $context)
        @break

    @case('custom-highlight-shop')
        @include('components.render.custom.highlight-shop', ['component' => $component] + $context)
        @break

    @case('custom-html-safe')
        @include('components.render.custom.html-safe', ['component' => $component] + $context)
        @break

    @case('custom-hero-split')
        @include('components.render.custom.hero-split', ['component' => $component] + $context)
        @break

    @case('custom-stats-grid')
        @include('components.render.custom.stats-grid', ['component' => $component] + $context)
        @break

    @case('custom-feature-cards')
        @include('components.render.custom.feature-cards', ['component' => $component] + $context)
        @break

    @case('custom-cta-ribbon')
        @include('components.render.custom.cta-ribbon', ['component' => $component] + $context)
        @break

    @case('custom-trailer-card')
        @include('components.render.custom.trailer-card', ['component' => $component] + $context)
        @break

    @case('custom-hero-immersive')
        @include('components.render.custom.hero-immersive', ['component' => $component, 'settings' => $settings ?? []] + $context)
        @break

    @case('custom-nova-news')
        @include('components.render.custom.nova-news', ['component' => $component, 'settings' => $settings ?? []] + $context)
        @break

    @case('custom-nomad-roadmap')
        @include('components.render.custom.nomad-roadmap', ['component' => $component, 'settings' => $settings ?? []] + $context)
        @break

    @case('custom-dungeons-classes')
        @include('components.render.custom.dungeons-classes', ['component' => $component, 'settings' => $settings ?? []] + $context)
        @break

    @case('custom-pomodoro-focus')
        @include('components.render.custom.pomodoro-focus', ['component' => $component, 'settings' => $settings ?? []] + $context)
        @break

    @case('custom-spacer')
        @include('components.render.custom.spacer', ['component' => $component, 'settings' => $settings ?? []] + $context)
        @break

    @case('custom-css')
        {{-- CSS-only block, rendered separately in layout --}}
        @break

    @case('page-vote-card')
        @include('components.render.page.vote-card', $context)
        @break

    @case('page-vote-top')
        @include('components.render.page.vote-top', $context)
        @break

    @case('page-vote-rewards')
        @include('components.render.page.vote-rewards', $context)
        @break

    @case('page-shop-sidebar')
        @include('components.render.page.shop-sidebar', $context)
        @break

    @case('page-shop-home')
        @include('components.render.page.shop-home', $context)
        @break

    @case('page-shop-category-description')
        @include('components.render.page.shop-category-description', $context)
        @break

    @case('page-shop-category-packages')
        @include('components.render.page.shop-category-packages', $context)
        @break

    @case('textnode')
        {!! e($content) !!}
        @break

    @default
        {{-- Generic fallback for unknown components --}}
        @php
            $defaultTagByType = [
                'image' => 'img',
                'pb-image' => 'img',
                'pb-icon' => 'i',
            ];
            $tagName = strtolower($component['tagName'] ?? ($defaultTagByType[$type] ?? 'div'));
            $allowedTags = [
                'div', 'section', 'article', 'aside', 'header', 'footer', 'main', 'nav',
                'p', 'span', 'small', 'strong', 'em', 'b', 'i', 'u',
                'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
                'ul', 'ol', 'li',
                'a', 'button', 'form', 'label', 'input', 'textarea', 'select', 'option',
                'img', 'hr', 'br'
            ];
            $voidTags = ['img', 'input', 'hr', 'br'];
            $safeTagName = in_array($tagName, $allowedTags, true) ? $tagName : 'div';
            $id = $attributes['id'] ?? '';
            $cleanClasses = array_filter($classes, function($class) {
                return !empty($class) && is_string($class);
            });
        @endphp

        @php
            $styleString = '';
            if (!empty($style)) {
                $styleString = collect($style)->map(fn($value, $prop) => e($prop) . ':' . e($value))->implode(';');
            }
        @endphp

        @php
            $attributePairs = [];

            foreach ($attributes as $attrName => $attrValue) {
                if (!is_string($attrName)) {
                    continue;
                }

                $lowerName = strtolower($attrName);
                if ($lowerName === 'id' || str_starts_with($lowerName, 'data-gjs-') || str_starts_with($lowerName, 'on')) {
                    continue;
                }

                if (!preg_match('/^[a-zA-Z_:][-a-zA-Z0-9_:.]*$/', $attrName)) {
                    continue;
                }

                if (is_bool($attrValue)) {
                    if ($attrValue) {
                        $attributePairs[] = e($attrName);
                    }
                    continue;
                }

                if (is_scalar($attrValue)) {
                    $attributePairs[] = e($attrName) . '="' . e((string) $attrValue) . '"';
                }
            }

            if ($id) {
                $attributePairs[] = 'id="' . e($id) . '"';
            }

            if (!empty($cleanClasses)) {
                $attributePairs[] = 'class="' . e(implode(' ', $cleanClasses)) . '"';
            }

            if ($styleString) {
                $attributePairs[] = 'style="' . e($styleString) . '"';
            }

            $attributesHtml = implode(' ', $attributePairs);
            $isVoid = in_array($safeTagName, $voidTags, true);
        @endphp

        @if($isVoid)
            {!! '<' . $safeTagName . ($attributesHtml ? ' ' . $attributesHtml : '') . ' />' !!}
        @else
            {!! '<' . $safeTagName . ($attributesHtml ? ' ' . $attributesHtml : '') . '>' !!}
            @if(!empty($components))
                @foreach($components as $childComponent)
                    @if(!isset($childComponent['attributes']['data-gjs-placeholder']))
                        <x-render-component :component="$childComponent" :context="$context" />
                    @endif
                @endforeach
            @elseif($content)
                {!! e($content) !!}
            @endif
            {!! '</' . $safeTagName . '>' !!}
        @endif
@endswitch
