@php($idReplace = str_replace(['[', '-', ']'],['_'],($id??'')))
@if($for=='create')
    <a onclick="addFields(this, '{{$id}}', {{json_encode($need)}})" class="btn btn-success">{{trans('theme::admin.multiple-input.add')}} <i class="bi bi-plus-circle"></i></a>
@else
    @foreach(config('theme.'.str_replace(['[', ']'],['.',''],$id)) ?? [] as $key=>$value)
        <div class="position-relative border border-2 p-2 mt-1">
            <div class="position-absolute text-danger fs-3 cursor-pointer" style="top: 5px; right: 5px;" onclick="deleteField(this)"><i class="bi bi-x-circle"></i></div>
            <h2 class="fs-3">N°{{$key}}</h2>
            @foreach($value as $value_key => $values)
                @switch($value_key)
                    @case(str_contains($value_key,'text'))
                        @include('components.forms.text', ['name' => trans('theme::admin.menus.home.hero.box.'.$value_key), 'id' => $id.'['.$key.']['.$value_key.']'])
                        @break
                    @case('select')
                        @include('components.forms.select', ['name' => trans('theme::admin.menus.home.hero.box.'.$value_key), 'name' => $select['name'], 'values' => $select['values'],'id' => $id.'['.$key.']['.$value_key.']'])
                        @break
                    @case('url')
                        @include('components.forms.url', ['name' => trans('theme::admin.menus.home.hero.box.'.$value_key), 'placeholder' => $url['placeholder'],'id' => $id.'['.$key.']['.$value_key.']'])
                        @break
                @endswitch
            @endforeach
        </div>
    @endforeach
@endif

