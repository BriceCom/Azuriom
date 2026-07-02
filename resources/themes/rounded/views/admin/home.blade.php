<div class="form-check p-0">
    <div class="switcher">
        <small class="fw-bold fs-5">{{trans('theme::admin.servers_show')}}</small>
        <label for="servers-toggle">
            <input type="checkbox" id="servers-toggle" name="servers[toggle]" @if(config('theme.servers.toggle')) checked @endif @error('servers-toggle') is-invalid @enderror/>
            <span><small></small></span>
        </label>
    </div>
    @error('servers-toggle')
    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
    @enderror
</div>


<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.stats')}}</legend>
    <div class="form-check p-0">
        <div class="switcher">
            <small class="fw-bold fs-5">{{trans('theme::admin.show')}}</small>
            <label for="stats-toggle">
                <input type="checkbox" id="stats-toggle" name="stats[toggle]" @if(config('theme.stats.toggle')) checked @endif @error('stats-toggle') is-invalid @enderror/>
                <span><small></small></span>
            </label>
        </div>
        @error('stats-toggle')
        <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
        @enderror
    </div>
    <div>
        <div class="d-flex flex-column flex-md-row">
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.left')}}</legend>
                <div class=" w-100">
                    <label class="form-label m-0" for="stats-left-number">{{trans('theme::admin.number')}}</label>
                    <input type="text" class="form-control @error('stats-left-number') is-invalid @enderror" number="stats-left-number" name="stats[left][number]" value="{{old('stats-left-number', config('theme.stats.left.number'))}}" aria-describedby="stats-left-number-Label">
                    @error('stats-left-number')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class=" w-100">
                    <label class="form-label m-0" for="stats-left-text">{{trans('theme::admin.text')}}</label>
                    <textarea type="textaera" class="form-control @error('stats-left-text') is-invalid @enderror" id="stats-left-text" name="stats[left][text]" aria-describedby="whatsAdventure-stats4-text-Label">{{old('stats-left-text', config('theme.stats.left.text'))}}</textarea>
                    @error('stats-left-text')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </fieldset>
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.middle')}}</legend>
                <div class=" w-100">
                    <label class="form-label m-0" for="stats-middle-number">{{trans('theme::admin.number')}}</label>
                    <input type="text" class="form-control @error('stats-middle-number') is-invalid @enderror" number="stats-middle-number" name="stats[middle][number]" value="{{old('stats-middle-number', config('theme.stats.middle.number'))}}" aria-describedby="stats-middle-number-Label">
                    @error('stats-middle-number')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class=" w-100">
                    <label class="form-label m-0" for="stats-middle-text">{{trans('theme::admin.text')}}</label>
                    <textarea type="textaera" class="form-control @error('stats-middle-text') is-invalid @enderror" id="stats-middle-text" name="stats[middle][text]" aria-describedby="whatsAdventure-stats4-text-Label">{{old('stats-middle-text', config('theme.stats.middle.text'))}}</textarea>
                    @error('stats-middle-text')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </fieldset>
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.right')}}</legend>
                <div class=" w-100">
                    <label class="form-label m-0" for="stats-right-number">{{trans('theme::admin.number')}}</label>
                    <input type="text" class="form-control @error('stats-right-number') is-invalid @enderror" number="stats-right-number" name="stats[right][number]" value="{{old('stats-right-number', config('theme.stats.right.number'))}}" aria-describedby="stats-right-number-Label">
                    @error('stats-right-number')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class=" w-100">
                    <label class="form-label m-0" for="stats-right-text">{{trans('theme::admin.text')}}</label>
                    <textarea type="textaera" class="form-control @error('stats-right-text') is-invalid @enderror" id="stats-right-text" name="stats[right][text]" aria-describedby="whatsAdventure-stats4-text-Label">{{old('stats-right-text', config('theme.stats.right.text'))}}</textarea>
                    @error('stats-right-text')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </fieldset>
        </div>

    </div>
</fieldset>
