@php($data = is_array($module['data'] ?? null) ? $module['data'] : [])

<div class="card mb-4">
    @if(!empty($data['header']))
        <div class="card-header">{{ $data['header'] }}</div>
    @endif
    <div class="card-body">
        {!! $data['text'] ?? '' !!}
    </div>
</div>
