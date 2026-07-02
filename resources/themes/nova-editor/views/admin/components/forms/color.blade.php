@props([
    'hideLabel' => false,
    'defaultColor' => null,
    'value' => "#000000"
])
@php($idReplace = str_replace(['[', '-', ']'],['_'],($id??'')))
<div class="relative form-group">
    <label for="{{ $idReplace }}" class="form-label fw-bold m-0 {{ $hideLabel ? "position-absolute top-0 opacity-0":"" }}">{{ $nameToUpper??true  ? mb_strtoupper($name):$name }}</label>
    <div class="d-flex flex-row align-items-center gap-1">
        <input id="{{ $idReplace }}" name="{{ $id }}" type="color" class="form-control form-control-color color-picker @error($id) is-invalid @enderror" value="{{ old($idReplace, config('theme.'.str_replace(['[', ']'],['.',''],$id))) ?? $value??'' }}" aria-describedby="{{$id}}">
        @if($defaultColor)
            <input type="checkbox" class="colorPicker fst-italic" value="{{$value}}" onclick="inputColorDefaultValue(this, '{{$value}}', '{{config('theme.'.str_replace(['[', ']'],['.',''],$id))}}')"/>
            <small>{{trans('theme::admin.form.color.default_color')}}</small>
        @endif
    </div>
    @error($id)
    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
    @enderror
</div>
