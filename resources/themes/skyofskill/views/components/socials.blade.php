<ul class="list-unstyled d-flex align-items-center gap-2 mb-0">
    @foreach(social_links() as $link)
        @include("components.social", ["link" => $link])
    @endforeach
</ul>
