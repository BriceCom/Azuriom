<section class="blog-section ptb90">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-bl text-center wow fadeIn" data-wow-duration="2s">
                    <div class="title color-white">
                        Dernières nouveautés
                    </div>
                    <div class="subtitle">
                        Dernières nouveautés
                    </div>
                </div>
                <div class="title-description mt30 fweight-300 text-center">
                    Pork chop pastrami meatball, picanha salami capicola drumstick tri-tip flank short loin
                    <br/> strip steak prosciutto leberkas jowl fatback.
                </div>
            </div>
        </div>
    </div>
    <div class="bg-wrapper each-element mt90 clearfix">
        <div class="container">
            <div class="row gy-4">

                @foreach($posts->take(3) as $post)
                    @php
                        $pattern = '/\[(.*?)\]/';
                          preg_match($pattern, $post->title, $matches);
                          $tag = $matches[1] ?? null;
                          $title = str_replace("[$tag]", '', $post->title);
                    @endphp
                    <div class="item col-lg-4 col-md-4 col-sm-12 col-sx-12">
                        <a href="{{ route('posts.show', $post) }}" class="item-wrap">
                            @if($post->hasImage())
                                <div class="image">
                                    <img height="234" src="{{ $post->imageUrl() }}" alt="{{ $post->title }}"
                                         class="img-responsive object-fit-cover">
                                </div>
                            @endif
                            <div class="item-info equal-height">
                                <div class="item-header table fsize-14 fweight-700 uppercase">
                                    <div class="table-cell platform">{{$tag}}</div>
                                    <div class="table-cell color-2 text-right">{{$post->created_at->format('M d, Y')}}</div>
                                </div>
                                <div class="item-title mt20" data-trim="40">{{ $title }}</div>
                                <div class="item-text mt25 lheight-26" data-trim="130">
                                    {{strip_tags($post->content)}}
                                </div>
                            </div>
                            <div class="author-comment table">
                                <div class="table-cell valign-middle">
                                    <i class="fa fa-user color-1 fsize-14" aria-hidden="true"></i>
                                    <span class="color-2 ml5">par {{ $post->author->name }}</span>
                                </div>
                                <div class="table-cell valign-middle text-right">
                                    <i class="fa fa-comment color-1 fsize-14" aria-hidden="true"></i>
                                    <span class="color-2 ml5">{{ $post->comments->count() }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
