@if(theme_config('home.cta2.off') !== 'on')
   <div>
       <svg class="w-100 text-black"  viewBox="0 0 1440 210" fill="none" xmlns="http://www.w3.org/2000/svg">
           <path fill-rule="evenodd" clip-rule="evenodd" d="M0 31.9598L60 19.9604C120 7.96093 240 -16.0379 360 19.9604C480 55.9586 600 151.954 720 181.953C840 211.951 960 175.953 1080 163.953C1200 151.954 1320 163.953 1380 169.953L1440 175.953V283.948H1380C1320 283.948 1200 283.948 1080 283.948C960 283.948 840 283.948 720 283.948C600 283.948 480 283.948 360 283.948C240 283.948 120 283.948 60 283.948H0V31.9598Z" fill="currentColor"/>
       </svg>

       <div class="bg-black py-7" style="
        background: linear-gradient(var(--di-black) 0%, rgba(var(--di-black-rgb), .5) 50%, var(--di-black) 100%), var(--bg-base) no-repeat center center / cover;
    " >
           <section class="container"  data-aos="fade-up" data-aos-delay="0">
               <div class="row gx-4.5 gy-4">
                   <div class="col-lg-5">
                       <div class="overflow-hidden rounded-4">
                           <img
                               src="{{theme_config('home.cta2.img') ? image_url(theme_config('home.cta2.img')) : 'https://placehold.co/600x400'}}"
                               alt="" class=" rounded-4" height="331" loading="lazy" draggable="false">
                       </div>
                   </div>
                   <div class="col-lg-6 d-flex flex-column justify-content-center" data-editable="true">
                       <h2 class="fw-bold mb-1">{!! theme_config('home.cta2.title') ?? "Lorem ipsum dolor sit amet."!!}</h2>
                       @if(theme_config('home.cta2.text'))
                           <div class="opacity-75 mb-4 fw-light">
                               {{ theme_config('home.cta2.text') }}
                           </div>
                       @else
                           <p class="opacity-75 mb-4 fw-light">Lrem Ipsum is simply dummy text of the printing and typesetting industry.
                               m Ipsum is simpm Ipsum is sm Ipsum is simpLrem Ipsum is simply dummy text of the printing and
                               typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simp</p>
                       @endif
                       @if(theme_config('home.cta2.button.text'))
                           <a href="{{theme_config('home.cta2.button.url')}}"
                              class="w-fit btn btn-tertiary mt-4">
                               @if(theme_config('home.cta2.button.icon'))
                                   <i class="{{theme_config('home.cta2.button.icon')}}"></i>
                               @endif
                               {{theme_config('home.cta2.button.text')}}
                           </a>
                       @endif
                   </div>
               </div>
           </section>
       </div>


       <svg class="w-100 text-black" viewBox="0 0 1440 210" fill="none" xmlns="http://www.w3.org/2000/svg">
           <g clip-path="url(#clip0_32_215)">
               <path fill-rule="evenodd" clip-rule="evenodd" d="M1440 178.936L1380 190.935C1320 202.935 1200 226.933 1080 190.935C960 154.937 840 58.9415 720 28.9429C600 -1.05568 480 34.9426 360 46.942C240 58.9415 120 46.942 59.9999 40.9423L0 34.9426V-73.0522H59.9999C120 -73.0522 240 -73.0522 360 -73.0522C480 -73.0522 600 -73.0522 720 -73.0522C840 -73.0522 960 -73.0522 1080 -73.0522C1200 -73.0522 1320 -73.0522 1380 -73.0522H1440V178.936Z" fill="currentColor"/>
           </g>
       </svg>
   </div>
@endif
