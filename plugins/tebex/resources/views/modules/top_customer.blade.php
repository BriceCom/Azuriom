@php($data = is_array($module['data'] ?? null) ? $module['data'] : [])
@php($username = $data['username'] ?? null)

@if($username)
    <div class="card mb-4">
        <div class="card-header">
            {{ $data['header'] ?? 'Top Customer' }}
        </div>
        <div class="card-body d-flex">
            <div class="flex-shrink-0">
                <img class="me-3 rounded" src="{{ tebex_get_avatar($username, 64) }}" alt="{{ $username }}" width="64">
            </div>
            <div class="flex-grow-1">
                <p class="h4 mb-0">{{ $username }}</p>
                @if(isset($data['total']))
                    <small>{{ tebex_format_price($data['total']) }}</small>
                @endif
            </div>
        </div>
    </div>
@endif
