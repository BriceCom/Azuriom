<fieldset class="d-flex gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-white text-black text-lg">THEME LIGHT</legend>
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-white text-black text-lg">GENERAL</legend>
        <div class="form-group">
            <label for="general-colorLight-primary" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} {{trans('theme::admin.main')}}</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorLight-primary" name="general[colorLight][primary]" type="color" class="form-control form-control-color @error('general-colorLight-primary') is-invalid @enderror" value="{{ old('general-colorLight-primary', config('theme.general.colorLight.primary')) ?? '#661F10' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#661F10" onclick="inputColorDefaultValue(this, '#661F10', '{{config('theme.general.colorLight.primary')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorLight-primary')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
        <div class="form-group">
            <label for="general-colorLight-secondary" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} {{trans('theme::admin.secondary')}}</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorLight-secondary" name="general[colorLight][secondary]" type="color" class="form-control form-control-color @error('general-colorLight-secondary') is-invalid @enderror" value="{{ old('general-colorLight-secondary', config('theme.general.colorLight.secondary')) ?? '#6C757D' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#6C757D" onclick="inputColorDefaultValue(this, '#6C757D', '{{config('theme.general.colorLight.secondary')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorLight-secondary')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>

        <div class="form-group">
            <label for="general-colorLight-body" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} {{trans('theme::admin.body')}}</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorLight-body" name="general[colorLight][body]" type="color" class="form-control form-control-color @error('general-colorLight-body') is-invalid @enderror" value="{{ old('general-colorLight-body', config('theme.general.colorLight.body')) ?? '#ededed' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#ededed" onclick="inputColorDefaultValue(this, '#ededed', '{{config('theme.general.colorLight.body')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorLight-body')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-white text-black text-lg">{{mb_strtoupper(trans('theme::admin.secondary'))}}</legend>
        <div class="form-group">
            <label for="general-colorLight-light" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} 1</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorLight-light" name="general[colorLight][light]" type="color" class="form-control form-control-color @error('general-colorLight-light') is-invalid @enderror" value="{{ old('general-colorLight-light', config('theme.general.colorLight.light')) ?? '#dddddd' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#dddddd" onclick="inputColorDefaultValue(this, '#dddddd', '{{config('theme.general.colorLight.light')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorLight-light')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
        <div class="form-group">
            <label for="general-colorLight-dark" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} 2</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorLight-dark" name="general[colorLight][dark]" type="color" class="form-control form-control-color @error('general-colorLight-dark') is-invalid @enderror" value="{{ old('general-colorLight-dark', config('theme.general.colorLight.dark')) ?? '#F8F9FA' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#F8F9FA" onclick="inputColorDefaultValue(this, '#F8F9FA', '{{config('theme.general.colorLight.dark')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorLight-dark')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
        <div class="form-group">
            <label for="general-colorLight-black" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} 3</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorLight-black" name="general[colorLight][black]" type="color" class="form-control form-control-color @error('general-colorLight-black') is-invalid @enderror" value="{{ old('general-colorLight-black', config('theme.general.colorLight.black')) ?? '#dfdfdf' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#dfdfdf" onclick="inputColorDefaultValue(this, '#dfdfdf', '{{config('theme.general.colorLight.black')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorLight-black')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-white text-black text-lg">ANNEXE</legend>
        <div class="form-group">
            <label for="general-colorLight-white" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} {{trans('theme::admin.text')}}</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorLight-white" name="general[colorLight][white]" type="color" class="form-control form-control-color @error('general-colorLight-white') is-invalid @enderror" value="{{ old('general-colorLight-white', config('theme.general.colorLight.white')) ?? '#212529' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#212529" onclick="inputColorDefaultValue(this, '#212529', '{{config('theme.general.colorLight.white')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorLight-white')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
        <div class="form-group">
            <label for="general-colorLight-textbtnprimary" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.form.colors.color_of_primary_buttons')}}</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorLight-textbtnprimary" name="general[colorLight][textbtnprimary]" type="color" class="form-control form-control-color @error('general-colorLight-textbtnprimary') is-invalid @enderror" value="{{ old('general-colorLight-textbtnprimary', config('theme.general.colorLight.textbtnprimary')) ?? '#ffffff' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#ffffff" onclick="inputColorDefaultValue(this, '#ffffff', '{{config('theme.general.colorLight.textbtnprimary')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorLight-textbtnprimary')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
        <div class="form-group">
            <label for="general-colorLight-textbtnsecondary" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.form.colors.color_of_secondary_buttons')}}</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorLight-textbtnsecondary" name="general[colorLight][textbtnsecondary]" type="color" class="form-control form-control-color @error('general-colorLight-textbtnsecondary') is-invalid @enderror" value="{{ old('general-colorLight-textbtnsecondary', config('theme.general.colorLight.textbtnsecondary')) ?? '#212529' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#212529" onclick="inputColorDefaultValue(this, '#212529', '{{config('theme.general.colorLight.textbtnsecondary')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorLight-textbtnsecondary')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
    </fieldset>
</fieldset>
<fieldset class="d-flex gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-black text-white text-lg">THEME DARK</legend>
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">GENERAL</legend>
        <div class="form-group">
            <label for="general-colorDark-primary" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} {{trans('theme::admin.main')}}</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorDark-primary" name="general[colorDark][primary]" type="color" class="form-control form-control-color @error('general-colorDark-primary') is-invalid @enderror" value="{{ old('general-colorDark-primary', config('theme.general.colorDark.primary')) ?? '#ECAF2D' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#ECAF2D" onclick="inputColorDefaultValue(this, '#ECAF2D', '{{config('theme.general.colorDark.primary')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorDark-primary')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
        <div class="form-group">
            <label for="general-colorDark-secondary" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} {{trans('theme::admin.secondary')}}</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorDark-secondary" name="general[colorDark][secondary]" type="color" class="form-control form-control-color @error('general-colorDark-secondary') is-invalid @enderror" value="{{ old('general-colorDark-secondary', config('theme.general.colorDark.secondary')) ?? '#6C757D' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#6C757D" onclick="inputColorDefaultValue(this, '#6C757D', '{{config('theme.general.colorDark.secondary')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorDark-secondary')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>

        <div class="form-group">
            <label for="general-colorDark-body" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} {{trans('theme::admin.body')}}</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorDark-body" name="general[colorDark][body]" type="color" class="form-control form-control-color @error('general-colorDark-body') is-invalid @enderror" value="{{ old('general-colorDark-body', config('theme.general.colorDark.body')) ?? '#05151F' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#05151F" onclick="inputColorDefaultValue(this, '#05151F', '{{config('theme.general.colorDark.body')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorDark-body')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{mb_strtoupper(trans('theme::admin.secondary'))}}</legend>
        <div class="form-group">
            <label for="general-colorDark-light" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} 1</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorDark-light" name="general[colorDark][light]" type="color" class="form-control form-control-color @error('general-colorDark-light') is-invalid @enderror" value="{{ old('general-colorDark-light', config('theme.general.colorDark.light')) ?? '#1B2B35' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#1B2B35" onclick="inputColorDefaultValue(this, '#1B2B35', '{{config('theme.general.colorDark.light')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorDark-light')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
        <div class="form-group">
            <label for="general-colorDark-dark" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} 2</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorDark-dark" name="general[colorDark][dark]" type="color" class="form-control form-control-color @error('general-colorDark-dark') is-invalid @enderror" value="{{ old('general-colorDark-dark', config('theme.general.colorDark.dark')) ?? '#14222b' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#14222b" onclick="inputColorDefaultValue(this, '#14222b', '{{config('theme.general.colorDark.dark')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorDark-dark')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
        <div class="form-group">
            <label for="general-colorDark-black" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} 3</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorDark-black" name="general[colorDark][black]" type="color" class="form-control form-control-color @error('general-colorDark-black') is-invalid @enderror" value="{{ old('general-colorDark-black', config('theme.general.colorDark.black')) ?? '#030f16' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#030f16" onclick="inputColorDefaultValue(this, '#030f16', '{{config('theme.general.colorDark.black')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorDark-black')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
    </fieldset>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">ANNEXE</legend>
        <div class="form-group">
            <label for="general-colorDark-white" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} {{trans('theme::admin.text')}}</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorDark-white" name="general[colorDark][white]" type="color" class="form-control form-control-color @error('general-colorDark-white') is-invalid @enderror" value="{{ old('general-colorDark-white', config('theme.general.colorDark.white')) ?? '#E5E5E5' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#E5E5E5" onclick="inputColorDefaultValue(this, '#E5E5E5', '{{config('theme.general.colorDark.white')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorDark-white')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
        <div class="form-group">
            <label for="general-colorDark-textbtnprimary" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.form.colors.color_of_primary_buttons')}}</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorDark-textbtnprimary" name="general[colorDark][textbtnprimary]" type="color" class="form-control form-control-color @error('general-colorDark-textbtnprimary') is-invalid @enderror" value="{{ old('general-colorDark-textbtnprimary', config('theme.general.colorDark.textbtnprimary')) ?? '#000000' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#000000" onclick="inputColorDefaultValue(this, '#000000', '{{config('theme.general.colorDark.textbtnprimary')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorDark-textbtnprimary')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
        <div class="form-group">
            <label for="general-colorDark-textbtnsecondary" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.form.colors.color_of_secondary_buttons')}}</label>
            <div class="d-flex flex-row align-items-center gap-1">
                <input id="general-colorDark-textbtnsecondary" name="general[colorDark][textbtnsecondary]" type="color" class="form-control form-control-color @error('general-colorDark-textbtnsecondary') is-invalid @enderror" value="{{ old('general-colorDark-textbtnsecondary', config('theme.general.colorDark.textbtnsecondary')) ?? '#ffffff' }}">
                <input type="checkbox" class="colorPicker fst-italic" value="#ffffff" onclick="inputColorDefaultValue(this, '#ffffff', '{{config('theme.general.colorDark.textbtnsecondary')}}')"/>
                <small>{{trans('theme::admin.form.color.default_color')}}</small>
            </div>
            @error('general-colorDark-textbtnsecondary')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
    </fieldset>
</fieldset>

<script>
    {{--  Keep default color, and user can return to initial color of the theme  --}}
    function inputColorDefaultValue(e, value, config_value){ e.previousElementSibling.value != e.value ? e.previousElementSibling.value = e.value:e.previousElementSibling.value = config_value; }
</script>
