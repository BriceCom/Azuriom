@php
    $arrayInputs = $field['inputs'];
    $countInput = count($arrayInputs)
@endphp
<div class="js-detect-create-builder-input">
    <div class="form-row row">
        @foreach($field['labels'] as $label)
            <div class="{{$arrayInputs[$loop->index]['class'] ?? 'col-md-'.intdiv(10,$countInput)}}">
                <label>{{$label}}</label>
            </div>
        @endforeach
    </div>
    <div class="inputs_wrapper">
        @forelse(theme_config($page.'.'.$field['key'].'.index') ?? [] as $keyInput => $inputs)
            @if(is_int($keyInput))
                <div class="form-row row my-2">
                    @foreach($inputs ?? [] as $keyI => $valueI)
                        @foreach($arrayInputs as $f)
                                @if($f['value'] === $keyI)
                                    <div class="{{$f['class'] ?? 'col-md-'.intdiv(10,$countInput)}}">
                                        @if(isset($f['type']))
                                            @switch($f['type'])
                                                @case('checkbox')
                                                    {{debug($f)}}
                                                    @include('admin.pattern.form.input-checkbox', ['field' => $f, 'keyInput' => $keyInput])
                                            @endswitch
                                        @else
                                            @include('admin.pattern.form.input-text', ['field' => $f, 'keyInput' => $keyInput])
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                    @endforeach
                    <div class="form-group col-md-1">
                        <button class="btn btn-outline-danger link-remove" type="button">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            @endif
        @empty
            <div class="form-row row my-2">
                @foreach($arrayInputs as $field)
                    <div class="{{$field['class'] ?? 'col-md-'.intdiv(10,$countInput)}}">
                        @if(isset($field['type']))
                            @switch($field['type'])
                                @case('checkbox')
                                    @include('admin.pattern.form.input-checkbox', ['field' => $field])
                                    @break
                            @endswitch
                        @else
                            @include('admin.pattern.form.input-text', ['field' => $field])
                        @endif
                    </div>
                @endforeach
                <div class="form-group col-md-1">
                    <button class="btn btn-outline-danger link-remove" type="button">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        @endforelse
    </div>
    <div class="d-none js-detect-create-builder-copy">
        <div class="form-row row my-2">
            @foreach($arrayInputs as $field)
                <div class="{{$field['class'] ?? 'col-md-'.intdiv(10,$countInput)}}">
                    @if(isset($field['type']))
                        @switch($field['type'])
                            @case('checkbox')
                                @include('admin.pattern.form.input-checkbox', ['field' => $field, 'keyInput' => false])
                                @break
                        @endswitch
                    @else
                        @include('admin.pattern.form.input-text', ['field' => $field, 'keyInput' => false])
                    @endif
                </div>
            @endforeach
            <div class="form-group col-md-1">
                <button class="btn btn-outline-danger link-remove" type="button">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="my-2">
        <button type="button" class="js-detect-create-builder-input-add btn btn-sm btn-success">
            <i class="fas fa-plus"></i> {{ trans('messages.actions.add') }}
        </button>
    </div>
</div>
