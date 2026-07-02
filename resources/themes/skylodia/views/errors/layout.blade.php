@extends('layouts.app')

@section('content')
    <div class="error row justify-content-center">
        <div class="col-md-9">
            <div class="p-5">
                <div class="card-body text-center">
                    <h1 class="fs-1">@yield('code')</h1>
                    <h2 class="py-4">@yield('title')</h2>
                    <p>@yield('message')</p>

                    <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                        {{ trans('errors.home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
