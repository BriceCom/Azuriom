@php
    $attributes = $component['attributes'] ?? [];
    $classes = $component['classes'] ?? [];
    $style = $component['style'] ?? [];

    $rawHtml = is_string($attributes['data-html'] ?? null) ? $attributes['data-html'] : '';
    $rawCss = is_string($attributes['data-css'] ?? null) ? $attributes['data-css'] : '';

    $providedId = is_string($attributes['id'] ?? null) ? trim($attributes['id']) : '';
    $safeComponentId = preg_match('/^[A-Za-z][A-Za-z0-9_:\\.-]*$/', $providedId) === 1 ? $providedId : '';
    $scopeId = $safeComponentId !== '' ? $safeComponentId : 'pb-html-safe-' . substr(sha1($rawHtml . '|' . $rawCss), 0, 12);

    $allowedTags = [
        'div', 'section', 'article', 'aside', 'header', 'footer', 'main', 'nav',
        'p', 'span', 'small', 'strong', 'em', 'b', 'i', 'u', 'code', 'pre', 'blockquote',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'ul', 'ol', 'li',
        'a', 'button', 'label', 'input', 'textarea', 'select', 'option',
        'table', 'thead', 'tbody', 'tr', 'th', 'td',
        'img', 'hr', 'br',
    ];

    $allowedGlobalAttributes = ['id', 'class', 'title', 'style', 'role', 'tabindex'];
    $allowedTagAttributes = [
        'a' => ['href', 'target', 'rel'],
        'img' => ['src', 'alt', 'width', 'height', 'loading'],
        'input' => ['type', 'name', 'value', 'placeholder', 'checked', 'disabled', 'readonly', 'min', 'max', 'step', 'autocomplete'],
        'textarea' => ['name', 'rows', 'cols', 'placeholder', 'disabled', 'readonly'],
        'select' => ['name', 'multiple', 'disabled'],
        'option' => ['value', 'selected', 'disabled'],
        'button' => ['type', 'disabled'],
        'th' => ['scope', 'colspan', 'rowspan'],
        'td' => ['colspan', 'rowspan'],
    ];

    $sanitizeUrl = static function (string $url): ?string {
        $url = trim($url);
        if ($url === '') {
            return null;
        }

        $decoded = strtolower(html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $normalized = preg_replace('/\s+/', '', $decoded) ?? $decoded;
        if (
            str_starts_with($normalized, 'javascript:') ||
            str_starts_with($normalized, 'vbscript:') ||
            str_starts_with($normalized, 'data:')
        ) {
            return null;
        }

        if (
            str_starts_with($url, '#') ||
            str_starts_with($url, '/') ||
            str_starts_with($url, './') ||
            str_starts_with($url, '../')
        ) {
            return $url;
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);
        if ($scheme === null) {
            return $url;
        }

        $scheme = strtolower($scheme);
        if (in_array($scheme, ['http', 'https', 'mailto', 'tel'], true)) {
            return $url;
        }

        return null;
    };

    $sanitizeInlineCss = static function (string $css): string {
        $css = preg_replace('/\/\*.*?\*\//s', '', $css) ?? '';
        $declarations = preg_split('/;/', $css) ?: [];
        $safeDeclarations = [];

        foreach ($declarations as $declaration) {
            if (!str_contains($declaration, ':')) {
                continue;
            }

            [$property, $value] = explode(':', $declaration, 2);
            $property = strtolower(trim($property));
            $value = trim($value);

            if ($property === '' || $value === '') {
                continue;
            }

            $isStandardProperty = preg_match('/^[a-z][a-z0-9-]*$/', $property) === 1;
            $isCustomProperty = preg_match('/^--[a-z0-9_-]+$/', $property) === 1;
            if (!$isStandardProperty && !$isCustomProperty) {
                continue;
            }

            if (preg_match('/(?:expression\s*\(|behavior\s*:|-moz-binding|@import|<\/style|<script|javascript:|vbscript:)/i', $value) === 1) {
                continue;
            }

            if (preg_match_all('/url\s*\(([^)]*)\)/i', $value, $urlMatches) >= 1) {
                foreach ($urlMatches[1] as $rawUrlValue) {
                    $urlValue = trim($rawUrlValue, " \t\n\r\0\x0B'\"");
                    $decodedUrl = strtolower(html_entity_decode($urlValue, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                    $normalizedUrl = preg_replace('/\s+/', '', $decodedUrl) ?? $decodedUrl;

                    if (
                        str_starts_with($normalizedUrl, 'javascript:') ||
                        str_starts_with($normalizedUrl, 'vbscript:') ||
                        str_starts_with($normalizedUrl, 'data:')
                    ) {
                        continue 2;
                    }
                }
            }

            $safeDeclarations[] = $property . ': ' . $value;
        }

        return implode('; ', $safeDeclarations);
    };

    $sanitizeScopedCss = static function (string $css, string $scopeSelector) use ($sanitizeInlineCss): string {
        $css = trim($css);
        if ($css === '') {
            return '';
        }

        $css = preg_replace('/\/\*.*?\*\//s', '', $css) ?? '';
        if ($css === '') {
            return '';
        }

        $rules = [];
        $matches = [];
        preg_match_all('/([^{}]+)\{([^{}]*)\}/', $css, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $selectorsRaw = trim($match[1] ?? '');
            $declarationsRaw = trim($match[2] ?? '');

            if ($selectorsRaw === '' || $declarationsRaw === '' || str_starts_with($selectorsRaw, '@')) {
                continue;
            }

            $selectors = array_filter(array_map('trim', explode(',', $selectorsRaw)));
            $scopedSelectors = [];

            foreach ($selectors as $selector) {
                if (
                    preg_match('/[<>"`]/', $selector) === 1 ||
                    preg_match('/(?:expression|javascript:|vbscript:|@import)/i', $selector) === 1
                ) {
                    continue;
                }

                if (preg_match('/\b(html|body|:root)\b/i', $selector) === 1) {
                    continue;
                }

                $scopedSelectors[] = $scopeSelector . ' ' . $selector;
            }

            if (empty($scopedSelectors)) {
                continue;
            }

            $safeDeclarations = $sanitizeInlineCss($declarationsRaw);
            if ($safeDeclarations === '') {
                continue;
            }

            $rules[] = implode(', ', $scopedSelectors) . ' { ' . $safeDeclarations . '; }';
        }

        return implode("\n", $rules);
    };

    $sanitizeHtml = static function (string $html) use ($allowedTags, $allowedGlobalAttributes, $allowedTagAttributes, $sanitizeUrl, $sanitizeInlineCss): string {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        if (!class_exists(\DOMDocument::class)) {
            $stripped = preg_replace('/<(script|iframe|object|embed|link|meta|base)[^>]*>.*?<\/\1>/is', '', $html) ?? '';
            $safeFallback = strip_tags($stripped, '<div><section><article><aside><header><footer><main><nav><p><span><small><strong><em><b><i><u><code><pre><blockquote><h1><h2><h3><h4><h5><h6><ul><ol><li><a><button><label><input><textarea><select><option><table><thead><tbody><tr><th><td><img><hr><br>');
            $safeFallback = preg_replace('/\son[a-z0-9_-]+\s*=\s*(".*?"|\'.*?\'|[^\s>]+)/iu', '', $safeFallback) ?? '';
            $safeFallback = preg_replace('/\s(href|src)\s*=\s*("|\')\s*(javascript:|vbscript:|data:).*?\2/iu', '', $safeFallback) ?? '';

            return $safeFallback;
        }

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $wrappedHtml = '<?xml encoding="utf-8" ?><!DOCTYPE html><html><body><div id="pb-safe-root">' . $html . '</div></body></html>';
        $previousLibxmlState = libxml_use_internal_errors(true);
        $loaded = $dom->loadHTML($wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        if (!$loaded) {
            libxml_clear_errors();
            libxml_use_internal_errors($previousLibxmlState);

            return '';
        }

        $root = $dom->getElementById('pb-safe-root');
        if (!$root) {
            libxml_clear_errors();
            libxml_use_internal_errors($previousLibxmlState);

            return '';
        }

        $sanitizeNode = null;
        $sanitizeNode = static function (\DOMNode $parent) use (&$sanitizeNode, $allowedTags, $allowedGlobalAttributes, $allowedTagAttributes, $sanitizeUrl, $sanitizeInlineCss): void {
            $children = [];
            foreach ($parent->childNodes as $childNode) {
                $children[] = $childNode;
            }

            foreach ($children as $child) {
                if ($child->nodeType === XML_COMMENT_NODE) {
                    $parent->removeChild($child);
                    continue;
                }

                if ($child->nodeType !== XML_ELEMENT_NODE) {
                    continue;
                }

                $tag = strtolower($child->nodeName);
                if (!in_array($tag, $allowedTags, true)) {
                    while ($child->firstChild) {
                        $parent->insertBefore($child->firstChild, $child);
                    }
                    $parent->removeChild($child);
                    continue;
                }

                if ($child->hasAttributes()) {
                    $attributesList = [];
                    foreach ($child->attributes as $attributeNode) {
                        $attributesList[] = $attributeNode;
                    }

                    foreach ($attributesList as $attribute) {
                        $attributeName = strtolower($attribute->name);
                        $attributeValue = $attribute->value;
                        $isDataAttribute = str_starts_with($attributeName, 'data-');
                        $isAriaAttribute = str_starts_with($attributeName, 'aria-');

                        $isAllowedAttribute = (
                            in_array($attributeName, $allowedGlobalAttributes, true) ||
                            in_array($attributeName, $allowedTagAttributes[$tag] ?? [], true) ||
                            $isDataAttribute ||
                            $isAriaAttribute
                        );

                        if (!$isAllowedAttribute || str_starts_with($attributeName, 'on')) {
                            $child->removeAttributeNode($attribute);
                            continue;
                        }

                        if ($attributeName === 'style') {
                            $safeStyle = $sanitizeInlineCss($attributeValue);
                            if ($safeStyle === '') {
                                $child->removeAttributeNode($attribute);
                            } else {
                                $child->setAttribute('style', $safeStyle);
                            }
                            continue;
                        }

                        if (in_array($attributeName, ['href', 'src'], true)) {
                            $safeUrl = $sanitizeUrl($attributeValue);
                            if ($safeUrl === null) {
                                $child->removeAttributeNode($attribute);
                            } else {
                                $child->setAttribute($attributeName, $safeUrl);
                            }
                            continue;
                        }

                        if ($tag === 'a' && $attributeName === 'target') {
                            $target = strtolower(trim($attributeValue));
                            if (!in_array($target, ['_self', '_blank'], true)) {
                                $child->removeAttributeNode($attribute);
                            } else {
                                $child->setAttribute('target', $target);
                            }
                        }
                    }
                }

                if ($tag === 'a' && strtolower(trim($child->getAttribute('target'))) === '_blank') {
                    $relValues = preg_split('/\s+/', strtolower(trim($child->getAttribute('rel')))) ?: [];
                    $relValues = array_values(array_filter($relValues));

                    if (!in_array('noopener', $relValues, true)) {
                        $relValues[] = 'noopener';
                    }

                    if (!in_array('noreferrer', $relValues, true)) {
                        $relValues[] = 'noreferrer';
                    }

                    $child->setAttribute('rel', implode(' ', $relValues));
                }

                $sanitizeNode($child);
            }
        };

        $sanitizeNode($root);

        $safeHtml = '';
        $rootChildren = [];
        foreach ($root->childNodes as $childNode) {
            $rootChildren[] = $childNode;
        }

        foreach ($rootChildren as $childNode) {
            $safeHtml .= $dom->saveHTML($childNode);
        }

        libxml_clear_errors();
        libxml_use_internal_errors($previousLibxmlState);

        return $safeHtml;
    };

    $sanitizedHtml = $sanitizeHtml($rawHtml);
    $sanitizedCss = $sanitizeScopedCss($rawCss, '#' . $scopeId);

    $cleanClasses = array_values(array_filter($classes, static function ($class): bool {
        return is_string($class) && preg_match('/^[A-Za-z0-9_-]+$/', $class) === 1;
    }));

    if (empty($cleanClasses)) {
        $cleanClasses = ['pb-custom-html-safe'];
    }

    $containerStyleDeclarations = [];
    if (is_array($style)) {
        foreach ($style as $property => $value) {
            if (!is_string($property) || !is_scalar($value)) {
                continue;
            }

            $declaration = $sanitizeInlineCss($property . ':' . (string) $value);
            if ($declaration !== '') {
                $containerStyleDeclarations[] = $declaration;
            }
        }
    }
    $containerStyle = implode('; ', $containerStyleDeclarations);
@endphp

<div
    id="{{ $scopeId }}"
    @class($cleanClasses)
    @if($containerStyle !== '') style="{{ e($containerStyle) }}" @endif
>
    {!! $sanitizedHtml !!}
</div>

@if($sanitizedCss !== '')
    <style>{!! $sanitizedCss !!}</style>
@endif
