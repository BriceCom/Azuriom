@php($idReplace = str_replace(['[', '-', ']'],['_'],($id??'')))
<div class="form-group">
    <label for="{{$idReplace}}" class="form-label fw-bold m-0 mt-2">{{ $nameToUpper??true  ? mb_strtoupper($name):$name }}</label>
    <div class="d-flex align-center">
        <a class=" input-group-text text-success" href="{{ route('admin.images.create') }}" title="Upload a image"  target="_blank" rel="noopener noreferrer">
           <i class="bi bi-upload"></i>
        </a>
        <select class="form-select"
                id="{{$idReplace}}"
                name="{{ $id }}"
                data-image-preview-select="filePreview-slider-"{{ $id }}
                onchange="showPreview('{{$idReplace}}');">
            <option value="">none</option>
            @foreach($azuriomImages as $image)
                <option value="{{ $image->file }}"
                        @if(config('theme.'.str_replace(['[', ']'],['.',''],$id)) == $image->file) selected @endif>{{ $image->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mt-3 w-100" style="height: 100px; {{config('theme.'.str_replace(['[', ']'],['.',''],$id)) ?? 'display: none'}}">
        <img id="img-preview-{{$idReplace}}" style="object-fit: contain;" class="w-100 h-100" src="{{config('theme.'.str_replace(['[', ']'],['.',''],$id)) ? image_url(old($idReplace, config('theme.'.str_replace(['[', ']'],['.',''],$id)))):''}}" alt="">
    </div>
    @error($id)
    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
    @enderror
</div>
