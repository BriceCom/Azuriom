@props(['icon' => null])
@php($idReplace = str_replace(['[', '-', ']'],['_'],($id??'')))

<div class="form-group">
    <label for="{{ $idReplace }}" class="form-label fw-bold">{!!  $nameToUpper??true  ? mb_strtoupper($name):$name !!}</label>

    <div class="input-group">
        @if($icon) <span class="input-group-text"><i class="{{ config('theme.'.str_replace(['[', ']'],['.',''],$id)) ?? $placeholder ? $placeholder :'bi bi-house' }}"></i></span> @endif
        <input id="{{ $idReplace }}" name="{{ $id }}" type="text" placeholder="{{$placeholder ?? ''}}" class="form-control @error($id) is-invalid @enderror" value="{{ old($idReplace, config('theme.'.str_replace(['[', ']'],['.',''],$id))) }}" aria-describedby="{{$id}}">
    </div>

    @error($id)
    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
    @enderror
</div>
