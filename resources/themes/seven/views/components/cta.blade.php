@if(theme_config('home.video.cta.off') !== 'on')
    <div class="card mb-5">
        <div class="card-body">
            <div
                class="d-flex flex-column flex-md-row align-content-start justify-content-between align-items-md-center gap-4">
                <div class="w-75">
                    <h2 class="h5">{{theme_config('home.video.title') ?? "Lorem ipsum dolor sit amet."}}</h2>
                    <p>{{theme_config('home.video.text') ?? "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur ducimus earum enim
                           exercitationem
                           iure labore optio quis rerum sapiente ut?"}}</p>
                </div>
                <div class="text-end d-flex flex-column align-items-end gap-2">
                    @include('components.socials')
                    @include('components.join-button')
                </div>
            </div>
        </div>
    </div>
@endif
