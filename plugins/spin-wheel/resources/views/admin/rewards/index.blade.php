@extends('admin.layouts.admin')

@section('title', trans('spin-wheel::admin.pages.rewards.index.title'))

@section('content')
    @include('spin-wheel::admin.elements._patchNotif')

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('spin-wheel::admin.pages.rewards.index.table.cols.name') }}</th>
                            <th scope="col">{{ trans('spin-wheel::admin.pages.rewards.index.table.cols.chances') }}</th>
                            <th scope="col">{{ trans('spin-wheel::admin.pages.rewards.index.table.cols.enabled') }}</th>
                            <th scope="col">{{ trans('spin-wheel::admin.pages.rewards.index.table.cols.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($rewards) == 0)
                            <tr class="text-center">
                                <td colspan="5">{{ trans('spin-wheel::admin.pages.rewards.index.table.row.empty') }}</td>
                            </tr>
                        @else
                            @foreach ($rewards as $reward)
                                <tr>
                                    <th scope="row">{{ $reward->id }}</th>
                                    <td><span class="badge"
                                            style="{{ $reward->getBadgeStyle() }}; font-size: 1.05em">{{ $reward->name }}</span>
                                    </td>
                                    <td>{{ $reward->chances }} %</td>
                                    <td>
                                        <span class="badge bg-{{ $reward->is_enabled ? 'success' : 'danger' }}">
                                            {{ trans_bool($reward->is_enabled) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('spin-wheel.admin.rewards.edit', $reward) }}" class="mx-1"
                                            title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <a href="{{ route('spin-wheel.admin.rewards.destroy', $reward) }}" class="mx-1"
                                            title="{{ trans('messages.actions.delete') }}" data-toggle="tooltip"
                                            data-confirm="delete"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <a class="btn btn-primary" href="{{ route('spin-wheel.admin.rewards.create') }}">
                <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
            </a>
        </div>
    </div>
@endsection
