<div class="w-100 d-flex flex-column gap-4">
    <fieldset class="d-flex flex-column gap-3 border border-warning p-2 w-50">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">⭐ {{trans('theme::admin.font.title')}}</legend>
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


    <div class="d-flex flex-column flex-md-row gap-2">
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">GENERAL</legend>
            <div class="form-group">
                <label for="general-color-primary" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} {{trans('theme::admin.main')}}</label>
                <div class="d-flex flex-row align-items-center gap-1">
                    <input id="general-color-primary" name="general[color][primary]" type="color" class="form-control form-control-color @error('general-color-primary') is-invalid @enderror" value="{{ old('general-color-primary', config('theme.general.color.primary')) ?? '#ddb72c' }}">
                    <input type="checkbox" class="colorPicker fst-italic" value="#ddb72c" onclick="inputColorDefaultValue(this, '#ddb72c', '{{config('theme.general.color.primary')}}')"/>
                    <small>{{trans('theme::admin.form.color.default_color')}}</small>
                </div>
                @error('general-color-primary')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="form-group">
                <label for="general-color-secondary" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} {{trans('theme::admin.secondary')}}</label>
                <div class="d-flex flex-row align-items-center gap-1">
                    <input id="general-color-secondary" name="general[color][secondary]" type="color" class="form-control form-control-color @error('general-color-secondary') is-invalid @enderror" value="{{ old('general-color-secondary', config('theme.general.color.secondary')) ?? '#6C757D' }}">
                    <input type="checkbox" class="colorPicker fst-italic" value="#6C757D" onclick="inputColorDefaultValue(this, '#6C757D', '{{config('theme.general.color.secondary')}}')"/>
                    <small>{{trans('theme::admin.form.color.default_color')}}</small>
                </div>
                @error('general-color-secondary')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>

            <div class="form-group">
                <label for="general-color-body" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} {{trans('theme::admin.body')}}</label>
                <div class="d-flex flex-row align-items-center gap-1">
                    <input id="general-color-body" name="general[color][body]" type="color" class="form-control form-control-color @error('general-color-body') is-invalid @enderror" value="{{ old('general-color-body', config('theme.general.color.body')) ?? '#212529' }}">
                    <input type="checkbox" class="colorPicker fst-italic" value="#212529" onclick="inputColorDefaultValue(this, '#212529', '{{config('theme.general.color.body')}}')"/>
                    <small>{{trans('theme::admin.form.color.default_color')}}</small>
                </div>
                @error('general-color-body')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </fieldset>

        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{mb_strtoupper(trans('theme::admin.secondary'))}}</legend>
            <div class="form-group">
                <label for="general-color-light" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} 1</label>
                <div class="d-flex flex-row align-items-center gap-1">
                    <input id="general-color-light" name="general[color][light]" type="color" class="form-control form-control-color @error('general-color-light') is-invalid @enderror" value="{{ old('general-color-light', config('theme.general.color.light')) ?? '#33404C' }}">
                    <input type="checkbox" class="colorPicker fst-italic" value="#33404C" onclick="inputColorDefaultValue(this, '#33404C', '{{config('theme.general.color.light')}}')"/>
                    <small>{{trans('theme::admin.form.color.default_color')}}</small>
                </div>
                @error('general-color-light')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="form-group">
                <label for="general-color-dark" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} 2</label>
                <div class="d-flex flex-row align-items-center gap-1">
                    <input id="general-color-dark" name="general[color][dark]" type="color" class="form-control form-control-color @error('general-color-dark') is-invalid @enderror" value="{{ old('general-color-dark', config('theme.general.color.dark')) ?? '#2D3C46' }}">
                    <input type="checkbox" class="colorPicker fst-italic" value="#2D3C46" onclick="inputColorDefaultValue(this, '#2D3C46', '{{config('theme.general.color.dark')}}')"/>
                    <small>{{trans('theme::admin.form.color.default_color')}}</small>
                </div>
                @error('general-color-dark')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="form-group">
                <label for="general-color-black" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} 3</label>
                <div class="d-flex flex-row align-items-center gap-1">
                    <input id="general-color-black" name="general[color][black]" type="color" class="form-control form-control-color @error('general-color-black') is-invalid @enderror" value="{{ old('general-color-black', config('theme.general.color.black')) ?? '#000000' }}">
                    <input type="checkbox" class="colorPicker fst-italic" value="#000000" onclick="inputColorDefaultValue(this, '#000000', '{{config('theme.general.color.black')}}')"/>
                    <small>{{trans('theme::admin.form.color.default_color')}}</small>
                </div>
                @error('general-color-black')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </fieldset>

        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">ANNEXE</legend>
            <div class="form-group">
                <label for="general-color-white" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.color')}} {{trans('theme::admin.text')}}</label>
                <div class="d-flex flex-row align-items-center gap-1">
                    <input id="general-color-white" name="general[color][white]" type="color" class="form-control form-control-color @error('general-color-white') is-invalid @enderror" value="{{ old('general-color-white', config('theme.general.color.white')) ?? '#E5E5E5' }}">
                    <input type="checkbox" class="colorPicker fst-italic" value="#E5E5E5" onclick="inputColorDefaultValue(this, '#E5E5E5', '{{config('theme.general.color.white')}}')"/>
                    <small>{{trans('theme::admin.form.color.default_color')}}</small>
                </div>
                @error('general-color-white')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="form-group">
                <label for="general-color-textbtnprimary" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.form.colors.color_of_primary_buttons')}}</label>
                <div class="d-flex flex-row align-items-center gap-1">
                    <input id="general-color-textbtnprimary" name="general[color][textbtnprimary]" type="color" class="form-control form-control-color @error('general-color-textbtnprimary') is-invalid @enderror" value="{{ old('general-color-textbtnprimary', config('theme.general.color.textbtnprimary')) ?? '#E5E5E5' }}">
                    <input type="checkbox" class="colorPicker fst-italic" value="#E5E5E5" onclick="inputColorDefaultValue(this, '#E5E5E5', '{{config('theme.general.color.textbtnprimary')}}')"/>
                    <small>{{trans('theme::admin.form.color.default_color')}}</small>
                </div>
                @error('general-color-textbtnprimary')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="form-group">
                <label for="general-color-textbtnsecondary" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.form.colors.color_of_secondary_buttons')}}</label>
                <div class="d-flex flex-row align-items-center gap-1">
                    <input id="general-color-textbtnsecondary" name="general[color][textbtnsecondary]" type="color" class="form-control form-control-color @error('general-color-textbtnsecondary') is-invalid @enderror" value="{{ old('general-color-textbtnsecondary', config('theme.general.color.textbtnsecondary')) ?? '#E5E5E5' }}">
                    <input type="checkbox" class="colorPicker fst-italic" value="#E5E5E5" onclick="inputColorDefaultValue(this, '#E5E5E5', '{{config('theme.general.color.textbtnsecondary')}}')"/>
                    <small>{{trans('theme::admin.form.color.default_color')}}</small>
                </div>
                @error('general-color-textbtnsecondary')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
        </fieldset>
    </div>
</div>

<script>
    {{--  Keep default color, and user can return to initial color of the theme  --}}
    function inputColorDefaultValue(e, value, config_value){ e.previousElementSibling.value != e.value ? e.previousElementSibling.value = e.value:e.previousElementSibling.value = config_value; }
</script>
