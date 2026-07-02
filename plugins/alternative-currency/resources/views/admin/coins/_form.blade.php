@csrf

<div class="mb-3">
    <label class="form-label" for="nameInput">Nom</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name', $coin->name ?? '') }}" required>

    @error('name')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="mb-3" v-scope="{ image: '{{ old('image', $coin->image ?? '') ?? '' }}' }">
    <label class="form-label" for="imageSelect">{{ trans('admin.settings.index.logo') }}</label>
    <div class="input-group mb-3">
        <a class="btn btn-outline-success" href="{{ route('admin.images.create') }}" target="_blank" rel="noopener noreferrer">
            <i class="bi bi-upload"></i>
        </a>
        <select class="form-select @error('image') is-invalid @enderror" id="imageSelect" v-model="image" name="image">
            <option value="" @if(isset($coin)) @selected(!$coin->image) @endif>
                {{ trans('messages.none') }}
            </option>

            @foreach($images as $image)
                <option value="{{ $image->file }}" @if(isset($coin)) @selected($coin->image === $image) @endif>
                    {{ $image->name }}
                </option>
            @endforeach
        </select>
    </div>

    <img v-if="image" :src="image ? '{{ image_url() }}/' + image : '#'" class="img-fluid rounded img-preview-sm" alt="image">

    @error('image')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="shopCurrency" name="shop_currency" @checked($coin->shop_currency ?? false)>
    <label class="form-check-label" for="shopCurrency">Utiliser comme monnaie alternative à la monnaie d'Azuriom</label>
</div>
