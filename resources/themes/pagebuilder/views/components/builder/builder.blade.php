@php
    $builderUser = auth()->user();
@endphp

@if($builderUser && $builderUser->isAdmin())
    @php
        $pagebuilderTranslations = [];
        $pagebuilderLang = trans('theme::pagebuilder');
        $route = request()->route();
        $routeName = $route ? $route->getName() : null;
        $path = trim(request()->path(), '/');
        $uri = '/' . $path;
        if ($path === '') {
            $uri = '/';
        }
        $pageIdentifier = $routeName ?: 'uri:' . ($path === '' ? '/' : $path);
        $pagebuilderPageKey = app()->getLocale() . '::' . $pageIdentifier;
        $initialPagebuilderConfig = setting('themes.config.pagebuilder')['pagebuilder'] ?? null;
        $initialPagebuilderStyles = setting('themes.config.pagebuilder')['styles'] ?? null;
        $pagebuilderUserId = auth()->id();

        $azuriomImages = \Azuriom\Models\Image::query()
            ->orderByDesc('id')
            ->get()
            ->map(static function ($image) {
                return [
                    'id' => $image->id,
                    'name' => $image->name ?: $image->file,
                    'url' => $image->url(),
                    'type' => $image->type,
                ];
            })->values()->all();

        $shopEnabled = plugins()->isEnabled('shop') && class_exists(\Azuriom\Plugin\Shop\Models\Package::class);
        $shopPackages = [];
        if ($shopEnabled) {
            $shopPackages = \Azuriom\Plugin\Shop\Models\Package::query()
                ->orderBy('name')
                ->get()
                ->map(static function ($package) {
                    return [
                        'id' => $package->id,
                        'name' => $package->name,
                        'price' => shop_format_amount($package->getPrice()),
                        'has_image' => $package->hasImage(),
                        'image_url' => $package->hasImage() ? $package->imageUrl() : null,
                    ];
                })->values()->all();
        }

        $siteName = site_name();
        $siteLogoUrl = site_logo();
        $siteCopyright = str_replace('{year}', date('Y'), setting('copyright'));
        $siteSocialLinks = collect(social_links())->map(static function ($link) {
            return [
                'title' => $link->title,
                'value' => $link->value,
                'color' => $link->color,
                'icon' => $link->icon,
            ];
        })->values()->all();

        if (is_array($pagebuilderLang)) {
            foreach ($pagebuilderLang as $key => $value) {
                $pagebuilderTranslations["theme::pagebuilder.$key"] = $value;
            }
        }
    @endphp

    <link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" />
    <link rel="stylesheet" href="{{ theme_asset('css/pagebuilder-editor.css') }}" />

    <div class="text-center my-3">
        <button id="editPageBtn" class="btn btn-primary">{{ trans('theme::pagebuilder.edit_page') }}</button>
    </div>

    <script src="https://unpkg.com/grapesjs" defer></script>

    <script>
        window.pagebuilderTranslations = @json($pagebuilderTranslations);
        window.pagebuilderContext = {
            pageKey: @json($pagebuilderPageKey),
            routeName: @json($routeName),
            uri: @json($uri),
            locale: @json(app()->getLocale()),
            userId: @json($pagebuilderUserId),
        };
        window.pagebuilderInitial = {
            pagebuilder: @json($initialPagebuilderConfig),
            styles: @json($initialPagebuilderStyles),
        };
        window.pagebuilderAssets = {
            azuriomImages: @json($azuriomImages),
            shopEnabled: @json($shopEnabled),
            shopPackages: @json($shopPackages),
            siteName: @json($siteName),
            siteLogoUrl: @json($siteLogoUrl),
            siteCopyright: @json($siteCopyright),
            socialLinks: @json($siteSocialLinks),
            canvasEditorStylesUrl: @json(theme_asset('css/pagebuilder-canvas-editor.css')),
        };
        window.pagebuilderState = window.pagebuilderState || {
            rawConfig: window.pagebuilderInitial.pagebuilder || null,
        };

        function trans(key, params = null, fallback = null) {
            const translations = window.pagebuilderTranslations || {};
            const hasOwn = Object.prototype.hasOwnProperty.call(translations, key);
            let value = hasOwn ? translations[key] : (fallback ?? key);

            if (params && typeof value === 'string') {
                Object.keys(params).forEach(function(p) {
                    const re = new RegExp(':' + p, 'g');
                    value = value.replace(re, params[p]);
                });
            }

            return value;
        }
    </script>

    @push('footer-scripts')
        <script src="{{ theme_asset('js/blocks/registry.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/categories/layout.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/categories/components.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/categories/site.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/categories/page.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/categories/custom.js') }}" defer></script>

        <script src="{{ theme_asset('js/blocks/layout/bootstrap-container.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/layout/layout-row.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/layout/bootstrap-col-12.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/layout/bootstrap-col-8.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/layout/bootstrap-col-6.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/layout/bootstrap-col-4.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/layout/bootstrap-col-3.js') }}" defer></script>

        <script src="{{ theme_asset('js/blocks/components/text.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/components/pb-image.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/components/pb-icon.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/components/bs-button.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/components/bs-section.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/components/bs-navbar.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/components/bs-card.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/components/bs-alert.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/components/bs-badge.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/components/bs-accordion.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/components/bs-tabs.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/components/bs-carousel.js') }}" defer></script>

        <script src="{{ theme_asset('js/blocks/site/site-navigation.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/site/site-user-navigation.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/site/site-logo.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/site/site-theme-toggle.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/site/site-social-links.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/site/site-copyright.js') }}" defer></script>

        <script src="{{ theme_asset('js/blocks/page/page-vote-card.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/page/page-vote-top.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/page/page-vote-rewards.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/page/page-shop-sidebar.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/page/page-shop-home.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/page/page-shop-category-description.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/page/page-shop-category-packages.js') }}" defer></script>

        <script src="{{ theme_asset('js/blocks/custom/custom-html-safe.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/custom/custom-highlight-shop.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/custom/custom-hero-split.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/custom/custom-stats-grid.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/custom/custom-feature-cards.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/custom/custom-cta-ribbon.js') }}" defer></script>
        <script src="{{ theme_asset('js/blocks/custom/custom-trailer-card.js') }}" defer></script>

        <script src="{{ theme_asset('js/gjs.blocks.js') }}" defer></script>
        <script src="{{ theme_asset('js/gjs.traits.js') }}" defer></script>
        <script src="{{ theme_asset('js/gjs.components.js') }}" defer></script>
        <script src="{{ theme_asset('js/gjs.components.custom.js') }}" defer></script>
        <script src="{{ theme_asset('js/gjs.commands.js') }}" defer></script>
        <script src="{{ theme_asset('js/gjs.rte.js') }}" defer></script>
        <script src="{{ theme_asset('js/gjs.stylemanager.js') }}" defer></script>
        <script src="{{ theme_asset('js/gjs.globals.js') }}" defer></script>
        <script src="{{ theme_asset('js/gjs.theme.js') }}" defer></script>
        <script src="{{ theme_asset('js/gjs.init.js') }}" defer></script>
    @endpush

    <div id="gjs" style="display:none;"></div>
    <div class="text-center mt-2" style="display:none;" id="gpsActions">
        <button id="saveBtn" class="btn btn-success">{{ trans('theme::pagebuilder.save') }}</button>
        <button id="closeBtn" class="btn btn-secondary">{{ trans('theme::pagebuilder.close') }}</button>
    </div>

    <script>
        let editor;

        window.pagebuilderRoutes = {
            themeEdit: "{{ route('admin.themes.edit', 'pagebuilder') }}",
            themeConfig: "{{ route('admin.themes.config', 'pagebuilder') }}",
        };

        document.getElementById('saveBtn')?.addEventListener('click', () => {
            if (!editor) {
                alert(trans('theme::pagebuilder.editor_not_initialized'));
                return;
            }

            const components = editor.getComponents();

            const cleanPlaceholders = (component) => {
                if (!component) {
                    return null;
                }

                const cleanComponent = typeof component.toJSON === 'function'
                    ? component.toJSON()
                    : component;

                if (cleanComponent?.attributes?.['data-gjs-placeholder']) {
                    return null;
                }

                if (cleanComponent?.type === 'site-notifications') {
                    return null;
                }

                if (cleanComponent?.attributes) {
                    delete cleanComponent.attributes['data-gjs-empty-label'];
                }

                if (Array.isArray(cleanComponent.components)) {
                    cleanComponent.components = cleanComponent.components
                        .map((child) => cleanPlaceholders(child))
                        .filter((child) => child !== null);
                }

                return cleanComponent;
            };

            const obj = {};
            components.forEach((comp, index) => {
                const cleanComp = cleanPlaceholders(comp);
                if (!cleanComp) {
                    return;
                }

                const key = cleanComp.attributes?.id || `comp${index}`;
                obj[key] = cleanComp;
            });

            let themeData = {};
            try {
                const savedTheme = localStorage.getItem('pagebuilder-bs-theme');
                if (savedTheme) {
                    themeData = JSON.parse(savedTheme);
                }
            } catch (e) {
                console.warn(trans('theme::pagebuilder.error_reading_theme'), e);
            }

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            const pagebuilderConfig = typeof window.pagebuilderBuildConfigForSave === 'function'
                ? window.pagebuilderBuildConfigForSave(obj, themeData, editor.getCss ? editor.getCss() : '')
                : obj;

            formData.append('pagebuilder', JSON.stringify(pagebuilderConfig));
            formData.append('styles', JSON.stringify(themeData));

            axios.post(window.pagebuilderRoutes.themeConfig, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            }).then(() => {
                window.pagebuilderState.rawConfig = pagebuilderConfig;
                alert(trans('theme::pagebuilder.page_saved'));
            }).catch((error) => {
                console.error('PageBuilder save failed:', error);
                alert(trans('theme::pagebuilder.save_error', null, 'Erreur lors de la sauvegarde de la page.'));
            });
        });

        document.getElementById('closeBtn')?.addEventListener('click', () => {
            if (typeof window.pagebuilderSetEditorOpenState === 'function') {
                window.pagebuilderSetEditorOpenState(false);
                return;
            }

            document.getElementById('gjs')?.style && (document.getElementById('gjs').style.display = 'none');
            document.getElementById('gpsActions')?.style && (document.getElementById('gpsActions').style.display = 'none');
            document.body.classList.remove('pagebuilder-editor-open');
        });
    </script>
@endif
