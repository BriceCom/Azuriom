@extends('layouts.app')

@section('title', $category->name)

@push('footer-scripts')
    <script>
        document.querySelectorAll('[data-package-url]').forEach(function (el) {
            el.addEventListener('click', function (ev) {
                ev.preventDefault();

                console.log('toto')

                axios.get(el.dataset['packageUrl']).then(function (response) {
                    const itemModal = document.getElementById('itemModal');
                    itemModal.innerHTML = response.data;
                    new bootstrap.Modal(itemModal).show();
                }).catch(function (error) {
                    createAlert('danger', error, true);
                });
            });
        });
    </script>
@endpush

@section('content')
    <h1>{{ $category->name }}</h1>

    <div class="row">
        <div class="col-lg-3">
            @include('tebex::categories._sidebar')
        </div>

        <div class="col" id="packages">
            <div class="row gy-4">
                @forelse($category->packages as $package)
                    <div class="col-md-4">
                        @include('tebex::packages._card', ['package' => $package])
                    </div>
                @empty
                    <div class="col">
                        <div class="alert alert-warning" role="alert">
                            {{ trans('tebex::messages.categories.empty') }}
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true"></div>
@endsection
