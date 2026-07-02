<div id="carousel" class="carousel slide">
    <div class="carousel-inner rounded-2">
        @if(! $posts->isEmpty())
                @foreach($posts as $post)
                    <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                        @if($post->hasImage())
                            <img src="{{$post->imageUrl()}}" class="d-block w-100 object-fit-cover" height="410" alt="{{ $post->title }}">
                        @else
                            <img src="https://dummyimage.com/1980x1080/3D3635/aa" class="d-block w-100 object-fit-cover" height="410" alt="">
                        @endif
                        <div class="carousel-caption d-none d-md-block">
                            <h3 class="h4"><a class="text-decoration-none text-white" href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                            <p class="w-50 m-auto text-white">{{ Str::limit(strip_tags($post->content), 250) }}</p>
                        </div>
                    </div>
                @endforeach
        @endif
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
