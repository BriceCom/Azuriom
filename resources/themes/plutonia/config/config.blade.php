@extends('admin.layouts.admin')
@section('title', 'Thème Plutonia')
@php ($azuriomImages = \Azuriom\Models\Image::all())

@section('content')
    <div class="col-12 mb-3 d-flex flex-column gap-2">
        <div class="d-flex gap-2">
            <div>
                <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" class="btn btn-primary fw-bold rounded-4 text-uppercase px-3"><i class="bi bi-discord"></i> SUPPORT</a>
            </div>
            <div>
                <button type="button" class="btn btn-success fw-bold rounded-4 text-uppercase px-3" data-bs-toggle="modal" data-bs-target="#donationModal"><i class="bi bi-heart-fill me-1"></i>DONATION</button>
            </div>
            <div>
                <a href="https://www.serveurliste.com" target="_blank" class="btn btn-warning fw-bold rounded-4 text-uppercase px-3"><i class="bi bi-search me-1"></i>LISTÉ VOS SERVEURS SUR SERVEURLISTE.COM</a>
            </div>
        </div>
        <hr>
        <div>
            <a href="{{ route('admin.images.create') }}" target="_blank" class="btn btn-secondary fw-bold rounded-4 text-uppercase px-3 my-1" style="font-size: 10px"><i class="bi bi-link"></i> Upload Image</a>
        </div>
    </div>
    <div>
        <form class="w-100" action="{{ route('admin.themes.config', $theme) }}" method="POST">
            @csrf
            <div class="card bg-secondary bg-opacity-10">
                <div class="card-header bg-secondary bg-opacity-25">
                    <h2 class="fw-bold fs-3 m-0 text-uppercase">SLIDER</h2>
                </div>
                <div class="card-body d-flex flex-column flex-md-row gap-3">
                    @include('admin.home', ['id'=> 'home', 'amount' => 3])
                </div>
            </div>
            <div class="d-flex justify-content-end m-2">
                <button type="submit" class="btn btn-success align-self-end">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </div>
        </form>
    </div>
    @includeIf('admin.components.donation')
@endsection

@push('scripts')
    <script>
        function showPreview(id){
            let img = document.getElementById('img-preview-'+id);
            let option = document.getElementById(id);

            if(option.value === ''){
                img.parentNode.style.display = 'none';
            } else {
                if(img.parentNode.style.display === 'none') img.parentNode.style.display = null;
                img.setAttribute('src', '{{ image_url() }}/' + option.value);
            }
        }
    </script>
@endpush
