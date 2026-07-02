@extends('admin.layouts.admin')

@section('title', "Config thème")

@include('admin.elements.color-picker')
@include('admin.elements.editor')

@section('content')

@php
    $carouselRaw = theme_config('carousel-items', []);
    $carouselJson = is_array($carouselRaw) ? json_encode($carouselRaw) : ($carouselRaw ?? '[]');

    $imagesOptions = '<option value="">-- Aucune image --</option>';
    foreach(\Azuriom\Models\Image::all() as $image) {
        $imagesOptions .= '<option value="' . e($image->url()) . '">' . e($image->name) . '</option>';
    }
@endphp

<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('admin.themes.config', $theme) }}" method="POST" id="theme-config-form">
            @csrf
                        <div class="form-group">
                <label for="copyright">Copyright</label>
                <input type="text"
                    class="form-control @error('copyright') is-invalid @enderror"
                    id="copyright"
                    name="copyright"
                    required
                    value="{{ old('copyright', theme_config('copyright')) }}">
                @error('copyright')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
                        <div class="form-group">
                <label for="footer-description">Description bas de page</label>
                <input type="text"
                    class="form-control @error('footer-description') is-invalid @enderror"
                    id="footer-description"
                    name="footer-description"
                    required
                    value="{{ old('footer-description', theme_config('footer-description')) }}">
                @error('footer-description')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-group">
                <label for="vues-moyen">Vues moyens</label>
                <input type="text"
                    class="form-control @error('vues-moyen') is-invalid @enderror"
                    id="vues-moyen"
                    name="vues-moyen"
                    required
                    value="{{ old('vues-moyen', theme_config('vues-moyen')) }}">
                @error('vues-moyen')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
                        <div class="form-group">
                <label for="record">Records de connectés</label>
                <input type="text"
                    class="form-control @error('record') is-invalid @enderror"
                    id="record"
                    name="record"
                    required
                    value="{{ old('record', theme_config('record')) }}">
                @error('record')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
                        <div class="form-group">
                <label for="navbar-text">Text navbar</label>
                <input type="text"
                    class="form-control @error('navbar-text') is-invalid @enderror"
                    id="navbar-text"
                    name="navbar-text"
                    required
                    value="{{ old('navbar-text', theme_config('navbar-text')) }}">
                @error('navbar-text')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <div class="form-group">
                <label for="navbar-text">Text navbar</label>
                <input type="text"
                    class="form-control @error('navbar-text') is-invalid @enderror"
                    id="navbar-text"
                    name="navbar-text"
                    required
                    value="{{ old('navbar-text', theme_config('navbar-text')) }}">
                @error('navbar-text')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="presentation-text">Text présentation</label>
                <input type="text"
                    class="form-control @error('presentation-text') is-invalid @enderror"
                    id="presentation-text"
                    name="presentation-text"
                    required
                    value="{{ old('presentation-text', theme_config('presentation-text')) }}">
                @error('presentation-text')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            {{-- Champ caché JSON sérialisé --}}
            <input type="hidden" name="carousel-items" id="carousel-items-json" value="{{ $carouselJson }}">

            <hr class="mt-4">
            <h5>Éléments du carousel</h5>

            <div id="carousel-items-container"></div>

            <button type="button" class="btn btn-secondary mb-3" id="add-carousel-item">
                <i class="bi bi-plus"></i> Ajouter un élément
            </button>

            <br>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
            </button>
        </form>
    </div>
</div>

<script>
    const imagesOptions = `{!! $imagesOptions !!}`;

    let carouselData = [];
    try {
        const raw = document.getElementById('carousel-items-json').value;
        carouselData = JSON.parse(raw || '[]');
        if (!Array.isArray(carouselData)) carouselData = [];
    } catch(e) {
        carouselData = [];
    }

    const container = document.getElementById('carousel-items-container');

    function buildItem(data, index) {
        const div = document.createElement('div');
        div.classList.add('card', 'mb-3', 'p-3');
        div.dataset.index = index;
        div.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>Élément #${index + 1}</strong>
                <button type="button" class="btn btn-sm btn-danger remove-item">Supprimer</button>
            </div>
            <div class="form-group">
                <label>Titre</label>
                <input type="text" class="form-control item-title" value="${(data.title ?? '').replace(/"/g, '&quot;')}">
            </div>
            <div class="form-group mt-2">
                <label>Description</label>
                <textarea class="form-control item-description" rows="2">${data.description ?? ''}</textarea>
            </div>
            <div class="form-group mt-2">
                <label>Image</label>
                <select class="form-control item-image">
                    ${imagesOptions}
                </select>
            </div>
        `;

        if (data.image) {
            const select = div.querySelector('.item-image');
            for (let opt of select.options) {
                if (opt.value === data.image) {
                    opt.selected = true;
                    break;
                }
            }
        }

        div.querySelector('.remove-item').addEventListener('click', function () {
            div.remove();
            syncJson();
        });

        div.querySelector('.item-title').addEventListener('input', syncJson);
        div.querySelector('.item-description').addEventListener('input', syncJson);
        div.querySelector('.item-image').addEventListener('change', syncJson);

        return div;
    }

    function syncJson() {
        const items = [];
        container.querySelectorAll('[data-index]').forEach(function(div) {
            items.push({
                title: div.querySelector('.item-title').value,
                description: div.querySelector('.item-description').value,
                image: div.querySelector('.item-image').value,
            });
        });
        document.getElementById('carousel-items-json').value = JSON.stringify(items);
    }

    function renderAll() {
        container.innerHTML = '';
        carouselData.forEach(function(item, i) {
            container.appendChild(buildItem(item, i));
        });
        syncJson();
    }

    document.getElementById('add-carousel-item').addEventListener('click', function () {
        const index = container.querySelectorAll('[data-index]').length;
        container.appendChild(buildItem({}, index));
        syncJson();
    });

    document.getElementById('theme-config-form').addEventListener('submit', function(e) {
        e.preventDefault();
        syncJson();
        this.submit();
    });

    renderAll();
</script>

@endsection