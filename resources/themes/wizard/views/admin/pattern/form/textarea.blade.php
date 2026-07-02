<div class="my-2">
    <label class="form-label" for="input-text-{{$page}}-{{$field['key']}}-{{$field['value']}}">{{$field['label']}}</label>
    <textarea id="input-text-{{$page}}-{{$field['key']}}-{{$field['value']}}"
              class="form-control"
              rows="5"
              name="{{$page}}[{{$field['key']}}][{{$field['value']}}]"
              type="text">{{old($page.'.['.$field['key'].']['.$field['value'].']',theme_config($page.'.'.$field['key'].'.'.$field['value']))}}</textarea>
</div>
