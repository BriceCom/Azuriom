@props([
    'id' => 'stats',
    'amount' => null
])
@php
    $col = 12/$amount;
@endphp
<section class="text-center">
    <div class="row gy-3 justify-content-center align-items-center">
        @for($i = 0; $i<$amount; $i++)
            <div class="col-12 col-md-6 col-lg-{{$col}} p-0">
                @if(theme_config($id.'.image.url'))
                    <img src="{{theme_config($id.'.image.url')}}" alt="{{theme_config($id.'.image.alt')}}">
                @endif
                @if(theme_config($id.'.title') || theme_config($id.'.text'))
                    <div class="d-flex flex-column py-2">
                        <span class="h1 text-primary">{{theme_config($id.'.title')}}</span>
                        <span class="h5 fw-semibold">{{theme_config($id.'.text')}}</span>
                    </div>
                @endif
            </div>
        @endfor
    </div>
</section>
