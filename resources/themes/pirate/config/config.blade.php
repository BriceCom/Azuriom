@extends('admin.layouts.admin')

@section('footer_description_1', 'Pirate config')

@push('footer-scripts')
    <script>
        function addLinkListener(el) {
            el.addEventListener('click', function () {
                const element = el.parentNode.parentNode.parentNode;

                element.parentNode.removeChild(element);
            });
        }

        document.querySelectorAll('.link-remove').forEach(function (el) {
            addLinkListener(el);
        });

        document.getElementById('addLinkButton').addEventListener('click', function () {
            let input = '<div class="row g-3"><div class="mb-3 col-md-6">';
            input += '<input type="text" class="form-control" name="footer_links[{index}][name]" placeholder="{{ trans('messages.fields.name') }}"></div>';
            input += '<div class="mb-3 col-md-6"><div class="input-group">';
            input += '<input type="url" class="form-control" name="footer_links[{index}][value]" placeholder="{{ trans('messages.fields.link') }}">';
            input += '<button class="btn btn-outline-danger link-remove" type="button">';
            input += '<i class="bi bi-x-lg"></i></button></div></div></div>';

            const newElement = document.createElement('div');
            newElement.innerHTML = input;

            addLinkListener(newElement.querySelector('.link-remove'));

            document.getElementById('links').appendChild(newElement);
        });

        document.getElementById('configForm').addEventListener('submit', function () {
            let i = 0;

            document.getElementById('links').querySelectorAll('.row').forEach(function (el) {
                el.querySelectorAll('input').forEach(function (input) {
                    input.name = input.name.replace('{index}', i.toString());
                });

                i++;
            });
        });
    </script>
@endpush

@section('content')
    <form action="{{ route('admin.themes.config', $theme) }}" method="POST" id="configForm">
        @csrf

        <div class="card shadow">
            <div class="card-body">
                <div class="row g-3">
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="discordInput">{{ trans('theme::pirate.discord') }}</label>
                        <input type="text" class="form-control @error('discord_id') is-invalid @enderror" id="discordInput" name="discord_id" value="{{ old('discord_id', config('theme.discord_id')) }}" aria-describedby="discordLabel">

                        @error('discord_id')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                        <small id="discordLabel" class="form-text">{{ trans('theme::pirate.discord_info') }}</small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="twitterInput">Twitter</label>
                        <input type="text" class="form-control @error('twitter') is-invalid @enderror" id="twitterInput" name="twitter" value="{{ old('twitter', config('theme.twitter')) }}">

                        @error('twitter')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="homeDescription">{{ trans('theme::pirate.home_description') }}</label>
                    <input type="text" class="form-control @error('home_description') is-invalid @enderror" id="homeDescription" name="home_description" value="{{ old('home_description', theme_config('home_description')) }}">

                    @error('home_description')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <hr>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="icon1">{{ trans('theme::pirate.icon_1') }}</label>
                            <input type="text" class="form-control @error('icon_1') is-invalid @enderror" id="icon1" name="icon_1" value="{{ old('icon_1', theme_config('icon_1')) }}">

                            @error('icon_1')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="title1">{{ trans('theme::pirate.title_1') }}</label>
                            <input type="text" class="form-control @error('title_1') is-invalid @enderror" id="title1" name="title_1" value="{{ old('title_1', theme_config('title_1')) }}">

                            @error('title_1')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description1">{{ trans('theme::pirate.description_1') }}</label>
                            <input type="text" class="form-control @error('description_1') is-invalid @enderror" id="description1" name="description_1" value="{{ old('description_1', theme_config('description_1')) }}">

                            @error('description_1')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="icon2">{{ trans('theme::pirate.icon_2') }}</label>
                            <input type="text" class="form-control @error('icon_2') is-invalid @enderror" id="icon2" name="icon_2" value="{{ old('icon_2', theme_config('icon_2')) }}">

                            @error('icon_2')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="title2">{{ trans('theme::pirate.title_2') }}</label>
                            <input type="text" class="form-control @error('title_2') is-invalid @enderror" id="title2" name="title_2" value="{{ old('title_2', theme_config('title_2')) }}">

                            @error('title_2')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description2">{{ trans('theme::pirate.description_2') }}</label>
                            <input type="text" class="form-control @error('description_2') is-invalid @enderror" id="description2" name="description_2" value="{{ old('description_2', theme_config('description_2')) }}">

                            @error('description_2')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label" for="icon3">{{ trans('theme::pirate.icon_3') }}</label>
                            <input type="text" class="form-control @error('icon_3') is-invalid @enderror" id="icon3" name="icon_3" value="{{ old('icon_3', theme_config('icon_3')) }}">

                            @error('icon_3')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="title3">{{ trans('theme::pirate.title_3') }}</label>
                            <input type="text" class="form-control @error('title_3') is-invalid @enderror" id="title3" name="title_3" value="{{ old('title_3', theme_config('title_3')) }}">

                            @error('title_3')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="description3">{{ trans('theme::pirate.description_3') }}</label>
                            <input type="text" class="form-control @error('description_3') is-invalid @enderror" id="description3" name="description_3" value="{{ old('description_3', theme_config('description_3')) }}">

                            @error('description_3')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <small class="form-text mb-3">@lang('messages.icons')</small>
                </div>

                <hr>

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="icon3">{{ trans('theme::pirate.footer_title_1') }}</label>
                        <input type="text" class="form-control @error('footer_title_1') is-invalid @enderror" id="icon3" name="footer_title_1" value="{{ old('footer_title_1', theme_config('footer_title_1')) }}">

                        @error('footer_title_1')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="icon3">{{ trans('theme::pirate.footer_title_2') }}</label>
                        <input type="text" class="form-control @error('footer_title_2') is-invalid @enderror" id="icon3" name="footer_title_2" value="{{ old('footer_title_2', theme_config('footer_title_2')) }}">

                        @error('footer_title_2')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="footerDescription1">{{ trans('theme::pirate.footer_description_1') }}</label>
                    <textarea class="form-control @error('footer_description_1') is-invalid @enderror" id="footerDescription1" name="footer_description_1" rows="3">{{ old('footer_description_1', theme_config('footer_description_1')) }}</textarea>

                    @error('footer_description_1')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="footerDescription2">{{ trans('theme::pirate.footer_description_2') }}</label>
                    <textarea class="form-control @error('footer_description_2') is-invalid @enderror" id="footerDescription2" name="footer_description_2" rows="3">{{ old('footer_description_2', theme_config('footer_description_2')) }}</textarea>

                    @error('footer_description_2')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <hr>

                <label class="form-label">{{ trans('theme::pirate.footer_links') }}</label>

                <div id="links">
                    @foreach(theme_config('footer_links') ?? [] as $link)
                        <div class="row g-3">
                            <div class="mb-3 col-md-6">
                                <input type="text" class="form-control" name="footer_links[{index}][name]" placeholder="{{ trans('messages.fields.name') }}" value="{{ $link['name'] }}">
                            </div>

                            <div class="mb-3 col-md-6">
                                <div class="input-group">
                                    <input type="url" class="form-control" name="footer_links[{index}][value]" placeholder="{{ trans('messages.fields.link') }}" value="{{ $link['value'] }}">
                                    <button class="btn btn-outline-danger link-remove" type="button">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mb-2">
                    <button type="button" id="addLinkButton" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
                    </button>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </div>
        </div>
    </form>
@endsection
