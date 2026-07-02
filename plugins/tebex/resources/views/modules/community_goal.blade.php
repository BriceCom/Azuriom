@php($data = is_array($module['data'] ?? null) ? $module['data'] : [])
@php($percentage = max(0, min(100, (float) ($data['percentage'] ?? 0))))
@php($striped = ($data['bar_style'] ?? '') === 'striped')
@php($animated = (bool) ($data['bar_animated'] ?? false))
@php($classes = trim('progress-bar'.($striped ? ' progress-bar-striped' : '').($animated ? ' progress-bar-animated' : '')))

<div class="card mb-4">
    <div class="card-header">
        {{ $data['header'] ?? 'Community Goal' }}
    </div>
    <div class="card-body">
        <div class="progress mb-2">
            <div class="{{ $classes }}" role="progressbar" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $percentage }}%"></div>
        </div>
        <small>
            {{ $data['total_payments'] ?? 0 }} / {{ $data['target'] ?? 0 }}
            @if(isset($data['times_achieved']))
                ({{ $data['times_achieved'] }}x)
            @endif
        </small>
    </div>
</div>
