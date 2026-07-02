@extends('admin.layouts.admin')

@section('title', 'Nebulia config')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('admin.themes.config', $theme) }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="mb-3 col-md-6">
                    <label for="discordInput">Discord Id</label>
                    <input type="text" class="form-control @error('discord-id') is-invalid @enderror" id="discordInput"
                        name="discord-id" value="{{ old('discord-id', config('theme.discord-id')) }}"
                        aria-describedby="discordLabel">

                    @error('discord-id')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label for="recordInput">Record de connectés</label>
                    <input type="text" class="form-control @error('record') is-invalid @enderror" id="recordInput"
                        name="record" value="{{ old('record', config('theme.record')) }}"
                        aria-describedby="recordLabel">

                    @error('record')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
            </div>

            <div class="mb-3 col-md-6">
                <label for="currentOfferInput">ID de l'article offre du moment</label>
                <input type="text" class="form-control @error('current-offer') is-invalid @enderror"
                    id="currentOfferInput" name="current-offer"
                    value="{{ old('current-offer', config('theme.current-offer')) }}" aria-describedby="recordLabel">

                @error('current-offer')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
            </button>
        </form>
    </div>
</div>
@endsection