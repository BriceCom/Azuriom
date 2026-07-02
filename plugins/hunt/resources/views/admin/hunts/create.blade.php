@extends('admin.layouts.admin')

@section('title', trans('hunt::admin.hunts.create'))


@section('content')
    <a href="{{ route('hunt.admin.hunts.index') }}" class="btn btn-secondary mb-4">
        <i class="bi bi-arrow-left"></i> {{ trans('hunt::admin.buttons.back') }}
    </a>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('hunt.admin.hunts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @include('hunt::admin.hunts._form')

                        <div class="col-md-12 mt-4">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check-lg"></i> {{ trans('hunt::admin.buttons.create') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('hunt::admin.hunts._sidebar')
    </div>
@endsection
