<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-primary text-white text-lg">{{trans('theme::admin.trailer')}}</legend>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>
            <label for="home-trailer-toggle">
                <input type="checkbox" id="home-trailer-toggle" name="home[trailer][toggle]" @if(config('theme.home.trailer.toggle')) checked @endif @error('home-trailer-toggle') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        @error('home-trailer-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
    <div id="home-trailer-url" class="d-flex flex-column flex-md-row mt-2">
        <div class="w-50">
            <label for="home-trailer-url">{{trans('theme::admin.url')}}</label>
            <input type="text" placeholder="https://www.youtube.com/embed/Xu5P6a7EWYg?si=hKwTgUydqz84O3ch" class="form-control w-50 @error('home-trailer-url') is-invalid @enderror" title="home-trailer-url" name="home[trailer][url]" value="{{old('home-trailer-url', config('theme.home.trailer.url'))}}" aria-describedby="home-trailer-url-Label">
        </div>
        <div class="flex-grow-1 d-flex flex-column">
            <div>
                <label for="home-trailer-title">{{trans('theme::admin.title')}}</label>
                <input type="text" class="form-control w-50 @error('home-trailer-title') is-invalid @enderror" title="home-trailer-title" name="home[trailer][title]" value="{{old('home-trailer-title', config('theme.home.trailer.title'))}}" aria-describedby="home-trailer-title-Label">
            </div>
            <div>
                <div class="w-100">
                    <label class="form-label m-0" for="home-trailer-paragraph">{{trans('theme::admin.paragraph')}}</label>
                    <textarea type="textaera" class="form-control @error('home-trailer-paragraph') is-invalid @enderror" id="home-trailer-paragraph" name="home[trailer][paragraph]" aria-describedby="home-trailer-paragraph-Label">{{ config('theme.home.trailer.paragraph') ? old('trailer.paragraph', config('theme.home.trailer.paragraph')):'' }}</textarea>
                    @error('home-trailer-paragraph')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-primary text-white text-lg">{{trans('theme::admin.articles')}}</legend>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>
            <label for="home-news-toggle">
                <input type="checkbox" id="home-news-toggle" name="home[news][toggle]" @if(config('theme.home.news.toggle')) checked @endif @error('home-news-toggle') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        @error('home-news-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>

    <div>
        <label for="home-news-title">{{trans('theme::admin.title')}}</label>
        <input type="text" class="form-control w-50 @error('home-news-title') is-invalid @enderror" title="home-news-title" name="home[news][title]" value="{{old('home-news-title', config('theme.home.news.title'))}}" aria-describedby="home-news-title-Label">
    </div>

</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-primary text-white text-lg">{{trans('theme::admin.about_us')}}</legend>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>
            <label for="home-about_us-toggle">
                <input type="checkbox" id="home-about_us-toggle" name="home[about_us][toggle]" @if(config('theme.home.about_us.toggle')) checked @endif @error('home-about_us-toggle') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        @error('home-about_us-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.image')}}</legend>
        <div class="d-flex gap-4">
            <div class="form-group">
                <label for="home-about_us-image-url" class="form-label fw-bold m-0">{{trans('theme::admin.image')}}</label>
                <div class="d-flex align-center">
                    <a class=" input-group-text text-success" href="{{ route('admin.images.create') }}" title="Upload a image"  target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-upload"></i>
                    </a>
                    <select class="form-select"
                            id="home-about_us-image-url"
                            name="home[about_us][image][url]"
                            data-image-preview-select="filePreview-slider-home-about_us-image-url"
                            onchange="showPreview('home-about_us-image-url');">
                        <option value="">none</option>
                        @foreach($azuriomImages as $image)
                            <option value="{{ $image->file }}"
                                    @if(config('theme.home.about_us.image.url') == $image->file) selected @endif>{{ $image->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3 w-100" style="height: 100px; {{config('theme.home.about_us.image.url') ?? 'display: none'}}">
                    <img id="img-preview-home-about_us-image-url" style="object-fit: contain;" class="w-100 h-100" src="{{config('theme.home.about_us.image.url') ? image_url(old('home-about_us-image-url', config('theme.home.about_us.image.url'))):''}}" alt="">
                </div>
                @error('home-about_us-image-url')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="flex-grow-1">
                <label class="form-label m-0" for="home-about_us-image-alt">{{trans('theme::admin.description_of_image')}}</label>
                <input type="text" class="form-control @error('home-about_us-image-alt') is-invalid @enderror" alt="home-about_us-image-alt" name="home[about_us][image][alt]" value="{{old('home-about_us-image-alt', config('theme.home.about_us.image.alt'))}}" aria-describedby="home-about_us-image-alt-Label">
                @error('home-about_us-image-alt')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="d-flex gap-4">
            <div class="w-50">
                <div class="form-group">
                    <label for="home-about_us-image-height" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.height')}}</label>
                    <div class="d-flex align-center gap-2">
                        <output>{{ old('home-about_us-image-height', config('theme.home.about_us.image.height')) ?? '200' }}</output>
                        <input id="home-about_us-image-height" name="home[about_us][image][height]" type="range" min="1" max="800" step="1" class="form-range @error('home-about_us-image-height') is-invalid @enderror" value="{{ old('home-about_us-image-height', config('theme.home.about_us.image.height')) ?? '200' }}" aria-describedby="home-about_us-image-height" oninput="this.previousElementSibling.value = this.value">
                    </div>
                    @error('home-about_us-image-height')
                    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                    @enderror
                </div>
            </div>
            <div class="w-50">
                <div class="form-group">
                    <label for="home-about_us-image-width" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.width')}}</label>
                    <div class="d-flex align-center gap-2">
                        <output>{{ old('home-about_us-image-width', config('theme.home.about_us.image.width')) ?? '200' }}</output>
                        <input id="home-about_us-image-width" name="home[about_us][image][width]" type="range" min="1" max="800" step="1" class="form-range @error('home-about_us-image-width') is-invalid @enderror" value="{{ old('home-about_us-image-width', config('theme.home.about_us.image.width')) ?? '200' }}" aria-describedby="home-about_us-image-width" oninput="this.previousElementSibling.value = this.value">
                    </div>
                    @error('home-about_us-image-width')
                    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                    @enderror
                </div>
            </div>
        </div>
    </fieldset>


    <div id="home-about_us-url" class="d-flex flex-column flex-md-row mt-2">
        <div class="flex-grow-1 d-flex flex-column">
            <div>
                <label for="home-about_us-title">{{trans('theme::admin.title')}}</label>
                <input type="text" class="form-control w-50 @error('home-about_us-title') is-invalid @enderror" title="home-about_us-title" name="home[about_us][title]" value="{{old('home-about_us-title', config('theme.home.about_us.title'))}}" aria-describedby="home-about_us-title-Label">
            </div>
            <div>
                <div class="w-100">
                    <label class="form-label m-0" for="home-about_us-paragraph">{{trans('theme::admin.paragraph')}}</label>
                    <textarea type="textaera" class="form-control @error('home-about_us-paragraph') is-invalid @enderror" id="home-about_us-paragraph" name="home[about_us][paragraph]" aria-describedby="home-about_us-paragraph-Label">{{ config('theme.home.about_us.paragraph') ? old('about_us.paragraph', config('theme.home.about_us.paragraph')):'' }}</textarea>
                    @error('home-about_us-paragraph')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.button')}}</legend>
        <div id="home-about_us-link" class="d-flex flex-column">
            <div class="d-flex justify-content-between mt-1">
                <span>{{trans('theme::admin.text')}}</span>
                <span>{{trans('theme::admin.link')}}</span>
                <span>{{trans('theme::admin.new_page')}}</span>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <input type="text" class="form-control w-50 @error('home-about_us-link-text') is-invalid @enderror" title="home-about_us-link-text" name="home[about_us][link][text]" value="{{old('home-about_us-link-text', config('theme.home.about_us.link.text'))}}" aria-describedby="home-about_us-text-Label">
                <input type="url" class="form-control w-50 @error('home-about_us-link-url') is-invalid @enderror" title="home-about_us-link-url" name="home[about_us][link][url]" value="{{old('home-about_us-link-url', config('theme.home.about_us.link.url'))}}" aria-describedby="home-about_us-link-Label">
                <div class="switcher">
                    <label for="home-about_us-link-blank">
                        <input type="checkbox" id="home-about_us-link-blank" name="home[about_us][link][blank]" @if(config('theme.home.about_us.link.blank')) checked @endif @error('home-about_us-link-blank') is-invalid @enderror/>
                        <span><small></small></span>
                    </label>
                </div>
            </div>
        </div>
    </fieldset>

</fieldset>
{{--<fieldset class="d-flex flex-column gap-3 border p-2 w-100">--}}
{{--    <legend class="float-none w-auto p-2 py-0 bg-primary text-white text-lg">{{trans('theme::admin.image_or_text')}}</legend>--}}
{{--    <div class="form-check p-0">--}}
{{--        <div class="switcher">--}}
{{--            <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>--}}
{{--            <label for="home-image_or_text-toggle">--}}
{{--                <input type="checkbox" id="home-image_or_text-toggle" name="home[image_or_text][toggle]" @if(config('theme.home.image_or_text.toggle')) checked @endif @error('home-image_or_text-toggle') is-invalid @enderror/>--}}
{{--                <span><small></small></span>--}}
{{--            </label>--}}
{{--        </div>--}}
{{--        @error('home-image_or_text-toggle')--}}
{{--        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>--}}
{{--        @enderror--}}
{{--    </div>--}}

{{--    <div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="home-image_or_text-amount" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.amount')}}</label>--}}
{{--            <div class="d-flex align-center gap-2">--}}
{{--                <output>{{ old('home-image_or_text-amount', config('theme.home.image_or_text.image.amount')) ?? '1' }}</output>--}}
{{--                <input id="home-image_or_text-amount" name="home[image_or_text][amount]" type="range" min="1" max="8" step="1" class="form-range @error('home-image_or_text-amount') is-invalid @enderror" value="{{ old('home-image_or_text-amount', config('theme.home.top.image.amount')) ?? '1' }}" aria-describedby="home-image_or_text-amount" oninput="this.previousElementSibling.value = this.value">--}}
{{--            </div>--}}
{{--            @error('home-image_or_text-amount')--}}
{{--            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>--}}
{{--            @enderror--}}
{{--        </div>--}}
{{--    </div>--}}

{{--</fieldset>--}}
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-primary text-white text-lg">{{trans('theme::admin.more_information')}}</legend>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>
            <label for="home-more_information-toggle">
                <input type="checkbox" id="home-more_information-toggle" name="home[more_information][toggle]" @if(config('theme.home.more_information.toggle')) checked @endif @error('home-more_information-toggle') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        @error('home-more_information-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.image')}}</legend>
        <div class="d-flex gap-4">
            <div class="form-group">
                <label for="home-more_information-image-url" class="form-label fw-bold m-0">{{trans('theme::admin.image')}}</label>
                <div class="d-flex align-center">
                    <a class=" input-group-text text-success" href="{{ route('admin.images.create') }}" title="Upload a image"  target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-upload"></i>
                    </a>
                    <select class="form-select"
                            id="home-more_information-image-url"
                            name="home[more_information][image][url]"
                            data-image-preview-select="filePreview-slider-home-more_information-image-url"
                            onchange="showPreview('home-more_information-image-url');">
                        <option value="">none</option>
                        @foreach($azuriomImages as $image)
                            <option value="{{ $image->file }}"
                                    @if(config('theme.home.more_information.image.url') == $image->file) selected @endif>{{ $image->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3 w-100" style="height: 100px; {{config('theme.home.more_information.image.url') ?? 'display: none'}}">
                    <img id="img-preview-home-more_information-image-url" style="object-fit: contain;" class="w-100 h-100" src="{{config('theme.home.more_information.image.url') ? image_url(old('home-more_information-image-url', config('theme.home.more_information.image.url'))):''}}" alt="">
                </div>
                @error('home-more_information-image-url')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="flex-grow-1">
                <label class="form-label m-0" for="home-more_information-image-alt">{{trans('theme::admin.description_of_image')}}</label>
                <input type="text" class="form-control @error('home-more_information-image-alt') is-invalid @enderror" alt="home-more_information-image-alt" name="home[more_information][image][alt]" value="{{old('home-more_information-image-alt', config('theme.home.more_information.image.alt'))}}" aria-describedby="home-more_information-image-alt-Label">
                @error('home-more_information-image-alt')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="d-flex gap-4">
            <div class="w-50">
                <div class="form-group">
                    <label for="home-more_information-image-height" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.height')}}</label>
                    <div class="d-flex align-center gap-2">
                        <output>{{ old('home-more_information-image-height', config('theme.home.more_information.image.height')) ?? '200' }}</output>
                        <input id="home-more_information-image-height" name="home[more_information][image][height]" type="range" min="1" max="800" step="1" class="form-range @error('home-more_information-image-height') is-invalid @enderror" value="{{ old('home-more_information-image-height', config('theme.home.more_information.image.height')) ?? '200' }}" aria-describedby="home-more_information-image-height" oninput="this.previousElementSibling.value = this.value">
                    </div>
                    @error('home-more_information-image-height')
                    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                    @enderror
                </div>
            </div>
            <div class="w-50">
                <div class="form-group">
                    <label for="home-more_information-image-width" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.width')}}</label>
                    <div class="d-flex align-center gap-2">
                        <output>{{ old('home-more_information-image-width', config('theme.home.more_information.image.width')) ?? '200' }}</output>
                        <input id="home-more_information-image-width" name="home[more_information][image][width]" type="range" min="1" max="800" step="1" class="form-range @error('home-more_information-image-width') is-invalid @enderror" value="{{ old('home-more_information-image-width', config('theme.home.more_information.image.width')) ?? '200' }}" aria-describedby="home-more_information-image-width" oninput="this.previousElementSibling.value = this.value">
                    </div>
                    @error('home-more_information-image-width')
                    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                    @enderror
                </div>
            </div>
        </div>
    </fieldset>


    <div id="home-more_information-url" class="d-flex flex-column flex-md-row mt-2">
        <div class="flex-grow-1 d-flex flex-column">
            <div>
                <label for="home-more_information-title">{{trans('theme::admin.title')}}</label>
                <input type="text" class="form-control w-50 @error('home-more_information-title') is-invalid @enderror" title="home-more_information-title" name="home[more_information][title]" value="{{old('home-more_information-title', config('theme.home.more_information.title'))}}" aria-describedby="home-more_information-title-Label">
            </div>
            <div>
                <div class="w-100">
                    <label class="form-label m-0" for="home-more_information-paragraph">{{trans('theme::admin.paragraph')}}</label>
                    <textarea type="textaera" class="form-control @error('home-more_information-paragraph') is-invalid @enderror" id="home-more_information-paragraph" name="home[more_information][paragraph]" aria-describedby="home-more_information-paragraph-Label">{{ config('theme.home.more_information.paragraph') ? old('more_information.paragraph', config('theme.home.more_information.paragraph')):'' }}</textarea>
                    @error('home-more_information-paragraph')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.button')}}</legend>
        <div id="home-more_information-link" class="d-flex flex-column">
            <div class="d-flex justify-content-between mt-1">
                <span>{{trans('theme::admin.text')}}</span>
                <span>{{trans('theme::admin.link')}}</span>
                <span>{{trans('theme::admin.new_page')}}</span>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <input type="text" class="form-control w-50 @error('home-more_information-link-text') is-invalid @enderror" title="home-more_information-link-text" name="home[more_information][link][text]" value="{{old('home-more_information-link-text', config('theme.home.more_information.link.text'))}}" aria-describedby="home-more_information-text-Label">
                <input type="url" class="form-control w-50 @error('home-more_information-link-url') is-invalid @enderror" title="home-more_information-link-url" name="home[more_information][link][url]" value="{{old('home-more_information-link-url', config('theme.home.more_information.link.url'))}}" aria-describedby="home-more_information-link-Label">
                <div class="switcher">
                    <label for="home-more_information-link-blank">
                        <input type="checkbox" id="home-more_information-link-blank" name="home[more_information][link][blank]" @if(config('theme.home.more_information.link.blank')) checked @endif @error('home-more_information-link-blank') is-invalid @enderror/>
                        <span><small></small></span>
                    </label>
                </div>
            </div>
        </div>
    </fieldset>

</fieldset>
{{--<fieldset class="d-flex flex-column gap-3 border p-2 w-100">--}}
{{--    <legend class="float-none w-auto p-2 py-0 bg-primary text-white text-lg">{{trans('theme::admin.stats')}}</legend>--}}
{{--    <div class="form-check p-0">--}}
{{--        <div class="switcher">--}}
{{--            <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>--}}
{{--            <label for="home-stats-toggle">--}}
{{--                <input type="checkbox" id="home-stats-toggle" name="home[stats][toggle]" @if(config('theme.home.stats.toggle')) checked @endif @error('home-stats-toggle') is-invalid @enderror/>--}}
{{--                <span><small></small></span>--}}
{{--            </label>--}}
{{--        </div>--}}
{{--        @error('home-stats-toggle')--}}
{{--        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>--}}
{{--        @enderror--}}
{{--    </div>--}}

{{--</fieldset>--}}
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-primary text-white text-lg">{{trans('theme::admin.support_us')}}</legend>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.dont_show')}}</small>
            <label for="home-support_us-toggle">
                <input type="checkbox" id="home-support_us-toggle" name="home[support_us][toggle]" @if(config('theme.home.support_us.toggle')) checked @endif @error('home-support_us-toggle') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        @error('home-support_us-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.image')}}</legend>
        <div class="d-flex gap-4">
            <div class="form-group">
                <label for="home-support_us-image-url" class="form-label fw-bold m-0">{{trans('theme::admin.image')}}</label>
                <div class="d-flex align-center">
                    <a class=" input-group-text text-success" href="{{ route('admin.images.create') }}" title="Upload a image"  target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-upload"></i>
                    </a>
                    <select class="form-select"
                            id="home-support_us-image-url"
                            name="home[support_us][image][url]"
                            data-image-preview-select="filePreview-slider-home-support_us-image-url"
                            onchange="showPreview('home-support_us-image-url');">
                        <option value="">none</option>
                        @foreach($azuriomImages as $image)
                            <option value="{{ $image->file }}"
                                    @if(config('theme.home.support_us.image.url') == $image->file) selected @endif>{{ $image->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3 w-100" style="height: 100px; {{config('theme.home.support_us.image.url') ?? 'display: none'}}">
                    <img id="img-preview-home-support_us-image-url" style="object-fit: contain;" class="w-100 h-100" src="{{config('theme.home.support_us.image.url') ? image_url(old('home-support_us-image-url', config('theme.home.support_us.image.url'))):''}}" alt="">
                </div>
                @error('home-support_us-image-url')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
            </div>
            <div class="flex-grow-1">
                <label class="form-label m-0" for="home-support_us-image-alt">{{trans('theme::admin.description_of_image')}}</label>
                <input type="text" class="form-control @error('home-support_us-image-alt') is-invalid @enderror" alt="home-support_us-image-alt" name="home[support_us][image][alt]" value="{{old('home-support_us-image-alt', config('theme.home.support_us.image.alt'))}}" aria-describedby="home-support_us-image-alt-Label">
                @error('home-support_us-image-alt')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
        <div class="d-flex gap-4">
            <div class="w-50">
                <div class="form-group">
                    <label for="home-support_us-image-height" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.height')}}</label>
                    <div class="d-flex align-center gap-2">
                        <output>{{ old('home-support_us-image-height', config('theme.home.support_us.image.height')) ?? '200' }}</output>
                        <input id="home-support_us-image-height" name="home[support_us][image][height]" type="range" min="1" max="800" step="1" class="form-range @error('home-support_us-image-height') is-invalid @enderror" value="{{ old('home-support_us-image-height', config('theme.home.support_us.image.height')) ?? '200' }}" aria-describedby="home-support_us-image-height" oninput="this.previousElementSibling.value = this.value">
                    </div>
                    @error('home-support_us-image-height')
                    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                    @enderror
                </div>
            </div>
            <div class="w-50">
                <div class="form-group">
                    <label for="home-support_us-image-width" class="form-label fw-bold m-0 mt-2">{{trans('theme::admin.width')}}</label>
                    <div class="d-flex align-center gap-2">
                        <output>{{ old('home-support_us-image-width', config('theme.home.support_us.image.width')) ?? '200' }}</output>
                        <input id="home-support_us-image-width" name="home[support_us][image][width]" type="range" min="1" max="800" step="1" class="form-range @error('home-support_us-image-width') is-invalid @enderror" value="{{ old('home-support_us-image-width', config('theme.home.support_us.image.width')) ?? '200' }}" aria-describedby="home-support_us-image-width" oninput="this.previousElementSibling.value = this.value">
                    </div>
                    @error('home-support_us-image-width')
                    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                    @enderror
                </div>
            </div>
        </div>
    </fieldset>


    <div id="home-support_us-url" class="d-flex flex-column flex-md-row mt-2">
        <div class="flex-grow-1 d-flex flex-column">
            <div>
                <label for="home-support_us-title">{{trans('theme::admin.title')}}</label>
                <input type="text" class="form-control w-50 @error('home-support_us-title') is-invalid @enderror" title="home-support_us-title" name="home[support_us][title]" value="{{old('home-support_us-title', config('theme.home.support_us.title'))}}" aria-describedby="home-support_us-title-Label">
            </div>
            <div>
                <div class="w-100">
                    <label class="form-label m-0" for="home-support_us-paragraph">{{trans('theme::admin.paragraph')}}</label>
                    <textarea type="textaera" class="form-control @error('home-support_us-paragraph') is-invalid @enderror" id="home-support_us-paragraph" name="home[support_us][paragraph]" aria-describedby="home-support_us-paragraph-Label">{{ config('theme.home.support_us.paragraph') ? old('support_us.paragraph', config('theme.home.support_us.paragraph')):'' }}</textarea>
                    @error('home-support_us-paragraph')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.button')}}</legend>
        <div id="home-support_us-link" class="d-flex flex-column">
            <div class="d-flex justify-content-between mt-1">
                <span>{{trans('theme::admin.text')}}</span>
                <span>{{trans('theme::admin.link')}}</span>
                <span>{{trans('theme::admin.new_page')}}</span>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <input type="text" class="form-control w-50 @error('home-support_us-link-text') is-invalid @enderror" title="home-support_us-link-text" name="home[support_us][link][text]" value="{{old('home-support_us-link-text', config('theme.home.support_us.link.text'))}}" aria-describedby="home-support_us-text-Label">
                <input type="url" class="form-control w-50 @error('home-support_us-link-url') is-invalid @enderror" title="home-support_us-link-url" name="home[support_us][link][url]" value="{{old('home-support_us-link-url', config('theme.home.support_us.link.url'))}}" aria-describedby="home-support_us-link-Label">
                <div class="switcher">
                    <label for="home-support_us-link-blank">
                        <input type="checkbox" id="home-support_us-link-blank" name="home[support_us][link][blank]" @if(config('theme.home.support_us.link.blank')) checked @endif @error('home-support_us-link-blank') is-invalid @enderror/>
                        <span><small></small></span>
                    </label>
                </div>
            </div>
        </div>
    </fieldset>

</fieldset>
