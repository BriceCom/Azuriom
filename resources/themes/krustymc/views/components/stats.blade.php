@if(theme_config('home.stats.off') !== 'on')
    <section class="container">
            @if(theme_config('home.stats.title'))
                <hgroup class="mb-7">
                    <h2 class="mb-2 text-uppercase">{{theme_config('home.stats.title') ?? "Quelques statistiques"}}</h2>
                    @if(theme_config('home.stats.text')) <p>{{theme_config('home.stats.text')}}</p> @endif
                </hgroup>
            @endif

            <div class="row gx-3 gy-3" data-editable="true">
                @if(theme_config('home.stats.stats'))
                    @foreach(theme_config('home.stats.stats') as $stat)
                        @if($stat['title'])
                            <div class="col-md-4">
                                <div class="card stat-card">
                                    <div class="card-body d-flex align-items-center gap-3">
                                        <i class="fs-1 me-3 {{$stat['icon']}}"></i>

                                        <div>
                                            <span>{{$stat['title']}}</span>
                                            <p class="text-uppercase m-0 fs-2 fw-semibold">{{$stat['text']}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    @foreach(range(1, 4) as $i)
                        <div class="col-md-4">
                            <div class="card stat-card">
                                <div class="card-body">
                                    <span>1548</span>
                                    <p class="text-uppercase m-0 fs-2 fw-semibold">Lorem</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
    </section>
@endif
