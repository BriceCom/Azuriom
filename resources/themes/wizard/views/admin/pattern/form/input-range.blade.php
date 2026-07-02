<div class="my-2">
    <label for="input-range-{{$page}}-{{$field['key']}}-{{$field['value']}}" class="col-3 form-label">{{$field['label']}}</label>
    <input id="input-range-{{$page}}-{{$field['key']}}-{{$field['value']}}"
           class="form-control-range col-7"
           value="{{old($page.'.['.$field['key'].']['.$field['value'].']',theme_config($page.'.'.$field['key'].'.'.$field['value']))}}"
           name="{{$page}}[{{$field['key']}}][{{$field['value']}}]"
           type="range"
           min="{{$min}}"
           max="{{$max}}"
           step="{{$step}}"
           oninput="this.nextElementSibling.value = this.value">
    <output class="col-2">{{old($page.'.['.$field['key'].']['.$field['value'].']',theme_config($page.'.'.$field['key'].'.'.$field['value']))}}</output>
</div>
