
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Header</legend>
    <div class="d-flex flex-column gap-1">
            <div>
                <label class="form-label m-0" for="header-btn-shop">Special button name</label>
                <input type="text" class="form-control @error('header-btn-shop') is-invalid @enderror"
                       id="header-btn-shop" name="header[btn][shop]"
                       value="{{old('header-btn-shop', config('theme.header.btn.shop'))}}"
                       aria-describedby="header-btn-shop-Label">
                @error('header-btn-shop')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
    </div>
</fieldset>
