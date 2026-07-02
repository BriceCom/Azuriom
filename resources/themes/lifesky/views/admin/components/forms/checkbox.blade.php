<span class="fw-bold">{{$nameToUpper??true  ? mb_strtoupper($name):$name}}</span>
@foreach($multipleId as $id=>$value)
    @php($idReplace = str_replace(['[', '-', ']'],['_'],($id??'')))
    <div class="form-check">
        <label for="{{ $idReplace }}" class="form-check-label m-0 mt-2">{{ $value['name'] }}</label>
        <input id="{{ $idReplace }}" name="{{ $id }}" type="checkbox" @if(config('theme.'.str_replace(['[', ']'],['.',''],$id))) checked @endif class="form-check-input @error($id) is-invalid @enderror" value="{{$value['value']}}">
        @error($id)
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
@endforeach
