@extends('layouts.app')

@php
    $pageTitleSetting = trim((string) setting('scratch-game.page_title', ''));
    $pageTitle = $pageTitleSetting !== '' ? $pageTitleSetting : trans('scratch-game::messages.title');
@endphp

@section('title', $pageTitle)

@section('content')
    @php
        $cardMinWidth = (int) setting('scratch-game.card_min_width', 300);
        $cardMinHeight = (int) setting('scratch-game.card_min_height', 150);
        $cardMinWidth = $cardMinWidth > 0 ? $cardMinWidth : 300;
        $cardMinHeight = $cardMinHeight > 0 ? $cardMinHeight : 150;
        $cardStyleVars = "--scratch-card-min-width: {$cardMinWidth}px; --scratch-card-min-height: {$cardMinHeight}px;";
    @endphp

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h1 class="mb-0">{{ $pageTitle }}</h1>

        @auth
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <small>
                    {{ trans('scratch-game::messages.your_points', ['points' => number_format((float) auth()->user()->money, 2).' '.money_name()]) }}
                </small>

                <a href="{{ route('scratch-game.history') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-clock-history"></i> {{ trans('scratch-game::messages.history.title') }}
                </a>
            </div>
        @endauth
    </div>

    @guest
        <div class="alert alert-info d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <p class="mb-0"><i class="bi bi-info-circle"></i> {{ trans('scratch-game::messages.login_required') }}</p>
            <a href="{{ route('login') }}" class="btn btn-sm btn-primary ms-auto">{{ trans('auth.login') }}</a>
        </div>
    @endguest

    @auth
        @if($pendingCount > 0)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h2 class="mb-0 fs-5">{{ trans('scratch-game::messages.pending.title', ['count' => $pendingCount]) }}</h2>
                </div>
                <div class="card-body bg-transparent">
                    <p class="text-muted mb-3">{{ trans('scratch-game::messages.pending.description') }}</p>

                    <div class="row g-3">
                        @foreach($pendingLogs as $pendingLog)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body h-100 d-flex flex-column">
                                        <strong>{{ $pendingLog->card?->name ?? trans('messages.unknown') }}</strong>
                                        <small class="text-muted">{{ format_date($pendingLog->created_at, true) }}</small>

                                        <a href="{{ route('scratch-game.result', $pendingLog) }}" class="btn btn-warning btn-sm mt-2">
                                            {{ trans('scratch-game::messages.pending.continue') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endauth

    @forelse($cardsByCategory as $category => $cards)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="fs-5 mb-0">{{ $category }}</h2>
                <span class="text-muted">{{ $cards->count() }} {{ trans('scratch-game::messages.cards_count') }}</span>
            </div>
            <div class="card-body bg-transparent">
                <div class="row g-3">
                    @foreach($cards as $card)
                        @php
                            $canPlay = $card->isUserEligible($user);
                            $freeStatus = $freeStatusByCard[$card->id] ?? null;
                            $isFreeAvailable = (float) $card->price <= 0
                                || ($freeStatus !== null && $freeStatus['available']);
                        @endphp

                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100 scratch-card" style="{{ $cardStyleVars }}">
                                @if($card->coverImageUrl())
                                    <img src="{{ $card->coverImageUrl() }}" class="card-img-top scratch-card-img" alt="{{ $card->name }}">
                                @endif

                                <div class="card-body d-flex flex-column">

                                    <h5 class="card-title">{{ $card->name }}</h5>

                                    <p class="mb-2">
                                        @if($isFreeAvailable)
                                            <span>{{ trans('scratch-game::messages.free.price_label') }}</span>
                                        @else
                                            <span>{{ number_format((float) $card->price, 2) }} {{ money_name() }}</span>
                                        @endif

                                        @if($freeStatus !== null && !$isFreeAvailable)
                                            <small class="text-muted">
                                                ({{ trans('scratch-game::messages.free.cooldown_label', ['cooldown' => $freeStatus['cooldown']]) }})
                                            </small>
                                        @endif
                                    </p>

                                    <div class="mt-auto">
                                        @auth
                                            @if($canPlay)
                                                <form method="POST" action="{{ route('scratch-game.play', $card) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary w-100">
                                                        {{ trans('scratch-game::messages.buy_and_scratch') }}
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-secondary w-100" disabled>
                                                    {{ trans('scratch-game::messages.locked_for_role') }}
                                                </button>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-warning">{{ trans('scratch-game::messages.no_cards_available') }}</div>
@endforelse
@endsection

@push('styles')
    <style>
        .scratch-card {
            min-width: var(--scratch-card-min-width, 300px);
            min-height: var(--scratch-card-min-height, 150px);
        }

        .scratch-card-img {
            height: var(--scratch-card-min-height, 150px);
            object-fit: cover;
        }

        @media (max-width: 576px) {
            .scratch-card {
                min-width: 0 !important;
                width: 100% !important;
            }
        }
    </style>
@endpush
