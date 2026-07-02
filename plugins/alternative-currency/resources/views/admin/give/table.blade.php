<form class="row row-cols-lg-auto g-3 align-items-center" action="{{ route('alternative-currency.admin.give.index') }}" method="GET">
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
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ trans('messages.fields.name') }}</th>
                    <th scope="col">Coin</th>
                    <th scope="col">Montant</th>
                    <th scope="col">Crée</th>
                    <th scope="col">Mis à jour</th>
                </tr>
                </thead>
                <tbody>

                @foreach($usersPaginate as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->user->name }}</td>
                        <td>{{ $user->coin->name }}</td>
                        <td>{{ $user->amount }}</td>
                        <td>{{ format_date_compact($user->created_at) }}</td>
                        <td>{{ format_date_compact($user->updated_at) }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        {{ $usersPaginate->withQueryString()->links() }}
    </div>
</div>
