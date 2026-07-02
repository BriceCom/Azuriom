<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.server')}}</legend>
    <div class="d-flex flex-column gap-1">
        <div>
            <div class="form-check p-0">
                <div class="switcher">
                    <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>
                    <label for="hero-server-toggle">
                        <input type="checkbox" id="hero-server-toggle" name="hero[server][toggle]"
                               @if(config('theme.hero.server.toggle')) checked
                               @endif @error('hero-server-toggle') is-invalid @enderror/>
                        <span><small></small></span>
                    </label>
                </div>
                @error('hero-server-toggle')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </div>
        <div>
            <div class="form-check p-0">
                <div class="switcher">
                    <small
                        class="fw-bold fs-5">{{trans('theme::admin.dont_show')}} {{trans('theme::admin.title')}}</small>
                    <label for="hero-title-toggle">
                        <input type="checkbox" id="hero-title-toggle" name="hero[title][toggle]"
                               @if(config('theme.hero.title.toggle')) checked
                               @endif @error('hero-title-toggle') is-invalid @enderror/>
                        <span><small></small></span>
                    </label>
                </div>
                @error('hero-title-toggle')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="">
                <label class="form-label m-0" for="hero-text-title">{{trans('theme::admin.title')}}</label>
                <input type="text" class="form-control @error('hero-text-title') is-invalid @enderror"
                       id="hero-text-title" name="hero[text][title]"
                       value="{{old('hero-text-title', config('theme.hero.text.title'))}}"
                       aria-describedby="hero-text-title-Label">
                @error('hero-text-title')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100 my-4">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.image')}}</legend>
                <div class="d-flex gap-4">
                    <div class="form-group">
                        <label for="home-hero-image-url" class="form-label fw-bold m-0">{{trans('theme::admin.image')}}</label>
                        <div class="d-flex align-center">
                            <a class=" input-group-text text-success" href="{{ route('admin.images.create') }}"
                               title="Upload a image" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-upload"></i>
                            </a>
                            <select class="form-select"
                                    id="home-hero-image-url"
                                    name="home[hero][image][url]"
                                    data-image-preview-select="filePreview-slider-home-hero-image-url"
                                    onchange="showPreview('home-hero-image-url');">
                                <option value="">none</option>
                                @foreach($azuriomImages as $image)
                                    <option value="{{ $image->file }}"
                                            @if(config('theme.home.hero.image.url') == $image->file) selected @endif>{{ $image->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3 w-100"
                             style="height: 100px; {{config('theme.home.hero.image.url') ?? 'display: none'}}">
                            <img id="img-preview-home-hero-image-url" style="object-fit: contain;" class="w-100 h-100"
                                 src="{{config('theme.home.hero.image.url') ? image_url(old('home-hero-image-url', config('theme.home.hero.image.url'))):''}}"
                                 alt="">
                        </div>
                        @error('home-hero-image-url')
                        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                        @enderror
                    </div>
                    <div class="d-flex flex-column flex-md-row gap-4">
                        <div class="w-50">
                            <label class="form-label m-0"
                                   for="home-hero-image-alt">{{trans('theme::admin.description_of_image')}}</label>
                            <input type="text" class="form-control @error('home-hero-image-alt') is-invalid @enderror"
                                   alt="home-hero-image-alt" name="home[hero][image][alt]"
                                   value="{{old('home-hero-image-alt', config('theme.home.hero.image.alt'))}}"
                                   aria-describedby="home-hero-image-alt-Label">
                            @error('home-hero-image-alt')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-4">
                    <div class="w-50">
                        <div class="form-group">
                            <label for="home-hero-image-height"
                                   class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.height')}}</label>
                            <div class="d-flex align-center gap-2">
                                <output>{{ old('home-hero-image-height', config('theme.home.hero.image.height')) ?? '200' }}</output>
                                <input id="home-hero-image-height" name="home[hero][image][height]" type="range" min="1"
                                       max="1200" step="1"
                                       class="form-range @error('home-hero-image-height') is-invalid @enderror"
                                       value="{{ old('home-hero-image-height', config('theme.home.hero.image.height')) ?? '200' }}"
                                       aria-describedby="home-hero-image-height"
                                       oninput="this.previousElementSibling.value = this.value">
                            </div>
                            @error('home-hero-image-height')
                            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                            @enderror
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100 my-4">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Logo</legend>
                <div class="d-flex gap-4">
                    <div class="form-group">
                        <label for="home-hero-logo-url" class="form-label fw-bold m-0">Logo</label>
                        <div class="d-flex align-center">
                            <a class=" input-group-text text-success" href="{{ route('admin.images.create') }}"
                               title="Upload a image" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-upload"></i>
                            </a>
                            <select class="form-select"
                                    id="home-hero-logo-url"
                                    name="home[hero][logo][url]"
                                    data-image-preview-select="filePreview-slider-home-hero-logo-url"
                                    onchange="showPreview('home-hero-logo-url');">
                                <option value="">none</option>
                                @foreach($azuriomImages as $image)
                                    <option value="{{ $image->file }}"
                                            @if(config('theme.home.hero.logo.url') == $image->file) selected @endif>{{ $image->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3 w-100"
                             style="height: 100px; {{config('theme.home.hero.logo.url') ?? 'display: none'}}">
                            <img id="img-preview-home-hero-logo-url" style="object-fit: contain;" class="w-100 h-100"
                                 src="{{config('theme.home.hero.logo.url') ? image_url(old('home-hero-logo-url', config('theme.home.hero.logo.url'))):''}}"
                                 alt="">
                        </div>
                        @error('home-hero-logo-url')
                        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                        @enderror
                    </div>
                    <div class="d-flex flex-column flex-md-row gap-4">
                        <div class="w-50">
                            <label class="form-label m-0"
                                   for="home-hero-logo-alt">{{trans('theme::admin.description_of_image')}}</label>
                            <input type="text" class="form-control @error('home-hero-image-alt') is-invalid @enderror"
                                   alt="home-hero-logo-alt" name="home[hero][logo][alt]"
                                   value="{{old('home-hero-logo-alt', config('theme.home.hero.logo.alt'))}}"
                                   aria-describedby="home-hero-logo-alt-Label">
                            @error('home-hero-logo-alt')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-4">
                    <div class="w-50">
                        <div class="form-group">
                            <label for="home-hero-logo-height"
                                   class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.height')}}</label>
                            <div class="d-flex align-center gap-2">
                                <output>{{ old('home-hero-logo-height', config('theme.home.hero.logo.height')) ?? '200' }}</output>
                                <input id="home-hero-logo-height" name="home[hero][logo][height]" type="range" min="1"
                                       max="800" step="1"
                                       class="form-range @error('home-hero-logo-height') is-invalid @enderror"
                                       value="{{ old('home-hero-logo-height', config('theme.home.hero.logo.height')) ?? '200' }}"
                                       aria-describedby="home-hero-logo-height"
                                       oninput="this.previousElementSibling.value = this.value">
                            </div>
                            @error('home-hero-logo-height')
                            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                            @enderror
                        </div>
                    </div>
                    <div class="w-50">
                        <div class="form-group">
                            <label for="home-hero-logo-width"
                                   class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.width')}}</label>
                            <div class="d-flex align-center gap-2">
                                <output>{{ old('home-hero-logo-width', config('theme.home.hero.logo.width')) ?? '200' }}</output>
                                <input id="home-hero-logo-width" name="home[hero][logo][width]" type="range" min="1"
                                       max="800" step="1"
                                       class="form-range @error('home-hero-logo-width') is-invalid @enderror"
                                       value="{{ old('home-hero-log  o-width', config('theme.home.hero.logo.width')) ?? '200' }}"
                                       aria-describedby="home-hero-logo-width"
                                       oninput="this.previousElementSibling.value = this.value">
                            </div>
                            @error('home-hero-logo-width')
                            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                            @enderror
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="">
                <label class="form-label m-0" for="hero-text-text">{{trans('theme::admin.text')}}</label>
                <input type="text" class="form-control @error('hero-text-text') is-invalid @enderror"
                       id="hero-text-text" name="hero[text][text]"
                       value="{{old('hero-text-text', config('theme.hero.text.text'))}}"
                       aria-describedby="hero-text-text-Label">
                @error('hero-text-text')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend
                class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.button')}}</legend>
            <div class="d-flex flex-wrap gap-1">
                <div class="">
                    <label class="form-label m-0" for="hero-server-icon">{{trans('theme::admin.icon')}}</label>
                    <input type="icon" placeholder="bi bi-box-fill"
                           class="form-control @error('hero-server-icon') is-invalid @enderror" id="hero-server-icon"
                           name="hero[server][icon]"
                           value="{{old('hero-server-icon', config('theme.hero.server.icon'))}}"
                           aria-describedby="hero-server-icon-Label">
                    @error('hero-server-icon')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="">
                    <label class="form-label m-0" for="hero-server-text">{{trans('theme::admin.text')}}</label>
                    <input type="text" class="form-control @error('hero-server-text') is-invalid @enderror"
                           id="hero-server-text" name="hero[server][text]"
                           value="{{old('hero-server-text', config('theme.hero.server.text'))}}"
                           aria-describedby="hero-server-text-Label">
                    @error('hero-server-text')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                {{--            <div class="">--}}
                {{--                <label class="form-label m-0" for="hero-server-subtext">{{trans('theme::admin.subtext')}}</label>--}}
                {{--                <input type="text" class="form-control @error('hero-server-subtext') is-invalid @enderror" id="hero-server-subtext" name="hero[server][subtext]" value="{{old('hero-server-subtext', config('theme.hero.server.subtext'))}}" aria-describedby="hero-server-subtext-Label">--}}
                {{--                @error('hero-server-subtext')--}}
                {{--                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
                {{--                @enderror--}}
                {{--            </div>--}}
                <div class="">
                    <label class="form-label m-0" for="hero-server-ip">IP</label>
                    <input type="text" class="form-control @error('hero-server-ip') is-invalid @enderror"
                           id="hero-server-ip" name="hero[server][ip]"
                           value="{{old('hero-server-ip', config('theme.hero.server.ip'))}}"
                           aria-describedby="hero-server-ip-Label">
                    @error('hero-server-ip')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="">
                    <label class="form-label m-0"
                           for="hero-server-textcopied">{{trans('theme::admin.ip_when_copied')}}</label>
                    <input type="text" class="form-control @error('hero-server-textcopied') is-invalid @enderror"
                           id="hero-server-textcopied" name="hero[server][textcopied]"
                           value="{{old('hero-server-textcopied', config('theme.hero.server.textcopied'))}}"
                           aria-describedby="hero-server-textcopied-Label">
                    @error('hero-server-textcopied')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div>
                <i>{{trans('theme::admin.online_variable')}}</i>
            </div>
        </fieldset>
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.button')}}URL
            </legend>
            <div class="d-flex flex-wrap gap-1">
                <div class="">
                    <label class="form-label m-0" for="hero-url-icon">{{trans('theme::admin.icon')}}</label>
                    <input type="icon" placeholder="bi bi-box-fill"
                           class="form-control @error('hero-url-icon') is-invalid @enderror" id="hero-url-icon"
                           name="hero[url][icon]" value="{{old('hero-url-icon', config('theme.hero.url.icon'))}}"
                           aria-describedby="hero-url-icon-Label">
                    @error('hero-url-icon')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="">
                    <label class="form-label m-0" for="hero-url-text">{{trans('theme::admin.text')}}</label>
                    <input type="text" class="form-control @error('hero-url-text') is-invalid @enderror"
                           id="hero-url-text" name="hero[url][text]"
                           value="{{old('hero-url-text', config('theme.hero.url.text'))}}"
                           aria-describedby="hero-url-text-Label">
                    @error('hero-url-text')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="">
                    <label class="form-label m-0" for="hero-url-link">Url</label>
                    <input type="text" class="form-control @error('hero-url-link') is-invalid @enderror"
                           id="hero-url-link" name="hero[url][link]"
                           value="{{old('hero-url-link', config('theme.hero.url.link'))}}"
                           aria-describedby="hero-url-link-Label">
                    @error('hero-url-link')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
        </fieldset>
    </div>
</fieldset>

{{--<fieldset class="d-flex flex-column gap-3 border p-2 w-100">--}}
{{--    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.discord')}}</legend>--}}
{{--    <div class="d-flex flex-column gap-1">--}}
{{--        <div>--}}
{{--            <div class="form-check p-0">--}}
{{--                <div class="switcher">--}}
{{--                    <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>--}}
{{--                    <label for="hero-discord-toggle">--}}
{{--                        <input type="checkbox" id="hero-discord-toggle" name="hero[discord][toggle]" @if(config('theme.hero.discord.toggle')) checked @endif @error('hero-discord-toggle') is-invalid @enderror/>--}}
{{--                        <span><small></small></span>--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--                @error('hero-discord-toggle')--}}
{{--                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>--}}
{{--                @enderror--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="d-flex flex-wrap gap-1">--}}
{{--            <div class="">--}}
{{--                <label class="form-label m-0" for="hero-discord-icon">{{trans('theme::admin.icon')}}</label>--}}
{{--                <input type="icon" placeholder="bi bi-discord" class="form-control @error('hero-discord-icon') is-invalid @enderror" id="hero-discord-icon" name="hero[discord][icon]" value="{{old('hero-discord-icon', config('theme.hero.discord.icon'))}}" aria-describedby="hero-discord-icon-Label">--}}
{{--                @error('hero-discord-icon')--}}
{{--                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--                @enderror--}}
{{--            </div>--}}
{{--            <div class="">--}}
{{--                <label class="form-label m-0" for="hero-discord-text">{{trans('theme::admin.text')}}</label>--}}
{{--                <input type="text" class="form-control @error('hero-discord-text') is-invalid @enderror" id="hero-discord-text" name="hero[discord][text]" value="{{old('hero-discord-text', config('theme.hero.discord.text'))}}" aria-describedby="hero-discord-text-Label">--}}
{{--                @error('hero-discord-text')--}}
{{--                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--                @enderror--}}
{{--            </div>--}}
{{--            <div class="">--}}
{{--                <label class="form-label m-0" for="hero-discord-subtext">{{trans('theme::admin.subtext')}}</label>--}}
{{--                <input type="text" class="form-control @error('hero-discord-subtext') is-invalid @enderror" id="hero-discord-subtext" name="hero[discord][subtext]" value="{{old('hero-discord-subtext', config('theme.hero.discord.subtext'))}}" aria-describedby="hero-discord-subtext-Label">--}}
{{--                @error('hero-discord-subtext')--}}
{{--                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--                @enderror--}}
{{--            </div>--}}
{{--            <div class="">--}}
{{--                <label class="form-label m-0" for="hero-discord-url">{{trans('theme::admin.url')}}</label>--}}
{{--                <input type="url" class="form-control @error('hero-discord-url') is-invalid @enderror" id="hero-discord-url" name="hero[discord][url]" value="{{old('hero-discord-url', config('theme.hero.discord.url'))}}" aria-describedby="hero-discord-url-Label">--}}
{{--                @error('hero-discord-url')--}}
{{--                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--                @enderror--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <i>--}}
{{--        <a href="#getId">{{trans('theme::admin.dont_see_number_of_member_discord')}}</a>--}}
{{--    </i>--}}
{{--</fieldset>--}}
