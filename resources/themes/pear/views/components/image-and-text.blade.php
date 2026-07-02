@props([
    'image' => 'NULL',
    'image_width' => 300,
    'image_height' => 400,
    'image_alt' => 'NULL',
    'title' => 'NULL',
    'description' => 'NULL',
    'link_href' => null,
    'link_text' => 'NULL',
    'link_position' => 'end',
    'link_blank' => false,
    'revert' => false
])
<section class="row gy-4 gx-5 align-items-center">
    <div class="col-12 col-lg-6 @if($revert) order-md-2 @endif">
        <img class="w-100 object-fit-contain" style="width: {{$image_width}}px; height: {{$image_height}}px;" src="{{$image}}" alt="{{$image_alt}}">
    </div>
    <div class="col text-md-start text-center">
        <h2 class="mb-3">{{$title}}</h2>
        <p>{{$description}}</p>
        <div class="text-{{$link_position}}">
            <a href="{{$link_href}}" @if($link_blank) target="_blank" @endif class="btn btn-primary">{{$link_text}}</a>
        </div>
    </div>
</section>
