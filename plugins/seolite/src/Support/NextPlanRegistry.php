<?php

namespace Azuriom\Plugin\SeoLite\Support;

class NextPlanRegistry
{
    public const PLAN_FREEMIUM = 'freemium';
    public const PLAN_PREMIUM = 'premium';

    public const NEXT_PLANS = [
        'article_filters' => [
            'plan' => self::PLAN_FREEMIUM,
            'icon' => 'bi bi-funnel',
            'label' => 'seolite::messages.feature_article_filters',
            'description' => 'seolite::messages.feature_article_filters_desc',
        ],
        'analysis_trends' => [
            'plan' => self::PLAN_FREEMIUM,
            'icon' => 'bi bi-graph-up-arrow',
            'label' => 'seolite::messages.feature_analysis_trends',
            'description' => 'seolite::messages.feature_analysis_trends_desc',
        ],
        'advanced_meta_checks' => [
            'plan' => self::PLAN_FREEMIUM,
            'icon' => 'bi bi-card-checklist',
            'label' => 'seolite::messages.feature_advanced_meta_checks',
            'description' => 'seolite::messages.feature_advanced_meta_checks_desc',
        ],
        'global_site_scan' => [
            'plan' => self::PLAN_PREMIUM,
            'icon' => 'bi bi-diagram-3',
            'label' => 'seolite::messages.feature_global_site_scan',
            'description' => 'seolite::messages.feature_global_site_scan_desc',
        ],
        'competitor_analysis' => [
            'plan' => self::PLAN_PREMIUM,
            'icon' => 'bi bi-binoculars',
            'label' => 'seolite::messages.feature_competitor_analysis',
            'description' => 'seolite::messages.feature_competitor_analysis_desc',
        ],
        'gsc_connect' => [
            'plan' => self::PLAN_PREMIUM,
            'icon' => 'bi bi-google',
            'label' => 'seolite::messages.connect_google_console',
            'description' => 'seolite::messages.feature_gsc_connect_desc',
        ],
        'detailed_reports' => [
            'plan' => self::PLAN_PREMIUM,
            'icon' => 'bi bi-file-earmark-bar-graph',
            'label' => 'seolite::messages.feature_detailed_reports',
            'description' => 'seolite::messages.feature_detailed_reports_desc',
        ],
    ];

    public static function all(): array
    {
        $features = [];

        foreach (self::NEXT_PLANS as $key => $feature) {
            $features[$key] = array_merge($feature, [
                'key' => $key,
                'is_freemium' => $feature['plan'] === self::PLAN_FREEMIUM,
                'is_premium' => $feature['plan'] === self::PLAN_PREMIUM,
            ]);
        }

        return $features;
    }

    public static function grouped(): array
    {
        return [
            self::PLAN_FREEMIUM => array_values(array_filter(
                self::all(),
                static fn (array $feature) => $feature['is_freemium']
            )),
            self::PLAN_PREMIUM => array_values(array_filter(
                self::all(),
                static fn (array $feature) => $feature['is_premium']
            )),
        ];
    }

    public static function get(string $featureKey): ?array
    {
        return self::all()[$featureKey] ?? null;
    }

    public static function isFreemium(string $featureKey): bool
    {
        return (self::get($featureKey)['is_freemium'] ?? false) === true;
    }

    public static function isPremium(string $featureKey): bool
    {
        return (self::get($featureKey)['is_premium'] ?? false) === true;
    }
}
