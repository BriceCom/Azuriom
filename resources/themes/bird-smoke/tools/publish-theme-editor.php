#!/usr/bin/env php
<?php

declare(strict_types=1);

$themeRoot = realpath(__DIR__ . '/..');
if (! is_string($themeRoot) || $themeRoot === '') {
    fwrite(STDERR, "Unable to resolve theme root.\n");
    exit(1);
}

$targetRoot = $argv[1] ?? null;
if (! is_string($targetRoot) || trim($targetRoot) === '') {
    fwrite(STDERR, "Usage: php tools/publish-theme-editor.php <target-dir>\n");
    exit(1);
}

$targetRoot = rtrim($targetRoot, DIRECTORY_SEPARATOR);
if ($targetRoot === '') {
    fwrite(STDERR, "Invalid target directory.\n");
    exit(1);
}

$themeRootWithSep = $themeRoot . DIRECTORY_SEPARATOR;
$targetRootWithSep = $targetRoot . DIRECTORY_SEPARATOR;
if (str_starts_with($targetRootWithSep, $themeRootWithSep)) {
    fwrite(STDERR, "Target directory must be outside the theme source tree.\n");
    exit(1);
}

$excludePrefixes = [
    '.git/',
    'views/theme-editor/resources/',
    'tools/',
    'start-to-publish.md',
    'next_features.md',
    'use-theme-editor.md',
    '.gitattributes',
];

$shouldExclude = static function (string $relativePath) use ($excludePrefixes): bool {
    $normalized = ltrim(str_replace('\\', '/', $relativePath), '/');

    foreach ($excludePrefixes as $prefix) {
        if ($normalized === rtrim($prefix, '/')) {
            return true;
        }

        if (str_starts_with($normalized, $prefix)) {
            return true;
        }
    }

    return false;
};

$clearDirectory = static function (string $directory) use (&$clearDirectory): void {
    if (! is_dir($directory)) {
        return;
    }

    $items = scandir($directory);
    if (! is_array($items)) {
        throw new RuntimeException("Unable to read directory: {$directory}");
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }

        $path = $directory . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            $clearDirectory($path);
            if (! rmdir($path)) {
                throw new RuntimeException("Unable to remove directory: {$path}");
            }
            continue;
        }

        if (is_file($path) && ! unlink($path)) {
            throw new RuntimeException("Unable to remove file: {$path}");
        }
    }
};

$copyItem = static function (string $source, string $target) use (&$copyItem, $shouldExclude, $themeRoot): void {
    if (is_dir($source)) {
        if (! is_dir($target) && ! mkdir($target, 0775, true) && ! is_dir($target)) {
            throw new RuntimeException("Unable to create directory: {$target}");
        }

        $items = scandir($source);
        if (! is_array($items)) {
            throw new RuntimeException("Unable to read directory: {$source}");
        }

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $childSource = $source . DIRECTORY_SEPARATOR . $item;
            $relativePath = ltrim(str_replace($themeRoot . DIRECTORY_SEPARATOR, '', $childSource), DIRECTORY_SEPARATOR);
            if ($shouldExclude($relativePath)) {
                continue;
            }

            $childTarget = $target . DIRECTORY_SEPARATOR . $item;
            $copyItem($childSource, $childTarget);
        }

        return;
    }

    if (! is_file($source)) {
        return;
    }

    $parentDir = dirname($target);
    if (! is_dir($parentDir) && ! mkdir($parentDir, 0775, true) && ! is_dir($parentDir)) {
        throw new RuntimeException("Unable to create directory: {$parentDir}");
    }

    if (! copy($source, $target)) {
        throw new RuntimeException("Unable to copy {$source} to {$target}");
    }
};

try {
    if (! is_dir($targetRoot) && ! mkdir($targetRoot, 0775, true) && ! is_dir($targetRoot)) {
        throw new RuntimeException("Unable to create target directory: {$targetRoot}");
    }

    $clearDirectory($targetRoot);
    $copyItem($themeRoot, $targetRoot);

    echo "Published theme-editor package to {$targetRoot}\n";
} catch (Throwable $exception) {
    fwrite(STDERR, $exception->getMessage() . "\n");
    exit(1);
}
