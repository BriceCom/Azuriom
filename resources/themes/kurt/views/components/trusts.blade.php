@if(theme_config('home.trusts.off') !== 'on')
<section class="container">
    <h2 class="fw-bold mb-4">{{theme_config('home.trusts.title') ?? "LOREM IPSUM DOLORE"}}</h2>
    <div class="row gx-4 gy-3">
        @if(theme_config('home.trusts.trusts'))
            @foreach(theme_config('home.trusts.trusts') as $trust)
                @if($trust['title'])
                    <div class="col-md-6">
                        <div class="card border-0 rounded-4 h-100" data-editable="true">
                            <div class="card-body d-flex align-items-start flex-column gap-2">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-1 p-1"
                                    style="width:32px;height:32px;background-color: {{$trust['color']}}">
                                    <i class="bi bi-{{$trust['icon']}} fs-4 text-dark"></i>
                                </div>
                                <h3 class="fw-bold mb-0 h5">{{$trust['title']}}</h3>
                                <p class="mb-0 text-muted">
                                    {{$trust['text']}}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
        @endforeach
        @else
            @foreach(range(1, 4) as $i)
                <div class="col-md-6">
                    <div class="card border-0 rounded-4 h-100" data-editable="true">
                        <div class="card-body d-flex align-items-start flex-column gap-2">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-1 p-1"
                                style="width:32px;height:32px;background-color: {{$loop->first ? '#FFE7BA' :( $loop->last ? '#F0FFAC' : '#D0FFF3')}}">
                                <i class="bi bi-activity fs-4 text-dark"></i>
                            </div>
                            <h3 class="fw-bold mb-0 h5">Lorem ipsum dolor sit amet.</h3>
                            <p class="mb-0 text-muted text-sm">
                                Lrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simp
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</section>
@endif