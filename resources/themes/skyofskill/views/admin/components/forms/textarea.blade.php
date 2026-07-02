@php($idReplace = str_replace(['[', '-', ']'],['_'],($id??'')))
<div class="form-group">
    <label for="{{ $idReplace }}" class="form-label fw-bold m-0">{{ $nameToUpper??true  ? mb_strtoupper($name):$name }}</label>
    <textarea type="textaera" placeholder="{{ $placeholder ?? false }}" class="form-control {{isset($wysiwyg) ? 'html-editor':''}} @error('event-box-paragraph') is-invalid @enderror" id="event-box-paragraph" name={{ $id }}" aria-describedby="{{ $idReplace }}">
        {{ old($idReplace, config('theme.'.str_replace(['[', ']'],['.',''],$id))) }}
    </textarea>
    @error($id)
    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
    @enderror
</div>
