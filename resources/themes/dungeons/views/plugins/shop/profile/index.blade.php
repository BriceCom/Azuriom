@extends('layouts.app')

@section('title', trans('shop::messages.profile.payments'))

@section('content')
    <div class="text-center">
        <h2>{{theme_config('purchases.content.title') ? theme_config('purchases.content.title'):'Mes achats'}}</h2>
        <p>{{theme_config('purchases.content.paragraph') ? theme_config('purchases.content.paragraph'):'Liste de tous vos achats'}}</p>
    </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('shop::messages.fields.price') }}</th>
                        <th scope="col">{{ trans('messages.fields.type') }}</th>
                        <th scope="col">{{ trans('messages.fields.status') }}</th>
                        <th scope="col">{{ trans('shop::messages.fields.payment_id') }}</th>
                        <th scope="col">{{ trans('messages.fields.date') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($payments as $payment)
                        <tr>
                            <th scope="row"><span>{{ $payment->id }}</span></th>
                            <td>{{ $payment->price }} {{ currency_display($payment->currency) }}</td>
                            <td>{{ $payment->getTypeName() }}</td>
                            <td>
                            <span>
                                {{ trans('shop::admin.payments.status.'.$payment->status) }}
                            </span>
                            </td>
                            <td>{{ $payment->transaction_id ?? trans('messages.unknown') }}</td>
                            <td>{{ format_date_compact($payment->created_at) }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

    <div class="card p-4">
        <div class="card-body">
            <h2 class="card-title">{{ trans('shop::messages.giftcards.add') }}</h2>

            <form action="{{ route('shop.giftcards.add') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="code" class="form-label">{{ trans('shop::messages.fields.code') }}</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}">

                    @error('code')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary py-3 px-5 d-inline-flex align-items-center">
                        <i class="bi bi-check-lg"></i>
                        <span class="ms-2">{{ trans('messages.actions.update') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
