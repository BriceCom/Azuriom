@extends('admin.layouts.admin')

@section('title', 'Paramètres')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('alternative-currency.admin.setting.store') }}" method="POST">
                @csrf


                <div class="mb-3">
                    <label class="form-label" for="apiToken">Token API Bearer</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="apiToken" name="apiToken" value="{{ old('apiToken', setting('alternative_currency.api_key')?? '') }}" required>

                    @error('apiToken')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">

            <h2>API</h2>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Method</th>
                        <th scope="col">Description</th>
                        <th scope="col">Endpoint</th>
                        <th scope="col">Query params</th>
                        <th scope="col">Example</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row"><span class="badge text-bg-success">POST</span></th>
                        <td>Update/set coin to a player</td>
                        <td>/coin/add</td>
                        <td>{coinId} {userId} {amount}</td>
                        <td>
                            /api/alternative-currency/coin/add?coinId=4&userId=1&amount=999
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><span class="badge text-bg-secondary">GET</span></th>
                        <td>Get all coins of specific player</td>
                        <td>/user/{id}</td>
                        <td>/</td>
                        <td>
                            /api/alternative-currency/user/1
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><span class="badge text-bg-secondary">GET</span></th>
                        <td>Get specific coin</td>
                        <td>/coin/{id}</td>
                        <td>/</td>
                        <td>
                            /api/alternative-currency/coin/1
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
