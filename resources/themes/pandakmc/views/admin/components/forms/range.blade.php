@php($idReplace = str_replace(['[', '-', ']'],['_'],($id??'')))
<div class="form-group">
    <label for="{{ $idReplace }}" class="form-label fw-bold m-0 mt-2">{{ $nameToUpper??true  ? mb_strtoupper($name):$name }}</label>
    <div class="d-flex align-center gap-2">
        <output>{{ old($idReplace, config('theme.'.str_replace(['[', ']'],['.',''],$id))) ?? $value }}</output>
        <input id="{{ $idReplace }}" name="{{ $id }}" type="range" min="{{$min}}" max="{{$max}}" step="{{$step}}" class="form-range @error($id) is-invalid @enderror" value="{{ old($idReplace, config('theme.'.str_replace(['[', ']'],['.',''],$id))) ?? $value }}" aria-describedby="{{$id}}" oninput="this.previousElementSibling.value = this.value">
    </div>
    @error($id)
    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
    @enderror
</div>
