<div class="my-2 row">
    <label for="input-color-{{$page}}-{{$field['key']}}-{{$field['value']}}" class="col-3">{{$field['label']}}</label>
    <input id="input-colo-{{$page}}-{{$field['key']}}-{{$field['value']}}"
           class="form-control col-7"
           value="{{old($page.'.['.$field['key'].']['.$field['value'].']',theme_config($page.'.'.$field['key'].'.'.$field['value']))}}"
           name="{{$page}}[{{$field['key']}}][{{$field['value']}}]"
           type="color">
</div>
