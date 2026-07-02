@php
    $knownVoteName = $knownVoteName ?? ($sessionVoteName ?? (isset($user) && $user !== null ? $user->name : null));
    $isVisible = isset($isVisible) ? (bool) $isVisible : filled($knownVoteName);
    $containerClass = trim(($containerClass ?? '').' '.($isVisible ? 'd-flex' : 'd-none').' flex-column flex-md-row align-items-md-center gap-3');
    $avatarSize = $avatarSize ?? 48;
    $clearUrl = $clearUrl ?? request()->fullUrlWithQuery(['clear_vote_pseudo' => 1]);
    $showChangeButton = isset($showChangeButton) ? (bool) $showChangeButton : !auth()->check();
@endphp

<div id="{{ $containerId }}" class="{{ $containerClass }}">
    <img id="{{ $avatarId }}"
         src="{{ $isVisible ? 'https://mc-heads.net/avatar/'.rawurlencode($knownVoteName).'/'.$avatarSize : '' }}"
         alt="{{ $knownVoteName ?? '' }}"
         width="{{ $avatarSize }}"
         height="{{ $avatarSize }}"
         class="rounded-1">

    <div class="d-flex flex-column align-items-start">
        <span id="{{ $nameId }}" class="text-xl">{{ $knownVoteName }}</span>

        @if($showChangeButton)
            <button type="button"
                    class="nav-link text-dark text-decoration-underline vote-change-name-action"
                    @if(!empty($buttonId)) id="{{ $buttonId }}" @endif
                    data-clear-url="{{ $clearUrl }}">
                Changer de pseudo
            </button>
        @endif
    </div>
</div>
