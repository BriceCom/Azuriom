@php
    $rebornBuilderUser = auth()->user();
@endphp

@if($rebornBuilderUser && $rebornBuilderUser->isAdmin())
    @php
        $rebornTranslations = [];
        $rebornLang = trans('theme::reborn');
        if (is_array($rebornLang)) {
            foreach ($rebornLang as $rebornKey => $rebornValue) {
                $rebornTranslations["theme::reborn.{$rebornKey}"] = $rebornValue;
            }
        }

        $rebornRoute = request()->route();
        $rebornRouteName = $rebornRoute ? $rebornRoute->getName() : null;
        $rebornPath = trim(request()->path(), '/');
        $rebornUri = '/'.$rebornPath;
        if ($rebornPath === '') {
            $rebornUri = '/';
        }
        $rebornPageIdentifier = $rebornRouteName ?: 'uri:'.($rebornPath === '' ? '/' : $rebornPath);
        $rebornPageKey = app()->getLocale().'::'.$rebornPageIdentifier;

        $rebornInitialComposer = setting('themes.config.reborn')['composer'] ?? null;
        $rebornRegistry = require resource_path('themes/reborn/config/components.php');
        $rebornFeatures = [
            'shop' => plugins()->isEnabled('shop'),
            'vote' => plugins()->isEnabled('vote'),
        ];
    @endphp

    <button type="button" class="btn btn-primary reborn-builder-btn shadow-sm" id="rebornBuilderOpenBtn">
        <i class="bi bi-sliders"></i> {{ trans('theme::reborn.open_builder') }}
    </button>

    <div class="offcanvas offcanvas-end reborn-composer-offcanvas" tabindex="-1" id="rebornComposerOffcanvas" aria-labelledby="rebornComposerLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="rebornComposerLabel">{{ trans('theme::reborn.builder_title') }}</h5>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-success btn-sm" id="rebornComposerSaveBtn">
                    <i class="bi bi-save"></i> {{ trans('theme::reborn.save') }}
                </button>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="{{ trans('theme::reborn.close') }}"></button>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="reborn-builder-grid">
                <div class="d-grid gap-3">
                    <section class="reborn-section-box">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">{{ trans('theme::reborn.global_blocks') }}</h6>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-reborn-add="global">
                                <i class="bi bi-plus-lg"></i> {{ trans('theme::reborn.add_block') }}
                            </button>
                        </div>
                        <div class="reborn-block-list" id="rebornGlobalBlocks"></div>
                    </section>

                    <section class="reborn-section-box">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">{{ trans('theme::reborn.global_sidebar_blocks') }}</h6>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-reborn-add="sidebar">
                                <i class="bi bi-plus-lg"></i> {{ trans('theme::reborn.add_block') }}
                            </button>
                        </div>
                        <div class="reborn-block-list" id="rebornSidebarBlocks"></div>
                    </section>

                    <section class="reborn-section-box">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">{{ trans('theme::reborn.page_blocks') }}</h6>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-reborn-add="page">
                                <i class="bi bi-plus-lg"></i> {{ trans('theme::reborn.add_block') }}
                            </button>
                        </div>
                        <div class="reborn-block-list" id="rebornPageBlocks"></div>
                    </section>
                </div>

                <div class="d-grid gap-3">
                    <div class="reborn-section-box">
                        <ul class="nav nav-tabs mb-3" id="rebornEditorTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="reborn-block-tab" data-bs-toggle="tab" data-bs-target="#reborn-block-pane"
                                        type="button" role="tab" aria-controls="reborn-block-pane" aria-selected="true">
                                    {{ trans('theme::reborn.settings') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reborn-theme-tab" data-bs-toggle="tab" data-bs-target="#reborn-theme-pane"
                                        type="button" role="tab" aria-controls="reborn-theme-pane" aria-selected="false">
                                    {{ trans('theme::reborn.theme_settings') }}
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="reborn-block-pane" role="tabpanel" aria-labelledby="reborn-block-tab">
                                <div id="rebornBlockEditor"></div>
                            </div>
                            <div class="tab-pane fade" id="reborn-theme-pane" role="tabpanel" aria-labelledby="reborn-theme-tab">
                                <div id="rebornThemeEditor"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rebornAddBlockModal" tabindex="-1" aria-labelledby="rebornAddBlockModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rebornAddBlockModalLabel">{{ trans('theme::reborn.add_block') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ trans('theme::reborn.close') }}"></button>
                </div>
                <div class="modal-body" id="rebornAddBlockModalBody"></div>
            </div>
        </div>
    </div>

    <script>
        window.rebornComposerBoot = {
            csrfToken: @json(csrf_token()),
            translations: @json($rebornTranslations),
            initialComposer: @json($rebornInitialComposer),
            registry: @json($rebornRegistry),
            features: @json($rebornFeatures),
            context: {
                pageKey: @json($rebornPageKey),
                routeName: @json($rebornRouteName),
                uri: @json($rebornUri),
                locale: @json(app()->getLocale()),
                userId: @json(auth()->id()),
            },
            routes: {
                config: @json(route('admin.themes.config', 'reborn')),
            },
        };
    </script>

    @push('footer-scripts')
        <script src="{{ theme_asset('js/reborn-composer.js') }}" defer></script>
    @endpush
@endif
