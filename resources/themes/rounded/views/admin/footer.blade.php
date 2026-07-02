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
    <div class="d-flex flex-column flex-md-row">
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.left')}}</legend>
            <div class=" w-100">
                <label class="form-label m-0" for="footer-left-title">{{trans('theme::admin.title')}}</label>
                <input type="text" class="form-control @error('footer-left-title') is-invalid @enderror" title="footer-left-title" name="footer[left][title]" value="{{old('footer-left-title', config('theme.footer.left.title'))}}" aria-describedby="footer-left-title-Label">
                @error('footer-left-title')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class=" w-100">
                <label class="form-label m-0" for="footer-left-paragraph">{{trans('theme::admin.paragraph')}}</label>
                <textarea type="textaera" class="form-control @error('footer-left-paragraph') is-invalid @enderror" id="footer-left-paragraph" name="footer[left][paragraph]" aria-describedby="whatsAdventure-footer4-text-Label">{{old('footer-left-paragraph', config('theme.footer.left.paragraph'))}}</textarea>
                @error('footer-left-paragraph')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </fieldset>
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.middle')}}</legend>
            <div class=" w-100">
                <label class="form-label m-0" for="footer-middle-title">{{trans('theme::admin.title')}}</label>
                <input type="text" class="form-control @error('footer-middle-title') is-invalid @enderror" title="footer-middle-title" name="footer[middle][title]" value="{{old('footer-middle-title', config('theme.footer.middle.title'))}}" aria-describedby="footer-middle-title-Label">
                @error('footer-middle-title')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="w-100">
                <div class="switcher">
                    <small class="fw-bold fs-5">{{trans('theme::admin.form.footer.middle.showing_socials')}}</small>
                    <label for="footer-middle-socials-active">
                        <input type="checkbox" id="footer-middle-socials-active" name="footer[middle][socials][active]" @if(config('theme.footer.middle.socials.active')) checked @endif @error('footer-middle-socials-active') is-invalid @enderror/>
                        <span><small></small></span>
                    </label>
                </div>
                @error('footer-middle-socials')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <hr>
            <div class="w-100">
                <span class="fw-bold">{{trans('theme::admin.add_customs_links')}}</span>
                <div class="d-flex justify-content-between mt-4">
                    <span>{{trans('theme::admin.text')}}</span>
                    <span>{{trans('theme::admin.link')}}</span>
                    <span>{{trans('theme::admin.new_page')}}</span>
                </div>
                <div id="footer-middle-links-wrapper">
                    @for($i = 1; $i <= 6; $i++)
                        <div id="footer-middle-links-{{$i}}" class="d-flex flex-column mt-2">
                            <div class="d-flex gap-3 align-items-center">
                                <input type="text" class="form-control w-50 @error('footer-middle-links-'.$i.'.-text') is-invalid @enderror" title="footer-middle-links-{{$i}}-text" name="footer[middle][links][{{$i}}][text]" value="{{old('footer-middle-links-'.$i.'-text', config('theme.footer.middle.links.'.$i.'.text'))}}" aria-describedby="footer-middle-title-Label">
                                <input type="url" class="form-control w-50 @error('footer-middle-links-'.$i.'-url') is-invalid @enderror" title="footer-middle-links-{{$i}}-url" name="footer[middle][links][{{$i}}][url]" value="{{old('footer-middle-links-'.$i.'-url', config('theme.footer.middle.links.'.$i.'.url'))}}" aria-describedby="footer-middle-title-Label">
                                <div class="switcher">
                                    <label for="footer-middle-links-{{$i}}-active">
                                        <input type="checkbox" id="footer-middle-links-{{$i}}-active" name="footer[middle][links][{{$i}}][active]" @if(config('theme.footer.middle.links.'.$i.'.active')) checked @endif @error('footer-middle-links-'.$i.'-active') is-invalid @enderror/>
                                        <span><small></small></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
            <hr>
            <div class=" w-100">
                <div class="switcher">
                    <small class="fw-bold fs-5">{{trans('theme::admin.form.footer.middle.showing_serveurliste')}}</small>
                    <label for="footer-middle-serveurliste-active">
                        <input type="checkbox" id="footer-middle-serveurliste-active" name="footer[middle][serveurliste][active]" @if(config('theme.footer.middle.serveurliste.active')) checked @endif @error('footer-middle-serveurliste-active') is-invalid @enderror/>
                        <span><small></small></span>
                    </label>
                </div>
                @error('footer-middle-serveurliste')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </fieldset>
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.right')}}</legend>
            <div class=" w-100">
                <label class="form-label m-0" for="footer-right-title">{{trans('theme::admin.title')}}</label>
                <input type="text" class="form-control @error('footer-right-title') is-invalid @enderror" title="footer-right-title" name="footer[right][title]" value="{{old('footer-right-title', config('theme.footer.right.title'))}}" aria-describedby="footer-right-title-Label">
                @error('footer-right-title')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class=" w-100">
                <label class="form-label m-0" for="footer-right-paragraph">{{trans('theme::admin.paragraph')}}</label>
                <textarea type="textaera" class="form-control @error('footer-right-paragraph') is-invalid @enderror" id="footer-right-text" name="footer[right][paragraph]" aria-describedby="whatsAdventure-footer4-text-Label">{{old('footer-right-paragraph', config('theme.footer.right.paragraph'))}}</textarea>
                @error('footer-right-paragraph')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.button')}}</legend>
                <div class="switcher">
                    <small class="fw-bold fs-5">{{trans('theme::admin.other_page')}}</small>
                    <label for="footer-right-blank">
                        <input type="checkbox" id="footer-right-blank" name="footer[right][blank]" @if(config('theme.footer.right.blank')) checked @endif @error('footer-right-blank') is-invalid @enderror/>
                        <span><small></small></span>
                    </label>
                </div>
                @error('footer-right-blank')
                <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
                @enderror
                <div class="form-group">
                    <label class="form-label m-0" for="footer-right-text">{{trans('theme::admin.text')}}</label>
                    <input type="text" class="form-control @error('footer-right-text') is-invalid @enderror" title="footer-right-text" name="footer[right][text]" value="{{old('footer-right-text', config('theme.footer.right.text'))}}" aria-describedby="footer-right-text-Label">
                    @error('footer-right-text')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label m-0" for="footer-right-url">{{trans('theme::admin.url')}}</label>
                    <input type="text" class="form-control @error('footer-right-url') is-invalid @enderror" title="footer-right-url" name="footer[right][url]" value="{{old('footer-right-url', config('theme.footer.right.url'))}}" aria-describedby="footer-right-url-Label">
                    @error('footer-right-url')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </fieldset>
        </fieldset>
    </div>

</div>
