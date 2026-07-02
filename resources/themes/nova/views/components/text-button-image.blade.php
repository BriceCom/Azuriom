@php
    $active = theme_config('home.textbuttonimage.on');
    $title = theme_config('home.textbuttonimage.title') ?? "Lorem ipsum !";
    $text = theme_config('home.textbuttonimage.text') ?? "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.";
    $buttonText = theme_config('home.textbuttonimage.link.text') ?? "A Button";
    $buttonUrl = theme_config('home.textbuttonimage.link.url');
    $image = theme_config('home.textbuttonimage.image');
@endphp

@if($active)
    <div>
        <div class="row g-4">
            <div class="col-lg-7 d-flex flex-column gap-3">
                @if($title)
                    <h2 class="mb-0">{{ $title }}</h2>
                @endif

                @if($text)
                    <p class="mb-0 opacity-75">{!! $text !!}</p>
                @endif

                @if($buttonText)
                    <div>
                        <a href="{{ $buttonUrl ?? '#' }}" class="btn btn-primary">
                            {{ $buttonText }}
                        </a>
                    </div>
                @endif
            </div>

                <div class="col-lg-5">
                    <img src="{{ isset($image) ? image_url($image):site_logo()}}" alt="{{ $title ?? site_name() }}" class="img-fluid rounded-3 w-100" loading="lazy">
                </div>
        </div>
    </div>
@endif
