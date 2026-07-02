<section class="discord card container py-4 px-8">
    <div class="row d-flex flex-wrap gap-3 justify-content-between">
        <div class="col-md-4 discord__img">
            <img height="{{theme_config('home.discord.imgHeight') ?? "170"}}" src="{{theme_config('home.discord.img') ?? "https://dummyimage.com/200x200/3D3635/aa"}}" alt="">
        </div>
        <div class='col-md-7 discord__content d-flex flex-column gap-1'>
            <h2 class="h4 m-0 text-md-end">{!! theme_config('home.discord.title') ?? `THE COMMUNITY IS ALSO ON <span class="text-primary">DISCORD</span> JOIN US NOW!` !!}</h2>
            <p class='flex-grow-1 text-muted text-md-end mb-3'>{{theme_config('home.discord.text') ?? "Lorem ipsum dolor sit amet, consectetur adipisicing
                elit. Aut eius ipsam maxime modi mollitia nisi obcaecati quam recusandae repudiandae voluptas."}}</p>
            <div class="text-md-end">
                <a href="{{theme_config('home.discord.link.url') ?? "#"}}" class="w-fit btn btn-secondary text-uppercase">{{theme_config('home.discord.link.text') ?? "Join discord"}} <i class="bi bi-box-arrow-up-right"></i></a>
            </div>
        </div>
    </div>
</section>
