<div class="form-row card">
    <div class="card-header d-flex justify-content-between">
        <h2 class="card-title">Icon @if(isset($icon)) {{ $loop->iteration }} @else 1 @endif </h2>
        <div class="input-group-append">
            <button class="btn btn-outline-danger command-remove" type="button">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-0">
            <label for="imageSelect">{{ trans('theme::lang.image') }}</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <a class="btn btn-outline-success"
                       href="{{ route('admin.images.create') }}"
                       target="_blank" rel="noopener noreferrer"><i
                            class="fas fa-upload"></i></a>
                </div>
                <select class="custom-select"
                        id="imageSelect-@if(isset($icon)) {{ $loop->iteration }} @else 1 @endif"
                        name="header[iconmenus][{index}][url]"
                        data-image-preview-select="filePreview-@if(isset($icon)) {{ $loop->iteration }} @else 1 @endif">
                    <option value="">none</option>
                    @foreach($allImagesStokage as $image)
                        <option value="{{ $image->file }}"
                                @if(isset($icon['url']) && $icon['url'] === $image->file) selected @endif>{{ $image->name }}</option>
                    @endforeach
                </select>
                <div class="mt-3 w-100">
                    <img src="@if(isset($icon['url'])) {{ image_url($icon['url']) }} @endif"
                         alt="@if(isset($icon['title'])) {{ $icon['title'] }} @endif"
                         class="card-img rounded img-preview-sm @if(!isset($icon['url']))d-none @endif"
                         id="filePreview-@if(isset($icon)) {{ $loop->iteration }} @else 1 @endif"
                         style="object-fit: contain">
                </div>
            </div>
        </div>
        <div class="mb-2">
            <label for="name">Nom</label>
            <select name="header[iconmenus][{index}][name]" id="name" class="w-100 form-control">
                <option value="">none</option>
                @foreach($navbars as $navbar)
                        <option value="{{$navbar->value.'-'.$navbar->type.'-'.$navbar->id}}"
                                @if(isset($icon['name']) && $icon['name'] === $navbar->value.'-'.$navbar->type.'-'.$navbar->id) selected @endif>{{ $navbar->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
