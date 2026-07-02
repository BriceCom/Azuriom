@extends('layouts.base')

@section('title', trans('auth.login'))

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto md:grid grid-cols-12 gap-8">
        <div class="w-full col-span-12 flex flex-col gap-6">
            <div class="flex w-full p-8 bg-danger rounded-2xl text-white text-sm">
                <div class="text-sm font-medium mx-auto text-center">
                    Vous n'êtes actuellement pas connecté, veuillez vous authentifier pour accéder à l'intégralité du
                    site !
                </div>
            </div>
        </div>
    </div>
</main>
@endsection