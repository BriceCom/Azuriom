<a class="twitter-timeline" href="{{theme_config('block.twitter.url') ?? 'https://twitter.com/TwitterDev?ref_src=twsrc%5Etfw'}}"
   data-height="{{$height ?? 400}}"
   data-tweet-limit="{{$limit}}"
   data-theme="{{$theme}}"
   data-lang="{{ str_replace('_', '-', app()->getLocale()) }}">
</a>
