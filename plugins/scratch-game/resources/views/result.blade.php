@extends('layouts.app')

@section('title', trans('scratch-game::messages.result_title'))

@section('content')
    @php
        $isClaimed = $log->claimed_at !== null || (float) $log->money_given > 0 || !empty($log->commands_executed);
        $canShowUserMoney = plugins()->isEnabled('shop') && function_exists('use_site_money') && use_site_money();
        $cardMinWidth = (int) setting('scratch-game.card_min_width', 300);
        $cardMinHeight = (int) setting('scratch-game.card_min_height', 150);
        $cardMinWidth = $cardMinWidth > 0 ? $cardMinWidth : 300;
        $cardMinHeight = $cardMinHeight > 0 ? $cardMinHeight : 150;
        $boardStyles = [
            "--scratch-board-width: {$cardMinWidth}px",
            "--scratch-board-height: {$cardMinHeight}px",
        ];
        if ($log->card->backgroundImageUrl()) {
            $boardStyles[] = "--scratch-board-bg: url('".$log->card->backgroundImageUrl()."')";
        }
        $boardStyleAttr = 'style="'.e(implode('; ', $boardStyles)).'"';
    @endphp

   <div>
       <a href="{{ route('scratch-game.home') }}" class="btn btn-secondary btn-sm mb-4">
           <i class="bi bi-arrow-left"></i> {{ trans('scratch-game::messages.back_to_cards') }}
       </a>
   </div>

    <h1 class="mb-3">{{ trans('scratch-game::messages.result_title') }}</h1>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body text-center">
                    <div id="scratch-alerts" class="mb-3"></div>

                    <div class="scratch-pad mx-auto">
                        <div class="scratch-board" id="scratch-board" {!! $boardStyleAttr !!}>
                            @unless($isClaimed)
                                <canvas id="scratch-layer"
                                        data-cover="{{ $log->card->coverImageUrl() }}"
                                        data-label="{{ trans('scratch-game::messages.scratch_here') }}"
                                        data-csrf-token="{{ csrf_token() }}"
                                        data-claim-url="{{ route('scratch-game.claim', $log) }}"></canvas>
                            @endunless

                            <div class="scratch-content text-center"
                                 id="scratch-content"
                                 data-no-reward="{{ trans('scratch-game::messages.no_reward') }}"
                                 data-try-again="{{ trans('scratch-game::messages.try_again') }}"
                                 data-revealing="{{ trans('scratch-game::messages.revealing_reward') }}"
                                 data-reveal-error="{{ trans('scratch-game::messages.errors.claim_failed') }}"
                                 data-currency="{{ money_name() }}">

                                <div id="reward-image-wrap" class="mb-2 @if(!$isClaimed || !$log->reward || !$log->reward->hasImage()) d-none @endif">
                                    <img id="reward-image"
                                         src="{{ $isClaimed && $log->reward && $log->reward->hasImage() ? $log->reward->imageUrl() : '' }}"
                                         alt="{{ $isClaimed && $log->reward ? $log->reward->name : '' }}"
                                         class="rounded scratch-reward-image">
                                </div>

                                @if($isClaimed)
                                    @if($log->reward)
                                        <h3 id="reward-name" class="mb-1">{{ $log->reward->name }}</h3>
                                        <p id="reward-extra" class="mb-0"></p>
                                    @else
                                        <h3 id="reward-name" class="mb-1">{{ trans('scratch-game::messages.no_reward') }}</h3>
                                        <p id="reward-extra" class="mb-0 text-muted">{{ trans('scratch-game::messages.try_again') }}</p>
                                    @endif
                                @else
                                    <h3 id="reward-name" class="mb-1">{{ trans('scratch-game::messages.scratch_to_reveal') }}</h3>
                                    <p id="reward-extra" class="mb-0 text-muted">{{ trans('scratch-game::messages.scratch_here') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ trans('scratch-game::messages.play_summary') }}</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>{{ trans('scratch-game::messages.card_label') }}:</strong> {{ $log->card->name }}</p>
                    @if($canShowUserMoney)
                        <p class="mb-2">
                            <strong>{{ trans('scratch-game::messages.price_paid') }}:</strong>
                            @if((float) $log->price_paid <= 0)
                                {{ trans('scratch-game::messages.free.price_paid_label') }}
                            @else
                                {{ number_format((float) $log->price_paid, 2) }} {{ money_name() }}
                            @endif
                        </p>
                        <p class="mb-2">
                            <strong>{{ trans('scratch-game::messages.remaining_points') }}:</strong>
                            <span id="remaining-points-value">{{ number_format((float) $remainingPoints, 2) }}</span> {{ money_name() }}
                        </p>
                    @endif
                    <p class="mb-0"><strong>{{ trans('scratch-game::messages.played_at') }}:</strong> {{ $log->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Rewards</h5>
                </div>
                <div class="card-body p-0">
                    @if($log->card->rewards->isEmpty())
                        <p class="text-muted mb-0 p-3">{{ trans('scratch-game::messages.no_reward') }}</p>
                    @else
                        <ul class="list-group list-group-flush scratch-linked-rewards">
                            @foreach($log->card->rewards as $cardReward)
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-3">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($cardReward->hasImage())
                                            <img src="{{ $cardReward->imageUrl() }}" alt="{{ $cardReward->name }}" class="rounded scratch-linked-reward-image">
                                        @endif
                                        <p class="fw-semibold mb-0">{{ $cardReward->name }}</p>
                                    </div>
                                    <span class="badge text-bg-secondary">{{ number_format((float) $cardReward->chance, 2) }}%</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <a href="{{ route('scratch-game.home') }}" class="d-block btn btn-primary w-100">
                {{ trans('scratch-game::messages.play_again') }}
            </a>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ plugin_asset('scratch-game', 'css/result.css') }}">
    <style>
        .scratch-board {
            width: var(--scratch-board-width, 300px);
            height: var(--scratch-board-height, 150px);
            max-width: 100%;
            background-image: var(--scratch-board-bg, none);
        }

        @media (max-width: 576px) {
            .scratch-board {
                width: 100% !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ plugin_asset('scratch-game', 'js/result.js') }}"></script>
@endpush
