@extends('admin.layouts.admin')

@section('title', trans('theme::admin.title'))

@php
    $azuriomImages = \Azuriom\Models\Image::all();

    $heroImage = old('home.hero.image', config('theme.home.hero.image'));
    $avatarImage = old('home.testimonial.avatar', config('theme.home.testimonial.avatar'));

    $heroPreview = null;
    if (! empty($heroImage)) {
        $heroPreview = filter_var($heroImage, FILTER_VALIDATE_URL) ? $heroImage : image_url($heroImage);
    }

    $avatarPreview = null;
    if (! empty($avatarImage)) {
        $avatarPreview = filter_var($avatarImage, FILTER_VALIDATE_URL) ? $avatarImage : image_url($avatarImage);
    }

    $serverLauncher = old('settings.server.launcher', config('theme.settings.server.launcher', false));
    $heroEnabled = old('home.hero.enabled', config('theme.home.hero.enabled', true));
    $trailerEnabled = old('home.trailer.enabled', config('theme.home.trailer.enabled', true));
    $featuresEnabled = old('home.features.enabled', config('theme.home.features.enabled', true));
    $testimonialEnabled = old('home.testimonial.enabled', config('theme.home.testimonial.enabled', true));
    $serversEnabled = old('home.servers.enabled', config('theme.home.servers.enabled', true));
    $blogEnabled = old('home.blog.enabled', config('theme.home.blog.enabled', true));

    $navigationLinks = old('footer.navigation.links', config('theme.footer.navigation.links', []));
    if (! is_array($navigationLinks)) {
        $navigationLinks = [];
    }
    $navigationLinks = array_values($navigationLinks);

    $contactLinks = old('footer.contact.links', config('theme.footer.contact.links', []));
    if (! is_array($contactLinks)) {
        $contactLinks = [];
    }
    $contactLinks = array_values($contactLinks);

    $siteName = site_name();

    $defaultFeatureItems = [
        ['icon' => 'bi-shield-check', 'title' => trans('theme::theme.home.features.items.first.title'), 'text' => trans('theme::theme.home.features.items.first.text')],
        ['icon' => 'bi-people', 'title' => trans('theme::theme.home.features.items.second.title'), 'text' => trans('theme::theme.home.features.items.second.text')],
        ['icon' => 'bi-gem', 'title' => trans('theme::theme.home.features.items.third.title'), 'text' => trans('theme::theme.home.features.items.third.text')],
        ['icon' => 'bi-lightning-charge', 'title' => trans('theme::theme.home.features.items.fourth.title'), 'text' => trans('theme::theme.home.features.items.fourth.text')],
    ];
@endphp

