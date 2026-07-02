<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.news')}}</legend>
    <div class=" w-100">
        <label class="form-label m-0" for="block-news-title">{{trans('theme::admin.title')}}</label>
        <input type="text" class="form-control @error('block-news-title') is-invalid @enderror" id="block-news-title" name="block[news][title]" value="{{old('block-news-title', config('theme.block.news.title'))}}" aria-describedby="block-news-title-Label">
        @error('block-news-title')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.button')}}</legend>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>
            <label for="block-button-toggle">
                <input type="checkbox" id="block-button-toggle" name="block[button][toggle]" @if(config('theme.block.button.toggle')) checked @endif @error('block-button-toggle') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        @error('block-twitter-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
    <div class=" w-100">
        <label class="form-label m-0" for="block-button-icon">{{trans('theme::admin.icon')}}</label>
        <input type="text" placeholder="bi bi-arrow-right" class="form-control @error('block-button-icon') is-invalid @enderror" id="block-button-icon" name="block[button][icon]" value="{{old('block-button-icon', config('theme.block.button.icon'))}}" aria-describedby="block-button-icon-Label">
        @error('block-button-icon')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class=" w-100">
        <label class="form-label m-0" for="block-button-text">{{trans('theme::admin.text')}}</label>
        <input type="text" class="form-control @error('block-button-text') is-invalid @enderror" id="block-button-text" name="block[button][text]" value="{{old('block-button-text', config('theme.block.button.text'))}}" aria-describedby="block-button-text-Label">
        @error('block-button-text')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class=" w-100">
        <label class="form-label m-0" for="block-button-url">{{trans('theme::admin.url')}}</label>
        <input type="text" placeholder="https://dixept.fr" class="form-control @error('block-button-url') is-invalid @enderror" id="block-button-url" name="block[button][url]" value="{{old('block-button-url', config('theme.block.button.url'))}}" aria-describedby="block-button-url-Label">
        @error('block-button-url')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.other_page')}}</small>
            <label for="block-button-blank">
                <input type="checkbox" id="block-button-blank" name="block[button][blank]" @if(config('theme.block.button.blank')) checked @endif @error('block-button-blank') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        @error('block-button-blank')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.twitter')}}</legend>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>
            <label for="block-twitter-toggle">
                <input type="checkbox" id="block-twitter-toggle" name="block[twitter][toggle]" @if(config('theme.block.twitter.toggle')) checked @endif @error('block-twitter-toggle') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        @error('block-twitter-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
    <div class="form-group">
        <label for="block-twitter-amount" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.amount_to_show')}}</label>
        <div class="d-flex align-center gap-2">
            <output>{{old('block-twitter-amount', config('theme.block.twitter.amount'))}}</output>
            <input id="block-twitter-amount" name="block[twitter][amount]" type="range" min="1" max="10" step="1" class="form-range @error('block-twitter-amount') is-invalid @enderror" value="{{old('block-twitter-amount', config('theme.block.twitter.amount'))}}" aria-describedby="block-twitter-amount" oninput="this.previousElementSibling.value = this.value">
        </div>
        @error('block-twitter-amount')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
    <div class=" w-100">
        <label class="form-label m-0" for="block-twitter-url">{{trans('theme::admin.url')}}</label>
        <input type="text" class="form-control @error('block-twitter-url') is-invalid @enderror" id="block-twitter-url" name="block[twitter][url]" value="{{old('block-twitter-url', config('theme.block.twitter.url'))}}" aria-describedby="block-twitter-url-Label">
        @error('block-twitter-url')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="form-group">
        <label for="block-twitter-theme" class="form-label fw-bold m-0">{{trans('theme::admin.theme')}}</label>
        <div class="d-flex align-center">
            <select class="form-select"
                    id="block-twitter-theme"
                    name="block[twitter][theme]">
                <option value="white" @if(config('theme.block.twitter.theme') == "white") selected @endif>{{trans('theme::admin.white')}}</option>
                <option value="dark" @if(config('theme.block.twitter.theme') == "dark") selected @endif>{{trans('theme::admin.black')}}</option>

            </select>
        </div>
        @error('block-twitter-theme')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.discord')}}</legend>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>
            <label for="block-discord-toggle">
                <input type="checkbox" id="block-discord-toggle" name="block[discord][toggle]" @if(config('theme.block.discord.toggle')) checked @endif @error('block-discord-toggle') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        @error('block-discord-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.show')}}</small>
            <label for="block-discord-type">
                <select class="form-select @error('block-discord-type') is-invalid @enderror"  name="block[discord][type]" id="block-discord-type" onchange="discordTypeChange(this.value)">
                    <option value="custom" @if(config('theme.block.discord.type') == 'custom') selected @endif>CUSTOM</option>
                    <option value="iframe" @if(config('theme.block.discord.type') == 'iframe') selected @endif>IFRAME</option>
                </select>
            </label>
        </div>
        @error('block-discord-type')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
    <div id="discord-iframe" class="{{theme_config('block.discord.type') == 'custom' ? 'd-none':''}}">
        <div class="form-group">
            <label for="block-discord-theme" class="form-label fw-bold m-0">{{trans('theme::admin.theme')}}</label>
            <div class="d-flex align-center">
                <select class="form-select"
                        id="block-discord-theme"
                        name="block[discord][theme]">
                    <option value="light" @if(config('theme.block.discord.theme') == "light") selected @endif>{{trans('theme::admin.white')}}</option>
                    <option value="dark" @if(config('theme.block.discord.theme') == "dark") selected @endif>{{trans('theme::admin.black')}}</option>

                </select>
            </div>
            @error('block-discord-theme')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
    </div>
    <div class=" w-100">
        <label class="form-label m-0" for="block-discord-id">ID {{trans('theme::admin.discord')}}</label>
        <input type="text" placeholder="1025845189115400303" class="form-control @error('block-discord-id') is-invalid @enderror" id="block-discord-id" name="block[discord][id]" value="{{old('block-discord-id', config('theme.block.discord.id'))}}" aria-describedby="block-discord-id-Label">
        @error('block-discord-id')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div id="discord-custom" class="{{theme_config('block.discord.type') == 'iframe' ? 'd-none':''}}">
        <div class=" w-100">
            <label class="form-label m-0" for="block-discord-url">{{trans('theme::admin.url')}}</label>
            <input type="url" placeholder="https://discord.gg/Gh2yBxUWvV" class="form-control @error('block-discord-url') is-invalid @enderror" id="block-discord-url" name="block[discord][url]" value="{{old('block-discord-url', config('theme.block.discord.url'))}}" aria-describedby="block-discord-url-Label">
            @error('block-discord-url')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class=" w-100">
            <label class="form-label m-0" for="block-discord-textonline">{{trans('theme::admin.text')}}</label>
            <input type="text" placeholder="{{trans('theme::admin.online')}}" class="form-control @error('block-discord-textonline') is-invalid @enderror" id="block-discord-textonline" name="block[discord][textonline]" value="{{old('block-discord-textonline', config('theme.block.discord.textonline'))}}" aria-describedby="block-discord-textonline-Label">
            @error('block-discord-textonline')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class=" w-100">
            <label class="form-label m-0" for="block-discord-textjoin">{{trans('theme::admin.text')}}</label>
            <input type="text" placeholder="{{trans('theme::admin.join')}}" class="form-control @error('block-discord-textjoin') is-invalid @enderror" id="block-discord-textjoin" name="block[discord][textjoin]" value="{{old('block-discord-textjoin', config('theme.block.discord.textjoin'))}}" aria-describedby="block-discord-textjoin-Label">
            @error('block-discord-textjoin')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
</fieldset>
