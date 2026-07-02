<span class="corner-top"></span>
<span class="corner-bottom"></span>
<ul class="d-flex flex-wrap align-items-center gap-3 gap-sm-4 p-0 m-0 list-unstyled">
    <li class="d-flex align-items-center"><a href="https://azuriom.com" target="_blank" title="Azuriom" data-bs-toggle="tooltip" rel="noopener noreferrer"><img src="{{ theme_asset('images/azuriom.svg') }}" width="17" height="17"></img></a></li>
    @foreach(social_links() as $link)
        <li>
            <a href="{{ $link->value }}"
               title="{{ $link->title }}"
               target="_blank"
               rel="noopener noreferrer"
               data-bs-toggle="tooltip">
                <i class="{{ $link->icon }} fs-5 social"></i>
            </a>
        </li>
    @endforeach
</ul>
