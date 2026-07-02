@extends('layouts.app')

@section('title', trans('shop::messages.title'))


@section('content')
    <div class="pageTitle">
        <h1>BOUTIQUE D'{{site_name()}}</h1>
        <p class="fw-normal text-light">Achetez des crédits afin d'acquérir différents avantages.</p>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @include('shop::categories._sidebar')
        </div>

        <div class="col-lg-12">
            <div class="card border-2 border-primary">
                <div class="card-body py-4">
                    {{ $welcome }}
                </div>
            </div>
        </div>
    </div>
@endsection
