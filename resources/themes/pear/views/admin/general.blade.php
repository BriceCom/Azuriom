<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.navbar')}}</legend>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.show_logo_or_text_on_navbar')}}</small>
            <label for="general-navbarLogo-toggle">
                <input type="checkbox" id="general-navbarLogo-toggle" name="general[navbarLogo][toggle]" @if(config('theme.general.navbarLogo.toggle')) checked @endif @error('general-navbarLogo-toggle') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        @error('general-navbarLogo-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.darktheme.title')}}</legend>
    <div class="d-flex flex-column gap-1">
        <div>
            <div class="form-check p-0">
                <div class="switcher">
                    <small class="fw-bold fs-5">{{trans('theme::admin.darktheme.disable')}}</small>
                    <label for="general-darktheme-disable">
                        <input type="checkbox" id="general-darktheme-disable" name="general[darktheme][disable]" @if(config('theme.general.darktheme.disable')) checked @endif @error('general-darktheme-disable') is-invalid @enderror/>
                        <span><small></small></span>
                    </label>
                </div>
                @error('general-darktheme-disable')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </div>
        <div>
            <div class="form-check p-0">
                <div class="switcher">
                    <small class="fw-bold fs-5">{{trans('theme::admin.darktheme.preferlight')}}</small>
                    <label for="general-darktheme-preferlight">
                        <input type="checkbox" id="general-darktheme-preferlight" name="general[darktheme][preferlight]" @if(config('theme.general.darktheme.preferlight')) checked @endif @error('general-darktheme-preferlight') is-invalid @enderror/>
                        <span><small></small></span>
                    </label>
                </div>
                @error('general-darktheme-preferlight')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </div>
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.font.title')}}</legend>
    <div class="d-flex flex-column gap-1">
        <div>
            <div class="form-check p-0">
                <div class="switcher">
                    <small class="fw-bold fs-5">{{trans('theme::admin.font.toggle')}}</small>
                    <label for="general-font-toggle">
                        <input type="checkbox" id="general-font-toggle" name="general[font][toggle]" @if(config('theme.general.font.toggle')) checked @endif @error('general-font-toggle') is-invalid @enderror/>
                        <span><small></small></span>
                    </label>
                </div>
                @error('general-font-toggle')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </div>
        <div class="d-flex gap-1">
            <div class=" w-100">
                <label class="form-label m-0" for="general-font-url">{{trans('theme::admin.font.link_of_font')}} <a target="_blank" href="https://fonts.bunny.net/">{{trans('theme::admin.font.find_custom_font')}}</a></label>
                <input type="url" class="form-control @error('general-font-url') is-invalid @enderror" placeholder="https://fonts.bunny.net/css?family=poppins:100,200,300,400,500,600,700,700i,800,900&display=swap" id="general-font-url" name="general[font][url]" value="{{old('general-font-url', config('theme.general.font.url'))}}" aria-describedby="general-font-url-Label">
                @error('general-font-url')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="w-100">
                <label class="form-label m-0" for="general-font-text">{{trans('theme::admin.font.name_of_font')}}</label>
                <input type="text" class="form-control @error('general-font-text') is-invalid @enderror" placeholder="Poppins" id="general-font-text" name="general[font][text]" value="{{old('general-font-text', config('theme.general.font.text'))}}" aria-describedby="general-font-text-Label">
                @error('general-font-text')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>
</fieldset>
