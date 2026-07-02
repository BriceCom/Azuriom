<section>
    <div class="card mb-5">
        <div class="card-body">
           <div class="d-flex justify-content-between align-items-center gap-4">
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

    <div class="card">
        <div class="card-body">
            <iframe style="width: 100%; border-radius: var(--di-border-radius-sm);" height="396" src="{{theme_config('home.video.url') ?? "https://www.youtube.com/embed/jNQXAC9IVRw?si=lTKgsFHHbmwglXdX"}}"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    </div>
</section>
