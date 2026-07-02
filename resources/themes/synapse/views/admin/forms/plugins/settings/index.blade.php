<div class="p-2 d-flex flex-column gap-3">
    <div class="d-flex flex-wrap">
        <div class="alert alert-info">
            @include('admin.components.forms.url', [
                'id' => $id.'[discord][link]',
                'name' => trans('theme::admin.your_discord_link'),
                'placeholder' => "https://www.serveurliste.com/minecraft/your_server"
            ])
        </div>
        <div class="alert alert-info w-50 ms-md-3">
            @include('admin.components.forms.text', [
                'id' => $id.'[discord][id]',
                'nameToUpper' => false,
                'name' => strtoupper(trans('theme::admin.your_id_discord')).' <a href="https://www.youtube.com/watch?v=7CXfutvFdsE" target="_blank" rel="noopener, nofollow">'.trans('theme::admin.how_to_get_our_id').'</a>',
                'placeholder' => "1025845189115400303",
            ])
        </div>
    </div>


    <div class="alert alert-warning">
        @include('admin.components.forms.text', [
            'id' => $id.'[server][ip]',
            'name' => trans('theme::admin.server_ip'),
        ])
    </div>
</div>
