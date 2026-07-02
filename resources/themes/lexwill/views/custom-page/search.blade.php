@extends('layouts.app')

@section('title', $page->title)
@section('description', $page->description)

@php
    $searchs   = new \Illuminate\Database\Eloquent\Collection;

        if(isset($_GET['q'])){
            $allPages = Azuriom\Models\Page::where('title', 'like','%'.$_GET['q'].'%')->get();
            $allArticles = Azuriom\Models\Post::where('title', 'like','%'.$_GET['q'].'%')->get();
            $allWiki = \Azuriom\Plugin\Wiki\Models\Page::where('title', 'like','%'.$_GET['q'].'%')->get();
        } else {
            $allPages = Azuriom\Models\Page::all();
            $allArticles = Azuriom\Models\Post::all();
            $allWiki = \Azuriom\Plugin\Wiki\Models\Page::all();
        }

   $searchs = collect($allPages)->map(function ($item) {
        $item['type'] = 'page';
        return $item;
    })
    ->merge($allArticles->map(function ($item) {
        $item['type'] = 'article';
        return $item;
    }))
    ->merge($allWiki->map(function ($item) {
        $item['type'] = 'wiki';
        return $item;
    }));
@endphp

@section('content')
    <hgroup>
        <h1>{{ $page->title }}</h1>
        <p>{!! $page->content !!}</p>
    </hgroup>

    <section class="blog-section">
        <div class="bg-wrapper each-element clearfix">
            <div class="container">
                <div class="row gy-4">
                    @forelse($searchs as $search)
                        @php
                            $pattern = '/\[(.*?)\]/';
                            preg_match($pattern, $search->title, $matches);
                            $tag = $matches[1] ?? null;
                            $title = str_replace("[$tag]", '', $search->title);

                            $slug = null;

                            if($search->type === "article"){
                                $slug =  route('posts.show', $search);
                            } elseif($search->type === "wiki") {
                                $slug =   route('wiki.show', $search->category->slug . '/' . $search->slug);
                            } else {
                                $slug =  route('pages.show', $search->slug);
                            }
                        @endphp

                        <div class="item col-lg-4 col-md-4 col-sm-12 col-sx-12">
                            <a href="{{$slug}}" class="item-wrap wow fadeInUp"
                               data-wow-duration="1s">
                                @if($search->image)
                                    <div class="image">
                                        <img height="234" src="{{ $search->imageUrl() }}" alt="{{ $search->title }}"
                                             class="img-responsive object-fit-cover">
                                    </div>
                                @endif
                                <div
                                    class="item-info equal-height @if(!$search->author || !$search->comments) rounded-4 @endif">
                                    <div class="item-header table fsize-14 fweight-700 uppercase">
                                        <div class="table-cell platform">{{$tag}}</div>
                                        <div
                                            class="table-cell color-2 text-right">{{$search->created_at->format('M d, Y')}}</div>
                                    </div>
                                    <div class="item-title mt20" data-trim="40">{{ $title }}</div>
                                    <div class="item-text mt25 lheight-26" data-trim="130">
                                        {{ Str::limit(strip_tags($search->content), 250)}}
                                    </div>
                                </div>
                                @if($search->author || $search->comments)
                                    <div class="author-comment table">
                                        @if($search->author)
                                            <div class="table-cell valign-middle">
                                                <i class="fa fa-user color-1 fsize-14" aria-hidden="true"></i>
                                                <span class="color-2 ml5">par {{ $search->author->name }}</span>
                                            </div>
                                        @endif
                                        @if($search->comments)
                                            <div class="table-cell valign-middle text-right">
                                                <i class="fa fa-comment color-1 fsize-14" aria-hidden="true"></i>
                                                <span class="color-2 ml5">{{ $search->comments->count() }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif


                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-search fs-2"></i>
                                <p class="fw-bold m-0">Aucun resultat concernant votre recherche</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
