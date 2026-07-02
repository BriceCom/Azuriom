<div class="form-check p-0">
    <div class="switcher">
        <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>
        <label for="footer-toggle">
            <input type="checkbox" id="footer-toggle" name="footer[toggle]" @if(config('theme.footer.toggle')) checked @endif @error('footer-toggle') is-invalid @enderror/>
            <span><small></small></span>
        </label>
    </div>
    @error('footer-toggle')
    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
    @enderror
</div>
<div>
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-primary text-white text-lg">{{trans('theme::admin.top')}}</legend>
            <div>
                <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.image')}}</legend>
                    <div class="d-flex gap-4">
                        <div class="form-group">
                            <label for="footer-top-image-url" class="form-label fw-bold m-0">{{trans('theme::admin.image')}}</label>
                            <div class="d-flex align-center">
                                <a class=" input-group-text text-success" href="{{ route('admin.images.create') }}" title="Upload a image"  target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-upload"></i>
                                </a>
                                <select class="form-select"
                                        id="footer-top-image-url"
                                        name="footer[top][image][url]"
                                        data-image-preview-select="filePreview-slider-footer-top-image-url"
                                        onchange="showPreview('footer-top-image-url');">
                                    <option value="">none</option>
                                    @foreach($azuriomImages as $image)
                                        <option value="{{ $image->file }}"
                                                @if(config('theme.footer.top.image.url') == $image->file) selected @endif>{{ $image->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-3 w-100" style="height: 100px; {{config('theme.footer.top.image.url') ?? 'display: none'}}">
                                <img id="img-preview-footer-top-image-url" style="object-fit: contain;" class="w-100 h-100" src="{{config('theme.footer.top.image.url') ? image_url(old('footer-top-image-url', config('theme.footer.top.image.url'))):''}}" alt="">
                            </div>
                            @error('footer-top-image-url')
                            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                            @enderror
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label m-0" for="footer-top-image-description">{{trans('theme::admin.description_of_image')}}</label>
                            <input type="text" class="form-control @error('footer-top-image-description') is-invalid @enderror" description="footer-top-image-description" name="footer[top][image][description]" value="{{old('footer-top-image-description', config('theme.footer.top.image.description'))}}" aria-describedby="footer-top-image-description-Label">
                            @error('footer-top-image-description')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex gap-4">
                        <div class="w-50">
                            <div class="form-group">
                                <label for="footer-top-image-height" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.height')}}</label>
                                <div class="d-flex align-center gap-2">
                                    <output>{{ old('footer-top-image-height', config('theme.footer.top.image.height')) ?? '50' }}</output>
                                    <input id="footer-top-image-height" name="footer[top][image][height]" type="range" min="1" max="500" step="1" class="form-range @error('footer-top-image-height') is-invalid @enderror" value="{{ old('footer-top-image-height', config('theme.footer.top.image.height')) ?? '50' }}" aria-describedby="footer-top-image-height" oninput="this.previousElementSibling.value = this.value">
                                </div>
                                @error('footer-top-image-height')
                                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                                @enderror
                            </div>
                        </div>
                        <div class="w-50">
                            <div class="form-group">
                                <label for="footer-top-image-width" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.width')}}</label>
                                <div class="d-flex align-center gap-2">
                                    <output>{{ old('footer-top-image-width', config('theme.footer.top.image.width')) ?? '50' }}</output>
                                    <input id="footer-top-image-width" name="footer[top][image][width]" type="range" min="1" max="500" step="1" class="form-range @error('footer-top-image-width') is-invalid @enderror" value="{{ old('footer-top-image-width', config('theme.footer.top.image.width')) ?? '50' }}" aria-describedby="footer-top-image-width" oninput="this.previousElementSibling.value = this.value">
                                </div>
                                @error('footer-top-image-width')
                                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="w-100">
                <span class="fw-bold">{{trans('theme::admin.add_customs_links')}}</span>
                <div class="d-flex justify-content-between mt-4">
                    <span>{{trans('theme::admin.text')}}</span>
                    <span>{{trans('theme::admin.link')}}</span>
                    <span>{{trans('theme::admin.new_page')}}</span>
                </div>
                <div id="footer-top-links-wrapper">
                    @for($i = 1; $i <= 8; $i++)
                        <div id="footer-top-links-{{$i}}" class="d-flex flex-column mt-2">
                            <div class="d-flex gap-3 align-items-center">
                                <input type="text" class="form-control w-50 @error('footer-top-links-'.$i.'.-text') is-invalid @enderror" title="footer-top-links-{{$i}}-text" name="footer[top][links][{{$i}}][text]" value="{{old('footer-top-links-'.$i.'-text', config('theme.footer.top.links.'.$i.'.text'))}}" aria-describedby="footer-top-title-Label">
                                <input type="url" class="form-control w-50 @error('footer-top-links-'.$i.'-url') is-invalid @enderror" title="footer-top-links-{{$i}}-url" name="footer[top][links][{{$i}}][url]" value="{{old('footer-top-links-'.$i.'-url', config('theme.footer.top.links.'.$i.'.url'))}}" aria-describedby="footer-top-title-Label">
                                <div class="switcher">
                                    <label for="footer-top-links-{{$i}}-active">
                                        <input type="checkbox" id="footer-top-links-{{$i}}-active" name="footer[top][links][{{$i}}][active]" @if(config('theme.footer.top.links.'.$i.'.active')) checked @endif @error('footer-top-links-'.$i.'-active') is-invalid @enderror/>
                                        <span><small></small></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </fieldset>
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-primary text-white text-lg">{{trans('theme::admin.bottom')}}</legend>
            <div class="w-100">
                <span class="fw-bold">{{trans('theme::admin.add_customs_links')}}</span>
                <div class="d-flex justify-content-between mt-4">
                    <span>{{trans('theme::admin.text')}}</span>
                    <span>{{trans('theme::admin.link')}}</span>
                    <span>{{trans('theme::admin.new_page')}}</span>
                </div>
                <div id="footer-bottom-links-wrapper">
                    @for($i = 1; $i <= 4; $i++)
                        <div id="footer-bottom-links-{{$i}}" class="d-flex flex-column mt-2">
                            <div class="d-flex gap-3 align-items-center">
                                <input type="text" class="form-control w-50 @error('footer-bottom-links-'.$i.'.-text') is-invalid @enderror" title="footer-bottom-links-{{$i}}-text" name="footer[bottom][links][{{$i}}][text]" value="{{old('footer-bottom-links-'.$i.'-text', config('theme.footer.bottom.links.'.$i.'.text'))}}" aria-describedby="footer-bottom-title-Label">
                                <input type="url" class="form-control w-50 @error('footer-bottom-links-'.$i.'-url') is-invalid @enderror" title="footer-bottom-links-{{$i}}-url" name="footer[bottom][links][{{$i}}][url]" value="{{old('footer-bottom-links-'.$i.'-url', config('theme.footer.bottom.links.'.$i.'.url'))}}" aria-describedby="footer-bottom-title-Label">
                                <div class="switcher">
                                    <label for="footer-bottom-links-{{$i}}-active">
                                        <input type="checkbox" id="footer-bottom-links-{{$i}}-active" name="footer[bottom][links][{{$i}}][active]" @if(config('theme.footer.bottom.links.'.$i.'.active')) checked @endif @error('footer-bottom-links-'.$i.'-active') is-invalid @enderror/>
                                        <span><small></small></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </fieldset>
</div>
