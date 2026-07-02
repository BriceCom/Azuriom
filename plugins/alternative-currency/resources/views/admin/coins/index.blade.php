@extends('admin.layouts.admin')

@section('title', 'Coins')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Image</th>
                        <th scope="col">Utilité</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($coins as $coin)
                        <tr>
                            <th scope="row">
                                {{ $coin->name }}
                            </th>
                            <td>
                                <img src="{{$coin->image ? image_url().'/'.$coin->image: ''}}" alt="{{$coin->name}}" height="64" width="64">
                            </td>
                            <td>
                                {{ $coin->shop_currency ? 'Shop':null }}
                            </td>
                            <td class="text-end">
                                <a href="{{ route('alternative-currency.admin.coins.edit', $coin) }}" class="mx-1" title="{{ trans('messages.actions.edit') }}" data-bs-toggle="tooltip"><i class="bi bi-pencil-square"></i></a>
                                <a href="{{ route('alternative-currency.admin.coins.destroy', $coin) }}" class="mx-1 text-danger" title="{{ trans('messages.actions.delete') }}" data-bs-toggle="tooltip" data-confirm="delete"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <a class="btn btn-primary" href="{{ route('alternative-currency.admin.coins.create') }}">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a>
        </div>
    </div>
@endsection
