<div>
    @foreach($menus as $key=>$menu)
    @if($menu['is_enabled'])
        <div class="tab-content">
            <div class="tab-pane fade" id="pill-{{$key}}" role="tabpanel" aria-labelledby="pill-{{$key}}-trigger" tabindex="0">

                <div class="d-flex flex-wrap align-items-end justify-content-between border-bottom pb-3 mb-3">
                    <div class="d-flex align-items-center gap-3 text-primary">
                        <i class="fs-3 {{ isset($menu['icon']) ? 'bi bi-'. $menu['icon'] : "bi bi-gear-fill" }}"></i>
                        <h2 class="fw-bold mb-0 text-primary">{{trans('theme::admin.menus.'.$key.'.name')}}</h2>
                    </div>

                    {{-- Multiple page tab trigger --}}
                    @if(isset($menu['multiple_page']))
                        <div>
                            <p class="mb-1 text-end opacity-75">What you want to config ?</p>
                            <ul class="nav nav-pills mb-0 justify-content-md-end" id="tab-tab" role="tablist">
                                @foreach($menu['multiple_page'] as $keyPage => $multi_page)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link @if($loop->first) active @endif" id="tab-{{$key}}-{{$keyPage}}-trigger" data-bs-toggle="pill" data-bs-target="#tab-{{$key}}-{{$keyPage}}" type="button" role="tab" aria-controls="tab-{{$key}}-{{$keyPage}}">
                                            {{$multi_page['name']}}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="tab-content">
                    {{-- Multiple page tab pane --}}
                    @if(isset($menu['multiple_page']))
                        <div class="tab-content" id="tab-tabContent">
                                @foreach($menu['multiple_page'] as $keyPage => $multi_page)
                                    <div class="tab-pane fade @if($loop->first) active show @endif"  id="tab-{{$key}}-{{$keyPage}}" role="tabpanel" aria-labelledby="tab-{{$key}}-{{$keyPage}}-trigger">
                                        @if($loop->first)
                                            @if(View::exists('admin.forms.plugins.'.$key.'.index', ['id' => $key.'[index]']))
                                                @include('admin.forms.plugins.'.$key.'.index', ['id' => $key.'[index]'])
                                            @else
                                                {{ trans('theme::admin.nothing_here') }}
                                            @endif
                                        @else
                                            @if(View::exists('admin.forms.plugins.'.$key.'.'.$keyPage))
                                                @include('admin.forms.plugins.'.$key.'.'.$keyPage, ['id' => $key.'['.$keyPage.']'])
                                            @endif
                                        @endif
                                    </div>
                               @endforeach
                        </div>
                    @else
                        @if(View::exists('admin.forms.plugins.'.$key.'.'.'index'))
                            @include('admin.forms.plugins.'.$key.'.index', ['id' => $key])
                        @else
                            {{ trans('theme::admin.nothing_here') }}
                        @endif
                    @endif
                </div>

            </div>
        </div>
        @endif
    @endforeach
</div>
