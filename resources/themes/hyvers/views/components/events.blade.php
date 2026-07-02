@if(theme_config('home.events.off') !== 'on')
        <section class="container d-flex flex-column flex-md-row justify-content-between gap-7 py-11">
            <div>
                <hgroup>
                    <h2 class="fw-bold mb-4 text-uppercase">{{theme_config('home.events.title') ?? "PLUSIEURS EVENEMENTS QUOTIDIENS"}}</h2>
                    @if(theme_config('home.events.text')) <p>{{theme_config('home.events.text')}}</p> @endif
                </hgroup>

                @include('components.join-button', ['style' => "secondary"])
            </div>

            <div class="events-wrapper d-flex flex-column gap-3">
                @if(theme_config('home.events.events'))
                    @foreach(theme_config('home.events.events') as $trust)
                        @if($trust['text'])
                            <div class="card border-0 rounded-4 h-100" data-editable="true">
                                <div class="card-body d-flex align-items-start flex-wrap align-items-md-center flex-md-nowrap gap-2.5 p-3">
                                    <div class="trust-icon d-inline-flex align-items-center justify-content-center rounded-1 p-2 bg-light">
                                        <i class="bi bi-{{$trust['icon']}} text-white"></i>
                                    </div>
                                    <p class="mb-0">
                                        {{$trust['text']}}
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @else
                    @foreach(range(1, 4) as $i)
                        <div class="card border-0 rounded-4 h-100" data-editable="true">
                            <div class="card-body d-flex align-items-start flex-wrap align-items-md-center flex-md-nowrap gap-2.5 p-3">
                                <div class="trust-icon d-inline-flex align-items-center justify-content-center rounded-1 p-2 bg-light">
                                    <i class="bi bi-{{$i%2 ? "clock":"trophy"}} text-white"></i>
                                </div>
                                <p class="mb-0">
                                    Lorem ipsum
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>
@endif
