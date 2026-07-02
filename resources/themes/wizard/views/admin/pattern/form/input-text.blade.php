@if(isset($field['label']))
    <label class="form-label" for="input-text-{{$page}}-{{$field['key']}}-{{$field['value']}}">{{$field['label']}}</label>
@endif
<input id="input-text-{{$page}}-{{$field['key']}}-{{$field['value']}}"
       placeholder="{{$field['placeholder'] ?? ''}}"
       class="form-control"
       value="{{theme_config($page.'.'.$field['key'].'.'.(isset($keyInput) ? 'index'.'.'.$keyInput.'.'.$field['value'] : $field['value']))}}"
       name="{{$page}}[{{$field['key']}}]{{isset($field['index']) ? '[index][{index}]': ''}}[{{$field['value']}}]"
       type="text">
