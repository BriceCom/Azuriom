@php
    $idReplace = str_replace(['[', '-', ']'], ['_', '_', ''], ($id ?? ''));
    $key = trim(str_replace(['[', ']'], ['.', ''], ($id ?? '')), '.');
@endphp
<div class="form-group">
    <label for="{{ $idReplace }}" class="form-label fw-bold m-0">{{ $name }}</label>
    <div class="d-flex align-items-center gap-2">
        <input id="{{ $idReplace }}"
               name="{{ $id }}"
               type="color"
               class="form-control form-control-color @error($key) is-invalid @enderror"
               value="{{ old($key, config('theme.'.$key) ?? ($value ?? '#000000')) }}"
               aria-describedby="{{ $idReplace }}">
        <code>{{ old($key, config('theme.'.$key) ?? ($value ?? '#000000')) }}</code>
    </div>
    @error($key)
    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
    @enderror
</div>
