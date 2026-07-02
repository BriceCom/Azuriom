@extends('layouts.app')

@section('title', 'Dedipass')

@push('scripts')
    <script src="https://api.dedipass.com/v1/pay.js" defer></script>
@endpush

@section('content')
    <h1>Dedipass</h1>

    <div data-dedipass="{{ $dedipassPublicKey }}" data-dedipass-custom="{{ $dedipassCustom }}"></div>
@endsection
