@php($idReplace = str_replace(['[', '-', ']'],['_'],($id??'')))
<div class="form-check p-0">
    <div class="switcher d-flex align-items-center gap-3">
        <label for="{{ $idReplace }}" class="d-flex">
            <input type="checkbox" id="{{ $idReplace }}" name="{{ $id }}" @if(config('theme.'.str_replace(['[', ']'],['.',''],$id))) checked @endif @error($id) is-invalid @enderror/>
            <span><small></small></span>
        </label>
        <small class="fw-bold fs-5">{{ $nameToUpper??true  ? mb_strtoupper($name):$name }}</small>
    </div>
    @error($id)
    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
    @enderror
</div>
