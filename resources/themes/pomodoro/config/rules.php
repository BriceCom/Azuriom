<?php

return [
    'settings' => ['nullable', 'array'],
    'home' => ['nullable', 'array'],
    'footer' => ['nullable', 'array'],
    'style' => ['nullable', 'array'],

    'settings.server' => ['nullable', 'array'],
    'settings.server.launcher' => ['nullable', 'boolean'],
    'settings.server.url' => ['nullable', 'string', 'max:255'],
    'settings.server.text' => ['nullable', 'string', 'max:120'],
    'settings.server.ip' => ['nullable', 'string', 'max:120'],
    'settings.server.copied_text' => ['nullable', 'string', 'max:255'],

    'home.hero' => ['nullable', 'array'],
    'home.hero.enabled' => ['nullable', 'boolean'],
    'home.hero.title' => ['nullable', 'string', 'max:255'],
    'home.hero.subtitle' => ['nullable', 'string', 'max:1000'],
    'home.hero.primary_button_text' => ['nullable', 'string', 'max:100'],
    'home.hero.primary_button_url' => ['nullable', 'string', 'max:255'],
    'home.hero.image' => ['nullable', 'string', 'max:1000'],

    'home.trailer' => ['nullable', 'array'],
    'home.trailer.enabled' => ['nullable', 'boolean'],
    'home.trailer.title' => ['nullable', 'string', 'max:255'],
    'home.trailer.subtitle' => ['nullable', 'string', 'max:1000'],
    'home.trailer.video_url' => ['nullable', 'string', 'max:1000'],
    'home.trailer.button_text' => ['nullable', 'string', 'max:100'],
    'home.trailer.button_url' => ['nullable', 'string', 'max:1000'],

    'home.features' => ['nullable', 'array'],
    'home.features.enabled' => ['nullable', 'boolean'],
    'home.features.title' => ['nullable', 'string', 'max:255'],
    'home.features.items' => ['nullable', 'array'],
    'home.features.items.*.icon' => ['nullable', 'string', 'max:100'],
    'home.features.items.*.title' => ['nullable', 'string', 'max:255'],
    'home.features.items.*.text' => ['nullable', 'string', 'max:1000'],

    'home.testimonial' => ['nullable', 'array'],
    'home.testimonial.enabled' => ['nullable', 'boolean'],
    'home.testimonial.quote' => ['nullable', 'string', 'max:1500'],
    'home.testimonial.author' => ['nullable', 'string', 'max:255'],
    'home.testimonial.role' => ['nullable', 'string', 'max:255'],
    'home.testimonial.avatar' => ['nullable', 'string', 'max:1000'],

    'home.servers' => ['nullable', 'array'],
    'home.servers.enabled' => ['nullable', 'boolean'],

    'home.blog' => ['nullable', 'array'],
    'home.blog.enabled' => ['nullable', 'boolean'],
    'home.blog.title' => ['nullable', 'string', 'max:255'],
    'home.blog.subtitle' => ['nullable', 'string', 'max:1000'],

    'footer.main' => ['nullable', 'array'],
    'footer.main.title' => ['nullable', 'string', 'max:255'],
    'footer.main.text' => ['nullable', 'string', 'max:1500'],

    'footer.navigation' => ['nullable', 'array'],
    'footer.navigation.title' => ['nullable', 'string', 'max:255'],
    'footer.navigation.links' => ['nullable', 'array'],
    'footer.navigation.links.*.icon' => ['nullable', 'string', 'max:60'],
    'footer.navigation.links.*.name' => ['nullable', 'string', 'max:120'],
    'footer.navigation.links.*.url' => ['nullable', 'string', 'max:255'],
    'footer.navigation.links.*.new_tab' => ['nullable', 'boolean'],

    'footer.contact' => ['nullable', 'array'],
    'footer.contact.title' => ['nullable', 'string', 'max:255'],
    'footer.contact.links' => ['nullable', 'array'],
    'footer.contact.links.*.icon' => ['nullable', 'string', 'max:60'],
    'footer.contact.links.*.name' => ['nullable', 'string', 'max:120'],
    'footer.contact.links.*.url' => ['nullable', 'string', 'max:255'],
    'footer.contact.links.*.new_tab' => ['nullable', 'boolean'],

    'style.colors' => ['nullable', 'array'],
    'style.colors.light' => ['nullable', 'array'],
    'style.colors.dark' => ['nullable', 'array'],

    'style.colors.light.primary' => ['nullable', new \Azuriom\Rules\Color()],
    'style.colors.light.body_color' => ['nullable', new \Azuriom\Rules\Color()],
    'style.colors.light.dark' => ['nullable', new \Azuriom\Rules\Color()],

    'style.colors.dark.primary' => ['nullable', new \Azuriom\Rules\Color()],
    'style.colors.dark.body_color' => ['nullable', new \Azuriom\Rules\Color()],
    'style.colors.dark.dark' => ['nullable', new \Azuriom\Rules\Color()],
];
