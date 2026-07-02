<div class="{{$col}} h-auto mb-4">
    <div class="rounded h-100">
        @if(isset($arrayItems) && $arrayItems)
            @if(array_key_exists(0,$arrayItems))
                @foreach($arrayItems as $arrayItem)
                    @include('admin.pattern.items.items',$arrayItem)
                @endforeach
            @else
                @include('admin.pattern.items.items',$arrayItems)
            @endif
        @endif
    </div>
</div>
