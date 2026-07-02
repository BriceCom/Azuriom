<div>
    <div class="d-flex flex-wrap flex-xl-nowrap gap-3 gap-xl--5">
        <div class="w-100 card m-0">
            <div class="card-body">
                <h2 class="fw-semibold">{{ trans('theme::admin.thanks_download', ['type' => $current_theme['type']]) }}</h2>

                <p>
                    {{ trans('theme::admin.hope_project') }}
                </p>

                <p>
                    {!! trans('theme::admin.if_you_enjoy', [
                        'url' => $current_theme['info_url'].'#if-you-like-the-resource-like-below-'
                    ]) !!}
                </p>

                <p><b>{{ trans('theme::admin.need_help') }}</b> {{ trans('theme::admin.click_support') }}</p>

                <div>
                    <ul class="list-unstyled d-flex gap-2 flex-wrap mb-0">
                        <li>
                            <a href="https://discord.gg/Gh2yBxUWvV" target="_blank"
                               class="btn btn-primary fw-bold text-uppercase px-3">
                                <i class="bi bi-discord me-1"></i>{{ trans('theme::admin.support') }}
                            </a>
                        </li>
                        <li>
                            <a href="https://www.serveurliste.com" target="_blank"
                               class="btn btn-outline-warning fw-bold text-uppercase px-3">
                                <i class="bi bi-search-heart-fill me-1"></i>{{ trans('theme::admin.list_server_on_serverliste') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col col-xl-4 d-flex flex-column gap-2">
            <div class="card mb-0 flex-grow-1">
                <div class="card-body d-flex flex-row gap-3">
                    <div>
                        <img src="{{ theme_asset('img/dixept.webp') }}" alt="Logo Dixept" width="148" height="64"
                             class="img-fluid rounded-3">
                    </div>

                    <div>
                        <p class="fw-semibold mb-1">{{ trans('theme::admin.developed_by') }} <a href="https://dixept.fr" target="_blank">Dixept</a></p>
                        <p class="opacity-75 mb-1">{{ trans('theme::admin.unique_identity') }}</p>
                        <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" class="btn btn-primary btn-sm">
                            {{ trans('theme::admin.custom_theme_plugin') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mb-0">
                <div class="card-body">
                    <h2 class="fw-bold text-muted fs-5">{{ trans('theme::admin.check_other_resources') }}</h2>

                    <div class="d-flex flex-wrap flex-md-row gap-2">
                        @include('components.admin.partials.resource-listing', [
                            'icon' => "bi bi-palette",
                            'title' => trans('theme::admin.themes'),
                            'resources' => $themes_own
                        ])

                        @include('components.admin.partials.resource-listing', [
                              'icon' => "bi bi-plug",
                              'title' => trans('theme::admin.plugins'),
                              'resources' => $plugins_own
                        ])
                    </div>
                </div>
            </div>

            <ul class="list-unstyled d-flex gap-2 flex-wrap mb-0">
                <li class="flex-grow-1">
                    <a href="{{ $current_theme['info_url'].'#if-you-like-the-resource-like-below-' }}" target="_blank"
                       class="w-100 btn bg-danger bg-opacity-10 text-danger-emphasis border border-danger border-opacity-25">
                        {{ trans('theme::admin.like_resource', [
                            'type' => $current_theme['type'],
                            'likes' => $current_theme['likes']
                        ]) }} <i class="bi bi-heart-fill"></i>
                    </a>
                </li>
                <li class="flex-grow-1">
                    <a href="https://discord.gg/Gh2yBxUWvV" target="_blank"
                       class="w-100 btn bg-primary bg-opacity-10 text-primary-emphasis border border-primary border-opacity-25">
                        Discord <i class="bi bi-discord"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="d-flex align-items-center gap-2 my-3">
    <ul class="list-unstyled d-flex gap-2 flex-wrap mb-0">
        <li>
            <a href="{{ route('admin.images.create') }}" target="_blank"
               class="btn btn-secondary fw-bold rounded-4 text-uppercase px-3">
                <i class="bi bi-link me-1"></i>{{ trans('theme::admin.upload_image') }}
            </a>
        </li>
        <li>
            <a href="{{ route('admin.social-links.index') }}" target="_blank"
               class="btn btn-secondary fw-bold rounded-4 text-uppercase px-3">
                <i class="bi bi-link me-1"></i>{{ trans('theme::admin.add_social') }}
            </a>
        </li>
        <li>
            <a href="https://icons.getbootstrap.com/" target="_blank"
               class="btn btn-secondary fw-bold rounded-4 text-uppercase px-3">
                <i class="bi bi-bootstrap-fill me-1"></i>{{ trans('theme::admin.icones_bootstrap') }}
            </a>
        </li>
    </ul>
</div>
