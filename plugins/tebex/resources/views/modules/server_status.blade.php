@php($data = is_array($module['data'] ?? null) ? $module['data'] : [])
@php($online = (bool) ($data['online'] ?? false))
@php($players = $data['players'] ?? null)

<div class="card mb-4">
    <div class="card-header">
        {{ $data['header'] ?? 'Server Status' }}
    </div>
    <div class="card-body">
        @if(!empty($data['hostname']))
            <p class="mb-1">{{ $data['hostname'] }}@if(!empty($data['port'])):{{ $data['port'] }}@endif</p>
        @endif
        <p class="mb-1">
            <span class="badge {{ $online ? 'text-bg-success' : 'text-bg-danger' }}">
                {{ $online ? trans('messages.status.online') : trans('messages.status.offline') }}
            </span>
        </p>
        @if($online && is_array($players))
            <small>
                {{ $players['online'] ?? 0 }} / {{ $players['max'] ?? 0 }}
            </small>
        @endif
    </div>
</div>
