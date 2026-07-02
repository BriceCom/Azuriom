<div class="d-flex flex-column gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100 mb-3">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.hide')}}</legend>
        <div class="form-check p-0">
            <div class="switcher">
                <small class="fw-bold fs-5">{{trans('theme::admin.disableInfosHero')}}</small>
                <label for="hero-appHide-toggle">
                    <input type="checkbox" id="hero-appHide-toggle" name="hero[appHide][toggle]" @if(config('theme.hero.appHide.toggle')) checked @endif @error('hero-appHide-toggle') is-invalid @enderror/>
                    <span><small></small></span>
                </label>
            </div>
            @error('hero-appHide-toggle')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
    </fieldset>

        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.server')}}</legend>
            <div class="form-check p-0">
                <div class="switcher">
                    <small class="fw-bold fs-5">{{ trans('theme::admin.server_with_launcher') }}</small>
                    <label for="hero-server-launcher-on">
                        <input type="checkbox" id="hero-server-launcher-on" name="hero[server][launcher][on]" @if(config('theme.hero.server.launcher.on')) checked @endif @error('hero-server-launcher-on') is-invalid @enderror/>
                        <span><small></small></span>
                    </label>
                </div>
                @error('hero-server-launcher-on')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="d-flex gap-1">
                <div class=" w-100">
                    <label class="form-label m-0" for="hero-server-icon">{{trans('theme::admin.icon')}}</label>
                    <input type="icon" placeholder="bi bi-box-fill" class="form-control @error('hero-server-icon') is-invalid @enderror" id="hero-server-icon" name="hero[server][icon]" value="{{old('hero-server-icon', config('theme.hero.server.icon'))}}" aria-describedby="hero-server-icon-Label">
                    @error('hero-server-icon')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class=" w-100">
                    <label class="form-label m-0" for="hero-server-text">{{trans('theme::admin.text')}}</label>
                    <input type="text" class="form-control @error('hero-server-text') is-invalid @enderror" id="hero-server-text" name="hero[server][text]" value="{{old('hero-server-text', config('theme.hero.server.text'))}}" aria-describedby="hero-server-text-Label">
                    @error('hero-server-text')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class=" w-100">
                    <label class="form-label m-0" for="hero-server-ip">IP</label>
                    <input type="text" class="form-control @error('hero-server-ip') is-invalid @enderror" id="hero-server-ip" name="hero[server][ip]" value="{{old('hero-server-ip', config('theme.hero.server.ip'))}}" aria-describedby="hero-server-ip-Label">
                    @error('hero-server-ip')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class=" w-100">
                    <label class="form-label m-0" for="hero-server-textcopied">{{trans('theme::admin.ip_when_copied')}}</label>
                    <input type="text" class="form-control @error('hero-server-textcopied') is-invalid @enderror" id="hero-server-textcopied" name="hero[server][textcopied]" value="{{old('hero-server-textcopied', config('theme.hero.server.textcopied'))}}" aria-describedby="hero-server-textcopied-Label">
                    @error('hero-server-textcopied')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div class="d-flex gap-1">
                <div class="w-100">
                    <label class="form-label m-0" for="hero-server-launcher-url">{{ trans('theme::admin.launcher_url') }}</label>
                    <input type="url" class="form-control @error('hero-server-launcher-url') is-invalid @enderror" id="hero-server-launcher-url" name="hero[server][launcher][url]" value="{{ old('hero-server-launcher-url', config('theme.hero.server.launcher.url')) }}" aria-describedby="hero-server-launcher-url-Label">
                    @error('hero-server-launcher-url')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="w-100">
                    <label class="form-label m-0" for="hero-server-launcher-text">{{ trans('theme::admin.launcher_button_text') }}</label>
                    <input type="text" class="form-control @error('hero-server-launcher-text') is-invalid @enderror" id="hero-server-launcher-text" name="hero[server][launcher][text]" value="{{ old('hero-server-launcher-text', config('theme.hero.server.launcher.text')) }}" aria-describedby="hero-server-launcher-text-Label">
                    @error('hero-server-launcher-text')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div>
                <i>{{trans('theme::admin.online_variable')}}</i>
            </div>
        </fieldset>
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.discord')}}</legend>
            <div class="d-flex gap-1">
                <div class=" w-100">
                    <label class="form-label m-0" for="hero-discord-icon">{{trans('theme::admin.icon')}}</label>
                    <input type="icon" placeholder="bi bi-discord" class="form-control @error('hero-discord-icon') is-invalid @enderror" id="hero-discord-icon" name="hero[discord][icon]" value="{{old('hero-discord-icon', config('theme.hero.discord.icon'))}}" aria-describedby="hero-discord-icon-Label">
                    @error('hero-discord-icon')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class=" w-100">
                    <label class="form-label m-0" for="hero-discord-text">{{trans('theme::admin.text')}}</label>
                    <input type="text" class="form-control @error('hero-discord-text') is-invalid @enderror" id="hero-discord-text" name="hero[discord][text]" value="{{old('hero-discord-text', config('theme.hero.discord.text'))}}" aria-describedby="hero-discord-text-Label">
                    @error('hero-discord-text')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class=" w-100">
                    <label class="form-label m-0" for="hero-discord-url">{{trans('theme::admin.url')}}</label>
                    <input type="url" class="form-control @error('hero-discord-url') is-invalid @enderror" id="hero-discord-url" name="hero[discord][url]" value="{{old('hero-discord-url', config('theme.hero.discord.url'))}}" aria-describedby="hero-discord-url-Label">
                    @error('hero-discord-url')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
            <div>
                <i>{{trans('theme::admin.online_variable')}}</i><strong class="{{theme_config('block.discord.type') == 'custom' ? 'd-none':''}} text-info ms-1">{{trans('theme::admin.form.hero.discord_iframe')}}</strong><br/>
                <i class="fw-bold">{{trans('theme::admin.form.hero.discord_show_online')}}</i>
            </div>
        </fieldset>

</div>
