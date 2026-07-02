@props([
    'icon' => null,
    'text' => '',
])

<div class="large-badge text-nowrap">
    <i class="bi {{$icon}} text-xl"></i>
    <div class="wysiwyg no-margin">
        {!! $text !!}
    </div>
</div>
