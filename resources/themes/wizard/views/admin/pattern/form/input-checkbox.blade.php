<div class="my-2">
    <div class="form-check form-switch mt-2">
        <input type="checkbox" class="form-check-input"
               id="input-checkbox-{{$page}}-{{$field['key']}}-{{$field['value']}}"
               name="{{$page}}[{{$field['key']}}]{{isset($field['index']) ? '[index][{index}]': ''}}[{{$field['value']}}]"
               @if( theme_config($page.'.'.$field['key'].'.'.(isset($keyInput) ? 'index'.'.'.$keyInput.'.'.$field['value'] : $field['value'])) === 'on') checked @endif>
            @if(isset($field['label']))
            <label class="form-check-label"
                   for="input-checkbox-{{$page}}-{{$field['key']}}-{{$field['value']}}">{{$field['label']}}</label>
            @endif
    </div>
</div>
