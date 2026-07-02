<fieldset class="d-flex  gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.basket.toggle')}}</legend>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>
            <label for="hero-basket-toggle">
                <input type="checkbox" id="hero-basket-toggle" name="hero[basket][toggle]" @if(config('theme.hero.basket.toggle')) checked @endif @error('hero-basket-toggle') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        <small class="text-danger">{!! trans('theme::admin.need_serveurliste_link') !!}</small>
        @error('hero-basket-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
</fieldset>
<fieldset class="d-flex flex-column  gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-black text-white text-lg">{{trans('theme::admin.principal_button')}}</legend>
    <div class="w-100">
        <label class="form-label m-0" for="navbar-button-text">{{trans('theme::admin.navbartext')}}</label>
        <input type="text" class="form-control @error('navbar-button-text') is-invalid @enderror" id="navbar-button-text" name="navbar[button][text]" value="{{old('navbar-button-text', config('theme.navbar.button.text'))}}" aria-describedby="whatsAdventure-navbar4-text-Label"></input>
        @error('navbar-button-text')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="d-flex">
        <fieldset class="d-flex gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-white text-black text-sm">THEME LIGHT</legend>

            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-white text-black text-lg">ANNEXE</legend>
                <div class="form-group">
                    <label for="general-colorLight-show" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.form.colors.color_of_show_button')}}</label>
                    <div class="d-flex flex-row align-items-center gap-1">
                        <input id="general-colorLight-show" name="general[colorLight][show]" type="color" class="form-control form-control-color @error('general-colorLight-show') is-invalid @enderror" value="{{ old('general-colorLight-show', config('theme.general.colorLight.show')) ?? '#ECAF2D' }}">
                        <input type="checkbox" class="colorPicker fst-italic" value="#ECAF2D" onclick="inputColorDefaultValue(this, '#ECAF2D', '{{config('theme.general.colorLight.show')}}')"/>
                        <small>{{trans('theme::admin.form.color.default_color')}}</small>
                    </div>
                    @error('general-colorLight-show')
                    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                    @enderror
                </div>
            </fieldset>
        </fieldset>
        <fieldset class="d-flex gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-black text-white text-sm">THEME DARK</legend>
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-black text-white text-lg">ANNEXE</legend>
                <div class="form-group">
                    <label for="general-colorDark-show" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.form.colors.color_of_show_button')}}</label>
                    <div class="d-flex flex-row align-items-center gap-1">
                        <input id="general-colorDark-show" name="general[colorDark][show]" type="color" class="form-control form-control-color @error('general-colorDark-show') is-invalid @enderror" value="{{ old('general-colorDark-show', config('theme.general.colorDark.show')) ?? '#DD1919' }}">
                        <input type="checkbox" class="colorPicker fst-italic" value="#DD1919" onclick="inputColorDefaultValue(this, '#DD1919', '{{config('theme.general.colorDark.show')}}')"/>
                        <small>{{trans('theme::admin.form.color.default_color')}}</small>
                    </div>
                    @error('general-colorDark-show')
                    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                    @enderror
                </div>
            </fieldset>
        </fieldset>
    </div>
</fieldset>
