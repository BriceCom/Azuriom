@if(theme_config('home.stats.off') !== 'on')
<section class="container">
            <div class="row justify-content-center gx-4" data-editable="true">
                @if(theme_config('home.stats.stats'))
                @foreach(theme_config('home.stats.stats') as $stat)
                @if($stat['title'])
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column justify-content-center align-items-center gap-1">
                                    <i class="{{$stat['icon']}} text-primary fs-1"></i>
                                    <span class="h3 mb-0">{{$stat['text']}}</span>
                                    <p>{{$stat['title']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @endforeach
                @else
                    @foreach(range(1, 3) as $i)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column justify-content-center align-items-center gap-1">
                                        <i class="bi bi-{{$loop->first ? 'activity' : ($loop->last ? 'trophy-fill' : 'award-fill')}} fs-1 text-primary"></i>
                                        <span class="h3 mb-0">{{$loop->iteration * rand(10, 1000)}}</span>
                                        <p>Lorem ipsum dolor sit amet.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>
@endif