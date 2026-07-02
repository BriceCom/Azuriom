@php
    $changelogs = Azuriom\Plugin\Changelog\Models\Update::all()->sortByDesc('created_at');
@endphp

@if(! $changelogs->isEmpty())
    <div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4.5">
            <hgroup>
                <h2 class="fw-bold mb-0">{{ theme_config('home.changelog.title') ?? trans('changelog::admin.title') }}</h2>
                @if(theme_config('home.changelog.text'))
                    <p class="mb-0 opacity-75">{{ theme_config('home.changelog.text') }}</p>
                @endif
            </hgroup>
            <a href="{{route('changelog.index')}}"
               class="btn btn-primary">{{ theme_config('home.changelog.link.name') ?? trans('theme::theme.consult_all_changelog') }}</a>
        </div>

        <div class="row gx-4 gy-4">
            @foreach($changelogs->take(4) as $post)
                <div class="col-md-6">
                    <a class="h-100 post d-flex flex-column flex-md-row gap-3 overflow-hidden text-decoration-none"
                       href="{{ route('changelog.categories.show', $post->category_id  ) }}">
                        <div class="position-relative col-md-4 position-relative post-img rounded-4">
                            <i class="position-absolute top-50 start-50 translate-middle bi bi-card-checklist fs-2"></i>
                            <img
                                src="{{ setting('background') ? image_url(setting('background')) : "https://placehold.co/800x500" }}"
                                class="w-100 h-100 object-fit-cover opacity-25" alt="" height="125" width="200">
                        </div>
                        <div class="h-100 col d-flex flex-column post-content text-white">
                            <div class="d-flex align-items-center gap-2">
                                            <span class="badge text-bg-quaternary text-quaternary border"
                                                  style="--di-badge-color: var(--di-quaternary)">
                                                {{ $post->category->name }}
                                            </span>

                                <small class="opacity-50">{{format_date($post->created_at)}}</small>
                            </div>
                            <h3 class="fw-bold text-lg mt-3 mb-2 text-uppercase">{{ $post->name }}</h3>
                            <p class="mb-0 text-muted text-sm">{{ Str::limit(strip_tags($post->description    ), 50) }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
