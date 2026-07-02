<div class="p-2 d-flex flex-column gap-3">
    <div class="row container gap-md-3">

        <div class="col-12 alert alert-info d-flex flex-column gap-2">
            @include('admin.components.forms.switch', [
                'direction' => 'row',
                'id' => $id.'[server][launcher][on]',
                'name' => trans('theme::admin.server_with_launcher')
            ])

            @include('admin.components.forms.text', [
                'id' => $id.'[server][launcher][url]',
                'name' => trans('theme::admin.form.link_of_page_to_download_launcher')
             ])

            @include('admin.components.forms.text', [
            'id' => $id.'[server][text]',
            'name' => trans('theme::admin.form.button_text')
            ])

            @include('admin.components.forms.text', [
             'id' => $id.'[server][ip]',
             'name' => trans('theme::admin.server_address')
            ])

        </div>
        <div class="col-lg-5 alert alert-info">
            @include('admin.components.forms.url', [
                'id' => $id.'[discord][link]',
                'name' => trans('theme::admin.your_discord_link'),
                'placeholder' => "https://discord.gg/ZdSPkxK5xT"
            ])
        </div>
        <div class="col-lg-5 alert alert-info">
            @include('admin.components.forms.text', [
                'id' => $id.'[discord][id]',
                'nameToUpper' => false,
                'name' => strtoupper(trans('theme::admin.your_id_discord')).' <a href="https://www.youtube.com/watch?v=7CXfutvFdsE" target="_blank" rel="noopener, nofollow">'.trans('theme::admin.how_to_get_our_id').'</a>',
                'placeholder' => "1025845189115400303",
            ])
        </div>
    </div>
</div>
