<div class="py-2 row">
    <label for="input-text-{{$page}}-{{$field['key']}}-{{$field['value']}}" class="col-3 form-label">{{$field['label']}}</label>
    <select id="input-text-{{$page}}-{{$field['key']}}-{{$field['value']}}"
            name="{{$page}}[{{$field['key']}}][{{$field['value']}}]"
            class="form-control col-9">
        @foreach($options as $option)
            <option value="{{$option}}"
                    @if(theme_config($page.'.'.$field['key'].'.'.$field['value']) === $option) selected @endif>{{ $option }}</option>
        @endforeach
    </select>
</div>
