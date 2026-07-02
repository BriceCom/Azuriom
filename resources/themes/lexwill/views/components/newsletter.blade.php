<!-- REGISTER SECTION START -->
{{--{{ dd(Auth::user()) }}--}}
@if(Auth::check() &&  plugins()->isEnabled('Advancednewsletter') && !Azuriom\Plugin\Advancednewsletter\Models\Unsubscribe::isEnable(Auth::user()))
    <section class="register-section background-gradient ptb100"  style="font-size-adjust: {{theme_config('home.index.newsletter.fontSize') != 0 ?  theme_config('home.index.newsletter.fontSize'):"unset"}};">
        <div id="newsletter" class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 wow fadeInLeft">
                    <div class="reg-wrapper">
                        <div class="title-bl text-left">
                            <div class="title color-white">
                                {{ theme_config('home.index.newsletter.title') ?? "Newsletter" }}
                            </div>
                            <div class="subtitle">
                                {{ theme_config('home.index.newsletter.title') ?? "Newsletter" }}
                            </div>
                        </div>
                        <div class="color-white">
                           {!! theme_config('home.index.newsletter.text') ?? "Nous vous tennons au courrant des nouveautés devous tennons au courrant des nouveautés " !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 wow fadeInRight" data-wow-duration="2s">
                    <form  action="{{ route('advancednewsletter.profile.toggle') }}" method="POST" class="reg-form">
                        @csrf
                        <div class="reg_input">
                            <input type="mail" placeholder="Entrez votre adresse email" required>
                        </div>
                        <button class="reg_submit" type="submit">
                            <i class="fa fa-envelope color-1 fsize-14" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endif
<!-- REGISTER SECTION END -->
