<div class="form-check p-0">
    <div class="switcher">
        <small class="fw-bold fs-5">{{trans('theme::admin.header.hide_login_and_register')}}</small>
        <label for="header-login-toggle">
            <input type="checkbox" id="header-login-toggle" name="header[login][toggle]" @if(config('theme.header.login.toggle')) checked @endif @error('header-login-toggle') is-invalid @enderror/>
            <span><small></small></span>
        </label>
    </div>

    @error('header-login-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
    @enderror
</div>
