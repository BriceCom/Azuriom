<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">BOX</legend>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.show')}}</small>
            <label for="event-box-toggle">
                <input type="checkbox" id="event-box-toggle" name="event[box][toggle]" @if(config('theme.event.box.toggle')) checked @endif @error('event-box-toggle') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        @error('event-box-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
    <div class="d-flex gap-1">
        <div class=" w-100">
            <label class="form-label m-0" for="event-box-icon">{{trans('theme::admin.icon')}}</label>
            <input type="text" placeholder="bi bi-box" class="form-control @error('event-box-icon') is-invalid @enderror" id="event-box-icon" name="event[box][icon]" value="{{old('event-box-icon', config('theme.event.box.icon'))}}" aria-describedby="event-box-icon-Label">
            @error('event-box-icon')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class=" w-100">
            <label class="form-label m-0" for="event-box-title">{{trans('theme::admin.title')}}</label>
            <input type="text" class="form-control @error('event-box-title') is-invalid @enderror" id="event-box-title" name="event[box][title]" value="{{old('event-box-title', config('theme.event.box.title'))}}" aria-describedby="event-box-title-Label">
            @error('event-box-title')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class=" w-100">
            <label class="form-label m-0" for="event-box-paragraph">{{trans('theme::admin.paragraph')}}</label>
            <textarea type="textaera" class="form-control @error('event-box-paragraph') is-invalid @enderror" id="event-box-paragraph" name="event[box][paragraph]" aria-describedby="whatsAdventure-block4-paragraph-Label">{{old('event-box-paragraph', config('theme.event.box.paragraph'))}}</textarea>
            @error('event-box-paragraph')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="d-flex flex-column gap-1">
        <div class="form-check p-0">
            <div class="switcher">
                <small class="fw-bold fs-5">{{trans('theme::admin.show')}} {{trans('theme::admin.button')}}</small>
                <label for="event-box-togglelink">
                    <input type="checkbox" id="event-box-togglelink" name="event[box][togglelink]" @if(config('theme.event.box.togglelink')) checked @endif @error('event-box-togglelink') is-invalid @enderror/>
                    <span><small></small></span>
                </label>
            </div>
            @error('event-box-togglelink')
            <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
            @enderror
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <div class=" w-25">
                <label class="form-label m-0" for="event-box-iconlink">{{trans('theme::admin.icon')}}</label>
                <input type="text" placeholder="bi bi-box" class="form-control @error('event-box-iconlink') is-invalid @enderror" id="event-box-iconlink" name="event[box][iconlink]" value="{{old('event-box-iconlink', config('theme.event.box.iconlink'))}}" aria-describedby="event-box-iconlink-Label">
                @error('event-box-iconlink')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class=" w-25">
                <label class="form-label m-0" for="event-box-textlink">{{trans('theme::admin.text')}}</label>
                <input type="text" class="form-control @error('event-box-textlink') is-invalid @enderror" id="event-box-textlink" name="event[box][textlink]" value="{{old('event-box-textlink', config('theme.event.box.textlink'))}}" aria-describedby="event-box-textlink-Label">
                @error('event-box-textlink')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class=" w-25">
                <label class="form-label m-0" for="event-box-urllink">{{trans('theme::admin.url')}}</label>
                <input type="text" class="form-control @error('event-box-urllink') is-invalid @enderror" id="event-box-urllink" name="event[box][urllink]" value="{{old('event-box-urllink', config('theme.event.box.urllink'))}}" aria-describedby="event-box-urllink-Label">
                @error('event-box-urllink')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
        </div>
    </div>
</fieldset>
