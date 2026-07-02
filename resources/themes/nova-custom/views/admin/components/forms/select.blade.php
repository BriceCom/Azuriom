@php
    $idReplace = str_replace(['[', '-', ']'],['_'],($id??''));

    $amount = 0;
    $moreValues = true;
    if($amountOption??false) while($moreValues) (${"value" . $amount+1}??false ? $amount++:$moreValues = false);
@endphp
<div class="form-group">
    <label for="{{$idReplace}}" class="form-label fw-bold m-0">{{ $nameToUpper??true  ? mb_strtoupper($name):$name }}</label>
    <div class="d-flex align-center">
        <select class="form-select"
                id="{{$idReplace}}"
                name="{{ $id }}">
            @if(isset($options))
                @foreach($options as $option)
                    <option value="{{ $option['value'] }}"
                            @if(config('theme.'.str_replace(['[', ']'],['.',''],$id)) == $option['value']) selected @endif>{{ $option['text'] }}
                    </option>
                @endforeach
            @else
                @for($i = 0;$i<$amount;$i++)
                    <option value="{{ ${'value'.$i+1} }}"
                            @if(config('theme.'.str_replace(['[', ']'],['.',''],$id)) == ${'value'.$i+1}) selected @endif>{{ ${'value'.$i+1} }}
                    </option>
                @endfor
            @endif

        </select>
    </div>
    @error($id)
    <small class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></small>
    @enderror
</div>
