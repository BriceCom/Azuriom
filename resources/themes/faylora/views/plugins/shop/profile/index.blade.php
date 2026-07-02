@extends('layouts.base')

@section('title', trans('shop::messages.profile.payments'))

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto md:grid grid-cols-12 gap-8">
        @if(session('success'))
        <div class="flex w-full py-4 px-5 bg-forest rounded-2xl text-white text-sm justify-between" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="flex w-full py-4 px-5 bg-danger rounded-2xl text-white text-sm justify-between" role="alert">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div id="status-message"></div>

        <div class="col-span-12 mx-auto w-full flex flex-col gap-6 rounded-2xl">
            <div class="flex flex-col py-8 px-8 bg-steel-200 rounded-2xl gap-8">
                <div class="flex flex-col">
                    <span class="text-white font-bold text-2xl">Liste des achats</span>
                    <div class="h-1 w-16 bg-steel-50 rounded-full mt-1"></div>
                </div>
                <table class="w-full min-w-max">
                    <thead>
                        <tr class="text-left">
                            <th class="p-0">
                                <div class="flex items-center h-14 py-3 px-6 rounded-l-xl bg-steel-300">
                                    <label class="ml-2 text-xs text-white font-semibold">#</label>
                                </div>
                            </th>
                            <th class=" p-0">
                                <div class="flex items-center h-14 py-3 px-6 bg-steel-300">
                                    <label class="ml-2 text-xs text-white font-semibold">{{
                                        trans('shop::messages.fields.price') }}</label>
                                </div>
                            </th>
                            <th class=" p-0">
                                <div class="flex items-center h-14 py-3 px-6 bg-steel-300">
                                    <label class="ml-2 text-xs text-white font-semibold">{{
                                        trans('messages.fields.type') }}</label>
                                </div>
                            </th>
                            <th class=" p-0">
                                <div class="flex items-center h-14 py-3 px-6 bg-steel-300">
                                    <label class="ml-2 text-xs text-white font-semibold">{{
                                        trans('messages.fields.status') }}</label>
                                </div>
                            </th>
                            <th class=" p-0">
                                <div class="flex items-center h-14 py-3 px-6 bg-steel-300">
                                    <label class="ml-2 text-xs text-white font-semibold">{{
                                        trans('shop::messages.fields.payment_id') }}</label>
                                </div>
                            </th>
                            <th class=" p-0">
                                <div class="flex items-center h-14 py-3 px-6 rounded-r-xl bg-steel-300">
                                    <label class="ml-2 text-xs text-white font-semibold">{{
                                        trans('messages.fields.date') }}</label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td class=" p-0" scope="row">
                                <div class="flex items-center h-16 px-6 text-white text-sm">
                                    {{ $payment->id }}
                                </div>
                            </td>
                            <td class="p-0">
                                <div class="flex items-center h-16 px-6 text-white text-sm">
                                    {{ $payment->price }} {{ currency_display($payment->currency) }}
                                </div>
                            </td>
                            <td class="p-0">
                                <div class="flex items-center h-16 px-6 text-white text-sm">
                                    {{ $payment->getTypeName() }}
                                </div>
                            </td>
                            <td class="p-0">
                                <div class="flex items-center h-16 px-6 text-white text-sm">
                                    <span class="rounded-md px-2 bg-{{ $payment->statusColor() }}">
                                        {{ trans('shop::admin.payments.status.'.$payment->status) }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-0">
                                <div class="flex items-center h-16 px-6 text-white text-sm">
                                    {{ $payment->transaction_id ?? trans('messages.unknown') }}
                                </div>
                            </td>
                            <td class="p-0">
                                <div class="flex items-center h-16 px-6 text-white text-sm">
                                    {{ format_date_compact($payment->created_at) }}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="">
                            <td scope="row" class="text-white text-center p-4" colspan="6">Vous n'avez aucun achat !
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="flex flex-col py-8 px-8 bg-steel-200 rounded-2xl gap-8">
                <div class="flex flex-col">
                    <span class="text-white font-bold text-2xl">{{ trans('shop::messages.giftcards.add') }}</span>
                    <div class="h-1 w-16 bg-steel-50 rounded-full mt-1"></div>
                </div>
                <form action="{{ route('shop.giftcards.add') }}" method="POST" class="flex md:flex-row flex-col gap-8">
                    @csrf

                    <input
                        class="py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-steel-100 text-white font-semibold transition text-xs truncate focus:outline-none md:w-2/3 w-full placeholder-steel-50 @error('code') is-invalid @enderror"
                        placeholder="{{ trans('shop::messages.fields.code') }}" id="code" name="code"
                        value="{{ old('code') }}">

                    @error('code')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror

                    <button type="submit"
                        class="py-4 px-5 inline-flex justify-center items-center gap-2 rounded-xl bg-primary text-white font-semibold text-xs truncate md:w-1/3 w-full"
                        data-ripple-dark="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-white h-5 w-5 mr-0.5" viewBox="0 0 512 512">
                            <path xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="32"
                                d="M256 112v288M400 256H112" />
                        </svg>
                        {{ trans('messages.actions.send') }}
                    </button>
                </form>


            </div>
        </div>
    </div>
</main>
@endsection