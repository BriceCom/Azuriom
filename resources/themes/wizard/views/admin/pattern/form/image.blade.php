<div class="py-2">
    <label
        for="selectImage-widget-{{$loop->index}}-{{$field['key']}}-banner">{{$field['label']}}</label>
    <div class="input-group mb-3">
        <div class="input-group-text">
            <a class="btn btn-outline-success"
               href="{{ route('admin.images.create') }}"
               target="_blank" rel="noopener noreferrer"><i
                    class="bi bi-upload"></i></a>
        </div>
        <select class="form-select js-detect-row js-detect-page js-detect-widget-id"
                id="selectImage-widget-{{$loop->index}}-{{$field['key']}}-banner"
                name="{{$page}}[{{$field['key']}}][{{$field['value']}}]"
                data-image-preview-select="filePreview-widget-{{$loop->index}}-{{$field['key']}}">
            <option value="">none</option>
            @foreach($allImagesStokage as $image)
                <option value="{{ $image->file }}"
                        @if(theme_config($page.'.'.$field['key'].'.'.$field['value']) === $image->file) selected @endif>{{ $image->name }}</option>
            @endforeach
        </select>
        <div class="mt-3 w-100">
            <img
                src="{{ theme_config($page.'.'.$field['key'].'.'.$field['value']) !== null ? image_url(theme_config($page.'.'.$field['key'].'.'.$field['value'])) :'' }}"
                alt="{{ theme_config($page.'.'.$field['key'].'.'.$field['value']) }}"
                class="card-img rounded img-preview-sm @if(!theme_config($page.'.'.$field['key'].'.'.$field['value']))d-none @endif"
                id="filePreview-widget-{{$loop->index}}-{{$field['key']}}"
                style="object-fit: contain;max-height: 90px">
        </div>
    </div>
</div>
