@extends('layouts.base')

@section('title', trans('shop::messages.title'))

@section('app')
<main class="h-full -mt-20 pt-10 px-8 overflow-x-hidden">
    <div class="container mx-auto grid grid-cols-12">
        @include('shop::categories._sidebar')
    </div>
</main>
@endsection
