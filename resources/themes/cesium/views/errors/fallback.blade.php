<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#3490DC">
    <meta name="author" content="Azuriom">
    <title>{{ trans('errors.error') }} | Azuriom</title>
    <link href="{{ theme_asset('css/gen.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app" class="grid place-content-center mx-auto bg-steel-300 h-screen">
        <section class="flex items-center p-16 h-screen">
            <div class="container flex flex-col items-center justify-center px-5 mx-auto my-8">
                <div class="max-w-md text-center text-white">
                    <p class="text-2xl font-semibold md:text-3xl">{{ trans('errors.code', ['code' => $code ?? 500]) }}
                    </p>
                    <p class="mt-4 mb-12 text-steel-50">{{ trans('errors.fallback.message') }}</p>
                    <a href="{{ route('home') }}"
                        class="whitespace-nowrap bg-steel-200 hover:bg-steel-100 py-3 px-5 inline-flex rounded-full items-center justify-center text-sm font-medium text-white transition ease-in-out duration-300 tracking-wide">
                        {{ trans('messages.home') }}
                    </a>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
