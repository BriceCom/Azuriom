@extends('layouts.app')

@section('title', 'Dedipass')

@push('scripts')
    <script src="https://api.dedipass.com/v1/pay.js" defer></script>
@endpush

@section('content')
    <section class="page-top">
        <h2>Dedipass</h2>
        <div class="block"></div>
    </section>

    <div data-dedipass="{{ $dedipassPublicKey }}" data-dedipass-custom="{{ $dedipassCustom }}"></div>
@endsection
