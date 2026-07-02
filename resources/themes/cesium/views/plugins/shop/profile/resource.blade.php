@extends('layouts.app')

@section('title', trans('shop::messages.profile.payments'))

@section('content')
    <div class="row gap-4">
        @forelse($payments as $payment)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        {{$payment->items()->get()->first()->name ?? false}}
                    </div>
                    <div class="card-footer">
                        @if(isset($payment->items->first()->package))
                            <a href="{{route('shop.resource-download',
                                [
                                    'folder' => ($payment->items->first()->package->resource ? dirname($payment->items->first()->package->resource):'none'),
                                    'file' => ($payment->items->first()->package->resource ? basename($payment->items->first()->package->resource):'none')
                                ]
                            )}}">Télécharger la ressource ({{$payment->items->first()->package->resource}})</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p>Aucune ressource</p>
        @endforelse
    </div>
@endsection
