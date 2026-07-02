@props([
    'user',
    'date' => null,
    'avatarSize' => 32,
    'textClass' => 'text-muted',
])

<div class="d-flex flex-row flex-wrap align-items-center">
    <img
        src="{{ $user->getAvatar($avatarSize) }}"
        class="rounded-circle me-2"
        width="{{ $avatarSize }}"
        height="{{ $avatarSize }}"
        alt="{{ $user->name }}"
    >
    <p class="{{ $textClass }} d-flex flex-row align-items-center flex-wrap mb-0">
        {{ $user->name }}
        @if($date)
            <small class="ms-2">{{ $date->diffForHumans() }}</small>
        @endif
    </p>
</div>
