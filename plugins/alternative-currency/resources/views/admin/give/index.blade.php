@extends('admin.layouts.admin')

@section('title', 'Donner/retirer des coins')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex flex-column gap-4">
                <form action="{{ route('alternative-currency.admin.give.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="give" required>

                    <fieldset>
                        <legend class="h4">Donner des coins à un joueur</legend>
                        <div class="d-flex flex-row flew-wrap gap-3 align-items-end">
                            <div>
                                <label class="form-label" for="userSelect">Nom du joueur</label>

                                <select class="form-select @error('user') is-invalid @enderror" id="userSelect" name="user" required>
                                    <option value="">
                                        {{ trans('messages.none') }}
                                    </option>

                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('nameSelect')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="coinSelect">Coin</label>

                                <select class="form-select @error('coin') is-invalid @enderror" id="coinSelect" name="coin" required>
                                    <option value="">
                                        {{ trans('messages.none') }}
                                    </option>

                                    @foreach($coins as $coin)
                                        <option value="{{ $coin->id }}">
                                            {{ $coin->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('coinSelect')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="amountInput">Montant à donner</label>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amountInput" name="amount" value="{{ old('amount') }}" required>

                                @error('amount')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">
                                Confirmer
                            </button>
                        </div>
                    </fieldset>
                </form>

                <form action="{{ route('alternative-currency.admin.give.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="take" required>

                    <fieldset>
                        <legend class="h4">Retirer des coins à un joueur</legend>
                        <div class="d-flex flex-row flew-wrap gap-3 align-items-end">
                            <div>
                                <label class="form-label" for="userSelect">Nom du joueur</label>

                                <select class="form-select @error('user') is-invalid @enderror" id="userSelect" name="user" required>
                                    <option value="">
                                        {{ trans('messages.none') }}
                                    </option>

                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('nameSelect')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="coinSelect">Coin</label>

                                <select class="form-select @error('coin') is-invalid @enderror" id="coinSelect" name="coin" required>
                                    <option value="">
                                        {{ trans('messages.none') }}
                                    </option>

                                    @foreach($coins as $coin)
                                        <option value="{{ $coin->id }}">
                                            {{ $coin->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('coinSelect')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div>
                                <label class="form-label" for="amountInput">Montant à retirer</label>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amountInput" name="amount" value="{{ old('amount') }}" required>

                                @error('amount')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-danger">
                                Confirmer
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    @include('alternative-currency::admin.give.table')
@endsection
