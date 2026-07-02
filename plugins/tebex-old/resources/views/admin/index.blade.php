@extends('admin.layouts.admin')

@section('title', trans('tebex::admin.title'))

@section('content')

@include('admin.elements.editor')

<div class="card shadow mb-4">
    <div class="card-body">

        <form action="{{ route('tebex.admin.index') }}" method="POST">
            @csrf

{{--            <x-admin.card :title="'Configuration'"--}}
{{--                          :icon="'bi bi-star-fill'">--}}

{{--                <label class="form-label" for="tebex_key">{{ trans('tebex::admin.fields.tebex_key') }}</label>--}}

{{--                <div class="input-group @error('tebex_key') has-validation @enderror" v-scope="{toggle: false}">--}}
{{--                    <input :type="toggle ? 'text' : 'password'" type="text" min="0" class="form-control @error('tebex_key') is-invalid @enderror" id="tebex_key" name="tebex_key" value="{{ old('tebex_key', $tebex_key) }}">--}}
{{--                    <button @click="toggle = !toggle" type="button" class="btn btn-outline-primary">--}}
{{--                        <i class="bi" :class="toggle ? 'bi-eye' : 'bi-eye-slash'"></i>--}}
{{--                    </button>--}}
{{--                    @error('tebex_key')--}}
{{--                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--                    @enderror--}}
{{--                </div>--}}

{{--                <small class="form-text">{{ trans('tebex::admin.fields.tebex_key_info') }} <a target='_blank' href="https://docs.tebex.io/developers">https://docs.tebex.io/developers</a></small>--}}
{{--            </x-admin.card>--}}

{{--            <x-admin.card :title="'Package page'"--}}
{{--                          :icon="'bi bi-star-fill'">--}}
{{--                <div class="row mb-3">--}}
{{--                    <div class="col-md-6">--}}
{{--                        <label class="form-label" for="tebex_title">{{ trans('tebex::admin.fields.shop_title') }}</label>--}}

{{--                        <div class="@error('tebex_title') has-validation @enderror">--}}
{{--                            <input type="text" class="form-control @error('tebex_title') is-invalid @enderror" id="tebex_title" name="tebex_title" value="{{ old('tebex_title', $tebex_shop_title) }}">--}}

{{--                            @error('tebex_key')--}}
{{--                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="col-md-6">--}}
{{--                        <label class="form-label" for="tebex_subtitle">{{ trans('tebex::admin.fields.shop_subtitle') }}</label>--}}

{{--                        <div class="@error('tebex_subtitle') has-validation @enderror">--}}
{{--                            <input type="text" class="form-control @error('tebex_subtitle') is-invalid @enderror" id="tebex_subtitle" name="tebex_subtitle" value="{{ old('tebex_subtitle', $tebex_shop_subtitle) }}">--}}

{{--                            @error('tebex_key')--}}
{{--                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="mb-3 form-check form-switch">--}}
{{--                    <input type="checkbox" class="form-check-input" id="home_status" name="home_status" @if(setting('tebex.shop.home', true)) checked @endif>--}}
{{--                    <label class="form-check-label" for="home_status">{{ trans('tebex::messages.home.toogle') }}</label>--}}
{{--                </div>--}}

{{--                <label class="form-label" for="home_message">{{ trans('tebex::messages.home.title') }}</label>--}}
{{--                <textarea class="form-control html-editor @error('maintenance_message') is-invalid @enderror" id="home_message" name="home_message" rows="5">{{ old('home_message', setting('tebex.shop.home.message', trans('tebex::messages.home.placeholder'))) }}</textarea>--}}

{{--                @error('home_message')--}}
{{--                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>--}}
{{--                @enderror--}}
{{--            </x-admin.card>--}}

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
            </button>
        </form>

    </div>
</div>
@endsection