@section('content')
    <div class="col-12 mb-3 d-flex flex-column gap-2">
        <ul class="list-unstyled d-flex flex-wrap gap-2">
            <li>
                <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" class="btn btn-primary fw-bold rounded-4 text-uppercase px-3"><i class="bi bi-discord me-1"></i>{{trans('theme::admin.discord_support')}}</a>
            </li>
            <li>
                <a href="https://www.serveurliste.com" target="_blank" class="btn btn-warning fw-bold rounded-4 text-uppercase px-3"><i class="bi bi-search-heart-fill me-1"></i>{{trans('theme::admin.list_your_server_on_serveurliste')}}</a>
            </li>
        </ul>
        <hr>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.themes.config', $theme) }}" method="POST">
                @csrf

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h4 class="mb-3">{{ trans('theme::admin.sections.activation') }}</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input type="hidden" name="home[hero][enabled]" value="0">
                        <div class="form-check form-switch">
                            <input id="homeHeroEnabled" class="form-check-input" type="checkbox" name="home[hero][enabled]" value="1" @checked($heroEnabled)>
                            <label class="form-check-label" for="homeHeroEnabled">{{ trans('theme::admin.activation.hero') }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" name="home[trailer][enabled]" value="0">
                        <div class="form-check form-switch">
                            <input id="homeTrailerEnabled" class="form-check-input" type="checkbox" name="home[trailer][enabled]" value="1" @checked($trailerEnabled)>
                            <label class="form-check-label" for="homeTrailerEnabled">{{ trans('theme::admin.activation.trailer') }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" name="home[features][enabled]" value="0">
                        <div class="form-check form-switch">
                            <input id="homeFeaturesEnabled" class="form-check-input" type="checkbox" name="home[features][enabled]" value="1" @checked($featuresEnabled)>
                            <label class="form-check-label" for="homeFeaturesEnabled">{{ trans('theme::admin.activation.features') }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" name="home[testimonial][enabled]" value="0">
                        <div class="form-check form-switch">
                            <input id="homeTestimonialEnabled" class="form-check-input" type="checkbox" name="home[testimonial][enabled]" value="1" @checked($testimonialEnabled)>
                            <label class="form-check-label" for="homeTestimonialEnabled">{{ trans('theme::admin.activation.testimonial') }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" name="home[blog][enabled]" value="0">
                        <div class="form-check form-switch">
                            <input id="homeBlogEnabled" class="form-check-input" type="checkbox" name="home[blog][enabled]" value="1" @checked($blogEnabled)>
                            <label class="form-check-label" for="homeBlogEnabled">{{ trans('theme::admin.activation.blog') }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" name="home[servers][enabled]" value="0">
                        <div class="form-check form-switch">
                            <input id="homeServersEnabled" class="form-check-input" type="checkbox" name="home[servers][enabled]" value="1" @checked($serversEnabled)>
                            <label class="form-check-label" for="homeServersEnabled">{{ trans('theme::admin.activation.servers') }}</label>
                        </div>
                    </div>
                </div>

                <h4 class="mb-3">{{ trans('theme::admin.sections.server') }}</h4>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <input type="hidden" name="settings[server][launcher]" value="0">
                        <div class="form-check form-switch">
                            <input id="settingsServerLauncher" class="form-check-input" type="checkbox" name="settings[server][launcher]" value="1" @checked($serverLauncher)>
                            <label class="form-check-label" for="settingsServerLauncher">{{ trans('theme::admin.server.launcher_enabled') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="settingsServerUrl">{{ trans('theme::admin.server.launcher_url') }}</label>
                        <input id="settingsServerUrl" class="form-control" type="text" name="settings[server][url]"
                               value="{{ old('settings.server.url', config('theme.settings.server.url')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="settingsServerText">{{ trans('theme::admin.server.launcher_button_text') }}</label>
                        <input id="settingsServerText" class="form-control" type="text" name="settings[server][text]"
                               value="{{ old('settings.server.text', config('theme.settings.server.text') ?? trans('theme::theme.home.server.launcher_button_default')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="settingsServerIp">{{ trans('theme::admin.server.ip_to_copy') }}</label>
                        <input id="settingsServerIp" class="form-control" type="text" name="settings[server][ip]"
                               value="{{ old('settings.server.ip', config('theme.settings.server.ip')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="settingsServerCopiedText">{{ trans('theme::admin.server.copied_tooltip_text') }}</label>
                        <input id="settingsServerCopiedText" class="form-control" type="text" name="settings[server][copied_text]"
                               value="{{ old('settings.server.copied_text', config('theme.settings.server.copied_text') ?? trans('theme::theme.home.server.copied_text_default')) }}">
                    </div>
                </div>

                <h4 class="mb-3">{{ trans('theme::admin.sections.hero') }}</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label" for="homeHeroTitle">{{ trans('theme::admin.hero.title') }}</label>
                        <input id="homeHeroTitle" class="form-control" type="text" name="home[hero][title]"
                               value="{{ old('home.hero.title', config('theme.home.hero.title') ?? trans('theme::theme.home.hero.title_default', ['site' => $siteName])) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="homeHeroImage">{{ trans('theme::admin.hero.image') }}</label>
                        <div class="input-group">
                            <a class="input-group-text text-success" href="{{ route('admin.images.create') }}" target="_blank" rel="noopener noreferrer" title="{{ trans('theme::admin.common.upload_image') }}">
                                <i class="bi bi-upload"></i>
                            </a>
                            <select id="homeHeroImage" class="form-select" name="home[hero][image]">
                                <option value="">{{ trans('theme::admin.common.none') }}</option>
                                @if(!empty($heroImage) && $azuriomImages->where('file', $heroImage)->isEmpty())
                                    <option value="{{ $heroImage }}" selected>{{ $heroImage }}</option>
                                @endif
                                @foreach($azuriomImages as $image)
                                    <option value="{{ $image->file }}" @selected($heroImage === $image->file)>{{ $image->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-2">
                            <img id="homeHeroPreview" src="{{ $heroPreview ?? '' }}" alt="{{ trans('theme::admin.common.hero_preview') }}" class="img-fluid rounded border" style="max-height: 220px; object-fit: cover; {{ $heroPreview ? '' : 'display: none;' }}">
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="homeHeroSubtitle">{{ trans('theme::admin.hero.description') }}</label>
                        <textarea id="homeHeroSubtitle" class="form-control" rows="3"
                                  name="home[hero][subtitle]">{{ old('home.hero.subtitle', config('theme.home.hero.subtitle') ?? trans('theme::theme.home.hero.subtitle_default')) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="homeHeroPrimaryText">{{ trans('theme::admin.hero.primary_button_text') }}</label>
                        <input id="homeHeroPrimaryText" class="form-control" type="text" name="home[hero][primary_button_text]"
                               value="{{ old('home.hero.primary_button_text', config('theme.home.hero.primary_button_text') ?? trans('theme::theme.home.hero.primary_button_default')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="homeHeroPrimaryUrl">{{ trans('theme::admin.hero.primary_button_url') }}</label>
                        <input id="homeHeroPrimaryUrl" class="form-control" type="text" name="home[hero][primary_button_url]"
                               value="{{ old('home.hero.primary_button_url', config('theme.home.hero.primary_button_url')) }}">
                    </div>
                </div>

                <h4 class="mb-3">{{ trans('theme::admin.sections.trailer') }}</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label" for="homeTrailerTitle">{{ trans('theme::admin.trailer.title') }}</label>
                        <input id="homeTrailerTitle" class="form-control" type="text" name="home[trailer][title]"
                               value="{{ old('home.trailer.title', config('theme.home.trailer.title') ?? trans('theme::theme.home.trailer.title_default')) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="homeTrailerSubtitle">{{ trans('theme::admin.trailer.description') }}</label>
                        <textarea id="homeTrailerSubtitle" class="form-control" rows="3"
                                  name="home[trailer][subtitle]">{{ old('home.trailer.subtitle', config('theme.home.trailer.subtitle') ?? trans('theme::theme.home.trailer.subtitle_default')) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="homeTrailerVideoUrl">{{ trans('theme::admin.trailer.video_url') }}</label>
                        <input id="homeTrailerVideoUrl" class="form-control" type="text" name="home[trailer][video_url]" placeholder="https://www.youtube.com/embed/lHngf-CKCzk"
                               value="{{ old('home.trailer.video_url', config('theme.home.trailer.video_url')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="homeTrailerButtonText">{{ trans('theme::admin.trailer.button_text') }}</label>
                        <input id="homeTrailerButtonText" class="form-control" type="text" name="home[trailer][button_text]"
                               value="{{ old('home.trailer.button_text', config('theme.home.trailer.button_text') ?? trans('theme::theme.home.trailer.button_text_default')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="homeTrailerButtonUrl">{{ trans('theme::admin.trailer.button_url') }}</label>
                        <input id="homeTrailerButtonUrl" class="form-control" type="text" name="home[trailer][button_url]"
                               value="{{ old('home.trailer.button_url', config('theme.home.trailer.button_url')) }}">
                    </div>
                </div>

                <h4 class="mb-3">{{ trans('theme::admin.sections.features') }}</h4>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label" for="homeFeaturesTitle">{{ trans('theme::admin.features.main_title') }}</label>
                        <input id="homeFeaturesTitle" class="form-control" type="text" name="home[features][title]"
                               value="{{ old('home.features.title', config('theme.home.features.title') ?? trans('theme::theme.home.features.title_default')) }}">
                    </div>

                    @for($i = 0; $i < 4; $i++)
                        <div class="col-12">
                            <div class="border rounded p-3">
                                <h6 class="mb-3">{{ trans('theme::admin.features.block', ['number' => $i + 1]) }}</h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="homeFeatureIcon{{ $i }}">{{ trans('theme::admin.features.icon') }}</label>
                                        <input id="homeFeatureIcon{{ $i }}" class="form-control" type="text"
                                               name="home[features][items][{{ $i }}][icon]"
                                               value="{{ old("home.features.items.$i.icon", data_get(config('theme.home.features.items'), "$i.icon", data_get($defaultFeatureItems, "$i.icon"))) }}">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label" for="homeFeatureTitle{{ $i }}">{{ trans('theme::admin.features.title') }}</label>
                                        <input id="homeFeatureTitle{{ $i }}" class="form-control" type="text"
                                               name="home[features][items][{{ $i }}][title]"
                                               value="{{ old("home.features.items.$i.title", data_get(config('theme.home.features.items'), "$i.title", data_get($defaultFeatureItems, "$i.title"))) }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="homeFeatureText{{ $i }}">{{ trans('theme::admin.features.text') }}</label>
                                        <textarea id="homeFeatureText{{ $i }}" class="form-control" rows="2"
                                                  name="home[features][items][{{ $i }}][text]">{{ old("home.features.items.$i.text", data_get(config('theme.home.features.items'), "$i.text", data_get($defaultFeatureItems, "$i.text"))) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <h4 class="mb-3">{{ trans('theme::admin.sections.testimonial') }}</h4>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label" for="homeTestimonialQuote">{{ trans('theme::admin.testimonial.quote') }}</label>
                        <textarea id="homeTestimonialQuote" class="form-control" rows="3"
                                  name="home[testimonial][quote]">{{ old('home.testimonial.quote', config('theme.home.testimonial.quote') ?? trans('theme::theme.home.testimonial.quote_default')) }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="homeTestimonialAuthor">{{ trans('theme::admin.testimonial.name') }}</label>
                        <input id="homeTestimonialAuthor" class="form-control" type="text" name="home[testimonial][author]"
                               value="{{ old('home.testimonial.author', config('theme.home.testimonial.author') ?? trans('theme::theme.home.testimonial.author_default')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="homeTestimonialRole">{{ trans('theme::admin.testimonial.role') }}</label>
                        <input id="homeTestimonialRole" class="form-control" type="text" name="home[testimonial][role]"
                               value="{{ old('home.testimonial.role', config('theme.home.testimonial.role') ?? trans('theme::theme.home.testimonial.role_default')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="homeTestimonialAvatar">{{ trans('theme::admin.testimonial.avatar') }}</label>
                        <div class="input-group">
                            <a class="input-group-text text-success" href="{{ route('admin.images.create') }}" target="_blank" rel="noopener noreferrer" title="{{ trans('theme::admin.common.upload_image') }}">
                                <i class="bi bi-upload"></i>
                            </a>
                            <select id="homeTestimonialAvatar" class="form-select" name="home[testimonial][avatar]">
                                <option value="">{{ trans('theme::admin.common.none') }}</option>
                                @if(!empty($avatarImage) && $azuriomImages->where('file', $avatarImage)->isEmpty())
                                    <option value="{{ $avatarImage }}" selected>{{ $avatarImage }}</option>
                                @endif
                                @foreach($azuriomImages as $image)
                                    <option value="{{ $image->file }}" @selected($avatarImage === $image->file)>{{ $image->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-2">
                            <img id="homeAvatarPreview" src="{{ $avatarPreview ?? '' }}" alt="{{ trans('theme::admin.common.avatar_preview') }}" class="rounded-circle border" style="width: 64px; height: 64px; object-fit: cover; {{ $avatarPreview ? '' : 'display: none;' }}">
                        </div>
                    </div>
                </div>

                <h4 class="mb-3">{{ trans('theme::admin.sections.blog') }}</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label" for="homeBlogTitle">{{ trans('theme::admin.blog.title') }}</label>
                        <input id="homeBlogTitle" class="form-control" type="text" name="home[blog][title]"
                               value="{{ old('home.blog.title', config('theme.home.blog.title') ?? trans('theme::theme.home.blog.title_default')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="homeBlogSubtitle">{{ trans('theme::admin.blog.subtitle') }}</label>
                        <input id="homeBlogSubtitle" class="form-control" type="text" name="home[blog][subtitle]"
                               value="{{ old('home.blog.subtitle', config('theme.home.blog.subtitle') ?? trans('theme::theme.home.blog.subtitle_default')) }}">
                    </div>
                </div>

                <h4 class="mb-3">{{ trans('theme::admin.sections.footer') }}</h4>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label" for="footerMainTitle">{{ trans('theme::admin.footer.main_title') }}</label>
                        <input id="footerMainTitle" class="form-control" type="text" name="footer[main][title]"
                               value="{{ old('footer.main.title', config('theme.footer.main.title') ?? trans('theme::theme.footer.main_title_default', ['site' => $siteName])) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="footerMainText">{{ trans('theme::admin.footer.main_text') }}</label>
                        <textarea id="footerMainText" class="form-control" rows="3" name="footer[main][text]">{{ old('footer.main.text', config('theme.footer.main.text') ?? trans('theme::theme.footer.main_text_default', ['site' => $siteName])) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="footerNavigationTitle">{{ trans('theme::admin.footer.navigation_title') }}</label>
                        <input id="footerNavigationTitle" class="form-control" type="text" name="footer[navigation][title]"
                               value="{{ old('footer.navigation.title', config('theme.footer.navigation.title') ?? trans('theme::theme.footer.navigation_title_default')) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="footerContactTitle">{{ trans('theme::admin.footer.contact_title') }}</label>
                        <input id="footerContactTitle" class="form-control" type="text" name="footer[contact][title]"
                               value="{{ old('footer.contact.title', config('theme.footer.contact.title') ?? trans('theme::theme.footer.contact_title_default')) }}">
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-lg-6">
                        <div class="border rounded p-3 h-100">
                            <h6>{{ trans('theme::admin.footer.navigation_links') }}</h6>
                            @for($i = 0; $i < 4; $i++)
                                <div class="border rounded p-2 mb-2">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <small class="text-muted">{{ trans('theme::admin.common.link', ['number' => $i + 1]) }}</small>
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="footer[navigation][links][{{ $i }}][icon]"
                                                   placeholder="{{ trans('theme::admin.placeholders.navigation_icon') }}"
                                                   value="{{ old("footer.navigation.links.$i.icon", data_get($navigationLinks, "$i.icon")) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="footer[navigation][links][{{ $i }}][name]"
                                                   placeholder="{{ trans('theme::admin.placeholders.name') }}"
                                                   value="{{ old("footer.navigation.links.$i.name", data_get($navigationLinks, "$i.name")) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="footer[navigation][links][{{ $i }}][url]"
                                                   placeholder="{{ trans('theme::admin.placeholders.navigation_url') }}"
                                                   value="{{ old("footer.navigation.links.$i.url", data_get($navigationLinks, "$i.url")) }}">
                                        </div>
                                        <div class="col-12">
                                            <input type="hidden" name="footer[navigation][links][{{ $i }}][new_tab]" value="0">
                                            <div class="form-check">
                                                <input id="footerNavNewTab{{ $i }}" class="form-check-input" type="checkbox" name="footer[navigation][links][{{ $i }}][new_tab]" value="1" @checked(old("footer.navigation.links.$i.new_tab", data_get($navigationLinks, "$i.new_tab", false)))>
                                                <label class="form-check-label" for="footerNavNewTab{{ $i }}">{{ trans('theme::admin.common.open_new_tab') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="border rounded p-3 h-100">
                            <h6>{{ trans('theme::admin.footer.contact_links') }}</h6>
                            @for($i = 0; $i < 4; $i++)
                                <div class="border rounded p-2 mb-2">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <small class="text-muted">{{ trans('theme::admin.common.link', ['number' => $i + 1]) }}</small>
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="footer[contact][links][{{ $i }}][icon]"
                                                   placeholder="{{ trans('theme::admin.placeholders.contact_icon') }}"
                                                   value="{{ old("footer.contact.links.$i.icon", data_get($contactLinks, "$i.icon")) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="footer[contact][links][{{ $i }}][name]"
                                                   placeholder="{{ trans('theme::admin.placeholders.name') }}"
                                                   value="{{ old("footer.contact.links.$i.name", data_get($contactLinks, "$i.name")) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control" type="text" name="footer[contact][links][{{ $i }}][url]"
                                                   placeholder="{{ trans('theme::admin.placeholders.contact_url') }}"
                                                   value="{{ old("footer.contact.links.$i.url", data_get($contactLinks, "$i.url")) }}">
                                        </div>
                                        <div class="col-12">
                                            <input type="hidden" name="footer[contact][links][{{ $i }}][new_tab]" value="0">
                                            <div class="form-check">
                                                <input id="footerContactNewTab{{ $i }}" class="form-check-input" type="checkbox" name="footer[contact][links][{{ $i }}][new_tab]" value="1" @checked(old("footer.contact.links.$i.new_tab", data_get($contactLinks, "$i.new_tab", false)))>
                                                <label class="form-check-label" for="footerContactNewTab{{ $i }}">{{ trans('theme::admin.common.open_new_tab') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <h4 class="mb-3">{{ trans('theme::admin.sections.colors') }}</h4>
                <div class="row g-3 mb-4">
                    <div class="col-12 col-lg-6">
                        <div class="border rounded p-3 h-100">
                            <h6 class="mb-3">{{ trans('theme::admin.colors.light_mode') }}</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    @include('admin.components.forms.color', ['name' => trans('theme::admin.colors.primary'), 'id' => 'style[colors][light][primary]', 'value' => '#0d6efd'])
                                </div>
                                <div class="col-md-4">
                                    @include('admin.components.forms.color', ['name' => trans('theme::admin.colors.body_color'), 'id' => 'style[colors][light][body_color]', 'value' => '#212529'])
                                </div>
                                <div class="col-md-4">
                                    @include('admin.components.forms.color', ['name' => trans('theme::admin.colors.dark_color'), 'id' => 'style[colors][light][dark]', 'value' => '#212529'])
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="border rounded p-3 h-100">
                            <h6 class="mb-3">{{ trans('theme::admin.colors.dark_mode') }}</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    @include('admin.components.forms.color', ['name' => trans('theme::admin.colors.primary'), 'id' => 'style[colors][dark][primary]', 'value' => '#4dabf7'])
                                </div>
                                <div class="col-md-4">
                                    @include('admin.components.forms.color', ['name' => trans('theme::admin.colors.body_color'), 'id' => 'style[colors][dark][body_color]', 'value' => '#f8f9fa'])
                                </div>
                                <div class="col-md-4">
                                    @include('admin.components.forms.color', ['name' => trans('theme::admin.colors.dark_color'), 'id' => 'style[colors][dark][dark]', 'value' => '#0f1115'])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-success" type="submit">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection

@push('footer-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageBase = '{{ image_url() }}';

            function resolveImageUrl(value) {
                if (!value) {
                    return '';
                }

                if (value.startsWith('http://') || value.startsWith('https://')) {
                    return value;
                }

                return imageBase.replace(/\/$/, '') + '/' + value;
            }

            function bindPreview(selectId, previewId) {
                const select = document.getElementById(selectId);
                const preview = document.getElementById(previewId);

                if (!select || !preview) {
                    return;
                }

                const update = () => {
                    const src = resolveImageUrl(select.value);

                    if (!src) {
                        preview.style.display = 'none';
                        preview.setAttribute('src', '');
                        return;
                    }

                    preview.setAttribute('src', src);
                    preview.style.display = '';
                };

                select.addEventListener('change', update);
                update();
            }

            bindPreview('homeHeroImage', 'homeHeroPreview');
            bindPreview('homeTestimonialAvatar', 'homeAvatarPreview');
        });
    </script>
@endpush
