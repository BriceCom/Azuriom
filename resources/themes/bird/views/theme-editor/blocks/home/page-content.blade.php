@component('theme-editor.blocks.home.partials.te-block-shell', [
    'blockId' => 'page_content',
    'params' => $params ?? [],
    'class' => 'te-page-content-block my-5',
])
    @if(isset($slot) && trim((string) $slot) !== '')
        {{ $slot }}
    @else
        <div>
            Il y a un problème, contactez le support du thème.
        </div>
    @endif
@endcomponent
