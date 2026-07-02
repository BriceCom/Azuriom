@extends('admin.layouts.admin')

@section('title', trans('scratch-game::admin.logs.title'))

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">{{ trans('scratch-game::admin.common.search') }}</label>
                    <input type="text" class="form-control" id="search" name="search" value="{{ $search }}" placeholder="{{ trans('scratch-game::admin.logs.search_placeholder') }}">
                </div>
                <div class="col-md-4">
                    <label for="card_id" class="form-label">{{ trans('scratch-game::admin.logs.filter_card') }}</label>
                    <select class="form-select" id="card_id" name="card_id">
                        <option value="">{{ trans('scratch-game::admin.logs.all_cards') }}</option>
                        @foreach($cards as $card)
                            <option value="{{ $card->id }}" @selected((string) $card_id === (string) $card->id)>{{ $card->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="user_id" class="form-label">{{ trans('scratch-game::admin.logs.filter_user') }}</label>
                    <select class="form-select" id="user_id" name="user_id">
                        <option value="">{{ trans('scratch-game::admin.logs.all_users') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected((string) $user_id === (string) $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> {{ trans('scratch-game::admin.buttons.filter') }}
                    </button>
                    <a href="{{ route('scratch-game.admin.logs.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> {{ trans('scratch-game::admin.buttons.reset') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($logs->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('scratch-game::admin.logs.user') }}</th>
                                <th>{{ trans('scratch-game::admin.logs.card') }}</th>
                                <th>{{ trans('scratch-game::admin.logs.reward') }}</th>
                                <th class="text-center">{{ trans('scratch-game::admin.logs.price_paid') }}</th>
                                <th class="text-center">{{ trans('scratch-game::admin.logs.money_given') }}</th>
                                <th class="text-center">{{ trans('scratch-game::admin.logs.commands_given') }}</th>
                                <th>{{ trans('scratch-game::admin.logs.played_at') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                @php($commandsExecuted = $log->executedCommands())
                                @php($commandsCount = count($commandsExecuted))
                                <tr>
                                    <td>{{ $log->id }}</td>
                                    <td>{{ $log->user?->name ?? '-' }}</td>
                                    <td>{{ $log->card?->name ?? '-' }}</td>
                                    <td>{{ $log->reward?->name ?? trans('scratch-game::messages.no_reward') }}</td>
                                    <td class="text-center">
                                        @if((float) $log->price_paid <= 0)
                                            {{ trans('scratch-game::messages.free.price_label') }}
                                        @else
                                            {{ number_format((float) $log->price_paid, 2) }} {{ money_name() }}
                                        @endif
                                    </td>
                                    <td class="text-center">{{ number_format((float) $log->money_given, 2) }} {{ money_name() }}</td>
                                    <td class="text-center">
                                        @if($commandsCount > 0)
                                            <div class="d-inline-flex align-items-center gap-2">
                                                <span class="badge bg-info">{{ $commandsCount }}</span>
                                                <button type="button"
                                                        class="btn btn-outline-secondary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#adminCommandsModal{{ $log->id }}">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>

                                            <div class="modal fade" id="adminCommandsModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ trans('scratch-game::admin.logs.commands_modal_title', ['id' => $log->id]) }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <ul class="list-group">
                                                                @foreach($commandsExecuted as $command)
                                                                    <li class="list-group-item">{{ $command['name'] }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $logs->withQueryString()->links() }}
            @else
                <div class="text-center py-5">
                    <i class="bi bi-clock-history" style="font-size: 4rem; color: #6c757d;"></i>
                    <h4 class="mt-3">{{ trans('scratch-game::admin.logs.no_logs') }}</h4>
                </div>
            @endif
        </div>
    </div>
@endsection
