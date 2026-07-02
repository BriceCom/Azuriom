@if(theme_config('staff.index.players'))
<div class="tabs-nav">
    <ul class="list-inline nav nav-tabs tabs-slider"  style="font-size-adjust: {{theme_config('staff.index.fontSize') != 0 ?  theme_config('staff.index.fontSize'):"unset"}};">
        @foreach(theme_config('staff.index.players') as $player)
                <li class="{{$loop->first ? "active":""}} col-lg-3 col-md-3">
                    <div data-toggle="tab">
                        @if($player['img'])
                            <div class="img-wrap d-flex justify-content-center align-items-center">
                                <img aria-hidden="true" class="rounded-pill object-fit-cover" height="92" width="92" src="{{$player['img'] ? image_url($player['img']) : 'img/azuriom.png'}}" alt="">
                            </div>
                        @endif
                        <div class="nav-header-bl mt25">
                            <div class="nav-title color-white">
                                {{ $player['name'] }}
                            </div>
                            <div class="date">
                                {{ $player['date'] ?? $player['date'] }}
                            </div>
                        </div>
                    </div>
                </li>
        @endforeach
    </ul>
</div>
@endif
