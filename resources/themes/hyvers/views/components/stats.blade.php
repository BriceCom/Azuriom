@if(theme_config('home.stats.off') !== 'on')
    <section class="radial-gradient py-11">
        <div class="container">
            <hgroup class="mb-7">
                <h2 class="mb-2 text-uppercase">{{theme_config('home.stats.title') ?? "Quelques statistiques"}}</h2>
                @if(theme_config('home.stats.text')) <p>{{theme_config('home.stats.text')}}</p> @endif
            </hgroup>

            <div class="d-flex flex-wrap gap-3" data-editable="true">
                @if(theme_config('home.stats.stats'))
                    @foreach(theme_config('home.stats.stats') as $stat)
                        @if($stat['title'])
                            <div class="card stat-card">
                                <div class="card-body">
                                    <span class="text-xxl">{{$stat['title']}}</span>
                                    <p class="text-uppercase m-0 text-1xl fw-semibold">{{$stat['text']}}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    @foreach(range(1, 4) as $i)
                        <div class="card stat-card">
                            <div class="card-body">
                                <span class="text-xxl">1548</span>
                                <p class="text-uppercase m-0 text-1xl fw-semibold">Lorem</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endif
