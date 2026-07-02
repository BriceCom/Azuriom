<ul class="list-unstyled d-flex align-items-center gap-1.5 mb-0">
    @foreach(social_links() as $link)
        @include("components.social", ["link" => $link])
    @endforeach
</ul>
