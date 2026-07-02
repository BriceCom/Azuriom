<?php

return static function (?string $routeName, ?string $routePattern, string $routePath) use ($withLayoutBlocks): array {
    $normalizedRouteName = strtolower(trim((string) $routeName));
    if ($routePath === '/' || $normalizedRouteName === 'home') {
        return $withLayoutBlocks(['hero', 'features', 'servers', 'news', 'steps', 'stats', 'cta']);
    }

    return $withLayoutBlocks(['page_content']);
};
