<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Avatar</legend>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>
            <label for="userBar-avatar-toggle">
                <input type="checkbox" id="userBar-avatar-toggle" name="userBar[avatar][toggle]" @if(config('theme.userBar.avatar.toggle')) checked @endif @error('userBar-avatar-toggle') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        @error('userBar-avatar-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
</fieldset>
