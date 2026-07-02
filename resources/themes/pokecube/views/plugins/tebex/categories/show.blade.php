@extends('layouts.app')

@section('title', $category->name)

@include('elements.section')

@section('content')

<div class="profile-spacer"></div>

<div class="shop-wrapper">

    {{-- TITRE --}}
    <h1 class="shop-title">{{ $category->name }}</h1>

    <div class="shop-layout">

        {{-- SIDEBAR --}}
        <aside class="shop-sidebar">
            @include('tebex::categories._sidebar')
        </aside>

        {{-- PRODUITS --}}
        <main class="shop-products">

            @forelse($category->packages as $package)

                <div class="shop-card-wrapper">
                    @include('tebex::packages.card', ['package' => $package])
                </div>

            @empty

                <div class="shop-empty">
                    {{ trans('tebex::messages.categories.empty') }}
                </div>

            @endforelse

        </main>

    </div>

</div>

<div class="profile-bottom-spacer"></div>

{{-- MODAL PRODUIT --}}
@include('tebex::packages.show')

@endsection

@push('scripts')
    @include('tebex::components.store.scripts')
@endpush
