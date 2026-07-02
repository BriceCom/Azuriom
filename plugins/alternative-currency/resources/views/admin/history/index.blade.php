@extends('admin.layouts.admin')

@section('title', 'Historique')

@section('content')
    <form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('alternative-currency.admin.history.index') }}" method="GET">
        <div class="mb-3">
            <label for="searchInput" class="visually-hidden">
                {{ trans('messages.actions.search') }}
            </label>

            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" name="search" value="{{ $search ?? '' }}" placeholder="{{ trans('messages.actions.search') }}">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </form>


    <div class="card shadow mb-4">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('messages.fields.name') }}</th>
                        <th scope="col">CoiKn</th>
                        <th scope="col">Montant</th>
                        <th scope="col">Type</th>
                        <th scope="col">Crée</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($historys as $hystory)
                        <tr>
                            <th scope="row">{{ $hystory->id }}</th>
                            <td>{{ $hystory->user->name }}</td>
                            <td>{{ $hystory->coin->name }}</td>
                            <td class="{{ $hystory->type === "give" ? "text-success" : "text-danger" }}">{{ $hystory->amount }}</td>
                            <td class="{{ $hystory->type === "give" ? "text-success" : "text-danger" }}">{{ $hystory->type }}</td>
                            <td>{{ format_date_compact($hystory->created_at) }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

            {{ $historys->withQueryString()->links() }}
        </div>
    </div>

@endsection
