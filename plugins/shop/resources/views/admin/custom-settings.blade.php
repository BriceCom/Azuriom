@extends('admin.layouts.admin')

@include('admin.elements.editor')

@section('title', trans('shop::admin.settings.title') . ' - CUSTOM')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">

            <form action="{{ route('shop.admin.custom') }}" method="POST">
                @csrf

                {{-- CUSTOM FIELDS --}}
                <div class="row gx-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="heyInput">Objectif d'achat</label>

                        <div class="input-group @error('hey') has-validation @enderror">
                            <input type="number" min="0" class="form-control @error('hey') is-invalid @enderror" id="heyInput" name="hey" value="{{ old('hey', $hey) }}">
                            <span class="input-group-text">{{ currency_display() }}</span>

                            @error('hey')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

{{--                    @if($servers->isEmpty())--}}
{{--                        <div class="alert alert-info" role="alert">--}}
{{--                            <p><i class="bi bi-info-circle"></i> @lang('shop::admin.commands.servers')</p>--}}

{{--                            <a href="{{ route('admin.servers.index') }}" target="_blank" class="btn btn-primary btn-sm">--}}
{{--                                <i class="bi bi-hdd-network"></i> {{ trans('admin.servers.title') }}--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    @else--}}
{{--                        @include('shop::admin.commands._form', ['commands' => $package->commands ?? []])--}}
{{--                    @endif--}}


                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>

        </div>
    </div>
@endsection
