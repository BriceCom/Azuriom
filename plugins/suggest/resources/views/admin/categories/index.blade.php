@extends('admin.layouts.admin')

@section('title', trans('suggest::admin.categories.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('messages.fields.name') }}</th>
                        <th scope="col">{{ trans('messages.fields.description') }}</th>
                        <th scope="col">{{ trans('messages.fields.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->id }}</th>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                <a href="{{ route('suggest.admin.categories.edit', $category) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil"></i> {{ trans('messages.actions.edit') }}
                                </a>

                                <a href="{{ route('suggest.admin.categories.destroy', $category) }}" class=" btn btn-danger btn-sm" data-confirm="delete">
                                    <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{ $categories->links() }}

            <div class="mb-3">
                <a class="btn btn-primary" href="{{ route('suggest.admin.categories.create') }}">
                    <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
                </a>
            </div>
        </div>
    </div>
@endsection
