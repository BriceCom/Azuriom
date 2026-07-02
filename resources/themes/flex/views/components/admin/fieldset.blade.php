@props([
    'title' => null,
    'class' => null,
])

<fieldset class="d-flex flex flex-wrap {{$class}} gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 px-3 py-0 bg-body fs-6 text-secondary border">{{ $title }}</legend>
    {{ $slot }}
</fieldset>
