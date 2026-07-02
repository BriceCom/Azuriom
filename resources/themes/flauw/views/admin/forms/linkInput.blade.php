@php($canDel = isset($canDel)??true)
<div class="position-relative d-flex flex-wrap align-items-center gap-1 @if(!$canDel) ps-4 @endif">
    @if(!$canDel)
        <div style="width: fit-content;" class="position-absolute start-0 text-danger fs-3 cursor-pointer" style="top: 5px; right: 5px;" onclick="deleteField(this)"><i class="bi bi-x-circle"></i></div>
    @endif
    <label class="form-label m-0" for="{{$id}}-icon"></label>
    <div class="w-25">
        <input type="text" class="form-control @error($id) is-invalid @enderror" id="{{$id}}-icon" name="{{$id}}[icon]" placeholder="bi bi-house" value="{{old(str_replace(['[', '-', ']'],['_'],($id??'').'_icon'), config('theme.'.str_replace(['[', ']'],['.',''],$id).'.icon'))}}" aria-describedby="{{$id}}-icon-Label">
        @error($id)
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="w-25">
        <input type="text" class="form-control @error($id) is-invalid @enderror" id="{{$id}}-text" name="{{$id}}[text]"  placeholder="Home" value="{{old(str_replace(['[', '-', ']'],['_'],($id??'').'_text'), config('theme.'.str_replace(['[', ']'],['.',''],$id).'.text'))}}" aria-describedby="{{$id}}-text-Label">
        @error($id)
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="w-25">
        <input type="url" class="form-control @error($id) is-invalid @enderror" id="{{$id}}-url" name="{{$id}}[url]" placeholder="https://dixept.fr" value="{{old(str_replace(['[', '-', ']'],['_'],($id??'').'_url'), config('theme.'.str_replace(['[', ']'],['.',''],$id).'.url'))}}" aria-describedby="{{$id}}-url-Label">
        @error($id)
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>
