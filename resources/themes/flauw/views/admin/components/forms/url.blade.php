@php($idReplace = str_replace(['[', '-', ']'],['_'],($id??'')))
<div class="form-group {{$class ?? ''}}">
    <label for="{{ $idReplace }}" class="form-label fw-bold m-0">{!! $nameToUpper??true  ? mb_strtoupper($name):$name !!}</label>
    <input id="{{ $idReplace }}" @if(isset($pattern))pattern="{{$pattern ?? ''}}"@endif  name="{{ $id }}" type="url" placeholder="{{$placeholder ?? ''}}" class="form-control @error($id) is-invalid @enderror" value="{{ old($idReplace, config('theme.'.str_replace(['[', ']'],['.',''],$id))) }}" aria-describedby="{{$id}}">
    @error($id)
    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
    @enderror
</div>
