@extends('layouts.app')

@section('title', trans('scratch-game::messages.history.title'))

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h1 class="mb-0">{{ trans('scratch-game::messages.history.title') }}</h1>

        <a href="{{ route('scratch-game.home') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> {{ trans('scratch-game::messages.back_to_cards') }}
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('scratch-game::messages.history.card') }}</th>
                        <th scope="col">{{ trans('scratch-game::messages.history.reward') }}</th>
                        <th scope="col">{{ trans('scratch-game::messages.price_paid') }}</th>
                        <th scope="col">{{ trans('scratch-game::messages.history.money_gain', ['name' =>  ucfirst(money_name())]) }}</th>
                        <th scope="col">{{ trans('scratch-game::messages.history.commands_gain') }}</th>
                        <th scope="col">{{ trans('messages.fields.status') }}</th>
                        <th scope="col">{{ trans('messages.fields.date') }}</th>
                        <th scope="col">{{ trans('messages.fields.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($logs as $log)
                        @php($claimed = $log->isClaimed())
                        @php($commandsExecuted = $log->executedCommands())
                        @php($commandsCount = count($commandsExecuted))
                        <tr>
                            <th scope="row">{{ $log->id }}</th>
                            <td>{{ $log->card?->name ?? trans('messages.unknown') }}</td>
                            <td>{{ $log->reward?->name ?? trans('scratch-game::messages.no_reward') }}</td>
                            <td>
                                @if((float) $log->price_paid <= 0)
                                    {{ trans('scratch-game::messages.free.price_label') }}
                                @else
                                    {{ number_format((float) $log->price_paid, 2) }} {{ money_name() }}
                                @endif
                            </td>
                            <td>
                                @if((float) $log->money_given > 0)
                                    +{{ number_format((float) $log->money_given, 2) }} {{ money_name() }}
                                @elseif($claimed)
                                    {{ trans('scratch-game::messages.history.no_gain') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($commandsCount > 0)
                                    <div class="d-inline-flex align-items-center gap-2">
                                        <span class="badge bg-info">{{ $commandsCount }}</span>
                                        <button type="button"
                                                class="btn btn-outline-secondary btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#commandsModal{{ $log->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>

                                    <div class="modal fade" id="commandsModal{{ $log->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ trans('scratch-game::messages.history.commands_modal_title', ['id' => $log->id]) }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
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
                            <td>
                                <span class="badge {{ $claimed ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ trans('scratch-game::messages.history.status.'.($claimed ? 'claimed' : 'pending')) }}
                                </span>
                            </td>
                            <td>{{ format_date($log->created_at, true) }}</td>
                            <td>
                                <a href="{{ route('scratch-game.result', $log) }}" class="btn btn-sm {{ $claimed ? 'btn-outline-primary' : 'btn-warning' }}">
                                    {{ trans('scratch-game::messages.history.actions.'.($claimed ? 'view' : 'continue')) }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">{{ trans('scratch-game::messages.history.empty') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{ $logs->links() }}
        </div>
    </div>
@endsection
