<?php

namespace Tests\Unit\Plugins\Hunt;

use PHPUnit\Framework\TestCase;

class TranslationCoverageTest extends TestCase
{
    private const ROOT = __DIR__.'/../../../../';

    public function test_hunt_js_translation_keys_exist_in_en_messages(): void
    {
        $jsPath = self::ROOT.'plugins/hunt/assets/js/hunt.js';
        $langPath = self::ROOT.'plugins/hunt/resources/lang/en/messages.php';

        $this->assertFileExists($jsPath);
        $this->assertFileExists($langPath);

        $js = file_get_contents($jsPath);
        $this->assertNotFalse($js);

        preg_match_all("/getTranslation\\('([^']+)'/", $js, $matches);
        $keys = array_values(array_unique($matches[1] ?? []));
        sort($keys);

        /** @var array<string, mixed> $translations */
        $translations = require $langPath;
        $flat = $this->flatten($translations);

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $flat, "Missing translation key in hunt::messages: {$key}");
        }
    }

    public function test_hunt_views_do_not_use_raw_close_aria_label(): void
    {
        $viewsPath = self::ROOT.'plugins/hunt/resources/views';
        $this->assertDirectoryExists($viewsPath);

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($viewsPath));

        foreach ($iterator as $file) {
            if (! $file->isFile() || ! str_ends_with($file->getFilename(), '.blade.php')) {
                continue;
            }

            $content = file_get_contents($file->getPathname());
            $this->assertNotFalse($content);

            $this->assertStringNotContainsString(
                'aria-label="Close"',
                $content,
                'Raw "Close" aria-label found in '.$file->getPathname()
            );
        }
    }

    /**
     * @param  array<string, mixed>  $array
     * @return array<string, mixed>
     */
    private function flatten(array $array, string $prefix = ''): array
    {
        $flat = [];

        foreach ($array as $key => $value) {
            $fullKey = $prefix === '' ? (string) $key : $prefix.'.'.$key;

            if (is_array($value)) {
                $flat += $this->flatten($value, $fullKey);
            } else {
                $flat[$fullKey] = $value;
            }
        }

        return $flat;
    }
}
