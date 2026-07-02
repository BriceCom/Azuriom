<?php

namespace Azuriom\Plugin\Hunt\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    /**
     * Show the hunt settings form.
     */
    public function show()
    {
        return view('hunt::admin.settings');
    }

    /**
     * Update hunt settings.
     */
    public function update(Request $request)
    {
        return Redirect::route('hunt.admin.settings.index')->with('success', trans('hunt::admin.settings.settings_updated'));
    }

    /**
     * Get hunt settings with defaults.
     */
    public static function getHuntSettings(): array
    {
        return [
        ];
    }



    /**
     * Check if a route matches a specific pattern.
     */
    private static function routeMatchesPattern(string $route, string $pattern): bool
    {
        $route = trim($route, '/');
        $pattern = trim($pattern, '/');

        if ($route === $pattern) {
            return true;
        }

        if (str_contains($pattern, '*')) {
            $regexPattern = str_replace(['*', '/'], ['.*', '\/'], $pattern);
            return preg_match('/^' . $regexPattern . '$/i', $route);
        }

        if (str_ends_with($pattern, '/')) {
            return str_starts_with($route . '/', $pattern);
        }

        return false;
    }

    /**
     * Check if hunt should be displayed on current route.
     */
    public static function shouldDisplayHunt(string $currentRoute): bool
    {
        $currentRoute = trim($currentRoute, '/');

        $excludedPatterns = [
            'admin*',
            'api*',
            'profile*',
            'login',
            'register',
        ];

        foreach ($excludedPatterns as $pattern) {
            if (self::routeMatchesPattern($currentRoute, $pattern)) {
                return false;
            }
        }

        return true;
    }
}
