@php($servers = Azuriom\Models\Server::all())
<div class="d-flex flex-column gap-4">
    @if(! $servers->isEmpty())
        @foreach($servers as $server)
            @php($str = str_replace(' ', '_', $server->name))
            @include('admin.components.forms.image-azuriom', ['name' => 'Background serveur: '.$str, 'id' => $id.'[bg]['.$str.']'])
        @endforeach
    @endif
</div>
