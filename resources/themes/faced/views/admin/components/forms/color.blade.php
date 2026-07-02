@php($idReplace = str_replace(['[', '-', ']'],['_'],($id??'')))
<div class="form-group">
    <label for="{{ $idReplace }}" class="form-label fw-bold m-0">{{ $nameToUpper??true  ? mb_strtoupper($name):$name }}</label>
    <div class="d-flex flex-row align-items-center gap-1">
        <input id="{{ $idReplace }}" name="{{ $id }}" type="color" class="form-control form-control-color @error($id) is-invalid @enderror" value="{{ old($idReplace, config('theme.'.str_replace(['[', ']'],['.',''],$id))) ?? $value??'' }}" aria-describedby="{{$id}}">
        <input type="checkbox" class="colorPicker fst-italic" value="{{$value}}" onclick="inputColorDefaultValue(this, '{{$value}}', '{{config('theme.'.str_replace(['[', ']'],['.',''],$id))}}')"/>
        <small>{{trans('theme::admin.form.color.default_color')}}</small>
    </div>
    @error($id)
    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
    @enderror
</div>
