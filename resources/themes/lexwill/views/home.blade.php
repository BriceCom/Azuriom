@extends('layouts.base')

@section('title', trans('messages.home'))

@section('app')

    <!-- PRELOADER START -->
{{--    <div class="loader-wrapper">--}}
{{--        <div class='cssload-loader'>--}}
{{--            <div class='cssload-inner cssload-one'></div>--}}
{{--            <div class='cssload-inner cssload-two'></div>--}}
{{--            <div class='cssload-inner cssload-three'></div>--}}
{{--        </div>--}}
{{--    </div>--}}

    @include('components.slider')

    <div>
        @include('elements.session-alerts')

        @if($message)
            <div class="card mb-4">
                <div class="card-body">
                    {{ $message }}
                </div>
            </div>
        @endif

        <!-- GAME SECTION START -->
        <section class="game-section pt150 pb85">
            <div class="container">
                <div class="row">
                    @if(theme_config('staff.index.players'))
                        <div class="title-bl text-center wow fadeIn" data-wow-duration="2s">
                            <div class="title color-white">
                                {{ theme_config('staff.index.title') ?? "Notre équipe" }}
                            </div>
                            <div class="subtitle">
                                {{ theme_config('staff.index.title') ?? "Notre équipe" }}
                            </div>
                        </div>
                    @endif
                    <div class="tm-tabs tabs mt70">
                        @include('components.staff')

                        @if(theme_config('block.index'))
                            <div class="tab-content relative mt90"  style="font-size-adjust: {{theme_config('block.index.fontSize') != 0 ?  theme_config('block.index.fontSize'):"unset"}};">
                                <div class="tab-pane fade active in text-left clearfix show" id="tab-item-1">
                                    <div class="tab-info col-lg-6 col-md-12 col-sm-12 col-xs-12 ptb90 pl100 equal-height">
                                        <div class="tab-head table uppercase fsize-14 fweight-700">
                                            <div class="table-cell valign-middle ws-20 color-1">
                                                @if(theme_config('block.index.tags'))
                                                    @foreach(theme_config('block.index.tags') as $tag)
                                                        {{$tag['text']}}
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="table-cell valign-middle text-end">
                                                {{ theme_config('block.index.date') ?? "" }}
                                            </div>
                                        </div>
                                        <div class="uppercase fsize-32 fweight-700 font-agency color-white lheight-normal">
                                            {{ theme_config('block.index.title') ?? "" }}
                                        </div>
                                        <div class="mt50 lheight-26 fweight-300">
                                            {!! theme_config('block.index.text') ?? ""  !!}
                                        </div>
                                        <div class="mt60 table g-bottom">
                                            <div class="table-cell valign-middle">
                                                @if(theme_config('block.index.button.text'))
                                                    <a href="{{ theme_config('block.index.button.url') }}" @if(theme_config('block.index.target')) target="_blank" @endif class="btn gradient color-white plr60 ptb19">
                                                        {{theme_config('block.index.button.text')}}
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="rating table-cell valign-middle text-right">
                                                @if(theme_config('block.index.rating'))
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= theme_config('block.index.rating'))
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa fa-star-o" aria-hidden="true"></i>
                                                        @endif
                                                    @endfor
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-img col-lg-6 col-md-12 col-sm-12 col-xs-12 pr0 equal-height">
                                        <div class="image-bl">
                                            @if(theme_config('block.index.img'))
                                            <img aria-hidden="true" class="game-full-img object-fit-cover" src="{{image_url(theme_config('block.index.img'))}}" alt="">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- GAME SECTION END -->

        <!-- BLOG SECTION START -->
        @if(! $posts->isEmpty())
            @include('components.articles')
        @endif
        <!-- BLOG SECTION END -->

        @include('components.avis')

        @include('components.newsletter')
    </div>
@endsection
