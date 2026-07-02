@plugin('gallery')
@php
    $galleryLinks = \Azuriom\Plugin\Gallery\Models\Links::with('image')->take(7)->get();
@endphp

@if(!$galleryLinks->isEmpty())
<section class="gallery-section">
    <div class="container">
        <div class="section-copy text-center mb-5">
            <span class="badge text-bg-tertiary text-tertiary text-uppercase fw-bold px-3 py-2 mb-3">{{ theme_config('home.gallery.badge') ?? 'Gallerie' }}</span>
            <h2 class="mb-3">{{ theme_config('home.gallery.title') ?? 'Quelques images du serveur' }}</h2>
            <p>
                {{ theme_config('home.gallery.text') ?? 'Lrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simpLrem Ipsum is simply dummy text of' }}
            </p>
        </div>
        <div class="gallery-grid">
            @foreach($galleryLinks as $index => $link)
                @php
                    $class = 'gallery-item';
                    if($index == 0) $class .= ' gallery-large';
                    elseif($index == 1) $class .= ' gallery-medium';
                    elseif($index == 6) $class .= ' gallery-wide';
                    else $class .= ' gallery-small';
                @endphp
                <img src="{{ $link->image->url() }}" alt="Gallery {{ $index + 1 }}" class="{{ $class }}" />
            @endforeach
        </div>
    </div>
</section>
@endif
@endplugin
