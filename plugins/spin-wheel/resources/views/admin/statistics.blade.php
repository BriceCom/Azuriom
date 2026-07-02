@extends('admin.layouts.admin')

@section('title', trans('spin-wheel::admin.pages.statistics.title'))

@section('content')
    <div class="row">
        <div class="col-sm-5 col-xl-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('spin-wheel::admin.pages.statistics.cards.rewards') }}</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $rewardsCount }}</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-5 col-xl-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('spin-wheel::admin.pages.statistics.cards.spins') }}</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $spinsCount }}</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-5 col-xl-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('spin-wheel::admin.pages.statistics.cards.moneySpent') }}
                            </h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="bi bi-wallet2"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $totalMoneyBet }} {{ money_name() }}</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-5 col-xl-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title mb-0">{{ trans('spin-wheel::admin.pages.statistics.cards.moneyGiven') }}
                            </h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="bi bi-bank"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">{{ $totalMoneyGived }} {{ money_name() }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">{{ trans('spin-wheel::admin.pages.statistics.tables.rewards.title') }}</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        {{ trans('spin-wheel::admin.pages.statistics.tables.rewards.cols.reward') }}</th>
                                    <th scope="col">
                                        {{ trans('spin-wheel::admin.pages.statistics.tables.rewards.cols.total') }}</th>
                                    <th scope="col">
                                        {{ trans('spin-wheel::admin.pages.statistics.tables.rewards.cols.winRate') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($statsRewards) == 0)
                                    <tr class="text-center">
                                        <td colspan="4">{{ trans('spin-wheel::messages.tables.rewards.row.empty') }}
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($statsRewards as $reward)
                                        <tr>
                                            <td scope="row">{{ $reward->reward->id }}</td>
                                            <td><a
                                                    href="{{ route('spin-wheel.admin.rewards.edit', $reward->reward) }}">{{ $reward->reward->name }}</a>
                                            </td>
                                            <td>{{ $reward->count }}</td>
                                            <td>{{ $reward->probability }} %</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">{{ trans('spin-wheel::admin.pages.statistics.tables.players.title') }}</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        {{ trans('spin-wheel::admin.pages.statistics.tables.players.cols.player') }}</th>
                                    <th scope="col">
                                        {{ trans('spin-wheel::admin.pages.statistics.tables.players.cols.reward') }}</th>
                                    <th scope="col">
                                        {{ trans('spin-wheel::admin.pages.statistics.tables.players.cols.price') }}</th>
                                    <th scope="col">
                                        {{ trans('spin-wheel::admin.pages.statistics.tables.players.cols.date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($laps->count() == 0)
                                    <tr class="text-center">
                                        <td colspan="5">{{ trans('spin-wheel::messages.tables.players.row.empty') }}
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($laps as $lap)
                                        <tr>
                                            <th scope="row">{{ $lap->id }}</th>
                                            <td>{{ $lap->player->name }}</td>
                                            <td>{{ $lap->reward_name }}</td>
                                            <td>{{ $lap->spin_price }} {{ money_name() }}</td>
                                            <td>{{ format_date($lap->created_at) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="d-flex justify-end">
            <a href="{{ route('spin-wheel.admin.statistics.destroy') }}" class="btn btn-danger" data-confirm="delete"
                data-bs-toggle="tooltip"
                data-bs-original-title="{{ trans('spin-wheel::admin.pages.statistics.truncate.desc') }}">
                <i class="bi bi-trash"></i> {{ trans('spin-wheel::admin.pages.statistics.truncate.button') }}
            </a>
        </div>
    </div>
@endsection
