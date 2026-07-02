<div class="p-2 d-flex flex-column gap-3">
    <div class="row container gap-md-3">
        <div class="col-lg-5 alert alert-info">
            @include('admin.components.forms.url', [
                'id' => $id.'[discord][link]',
                'name' => trans('theme::admin.your_discord_link'),
                'placeholder' => "https://discord.gg/ZdSPkxK5xTr"
            ])
        </div>
        <div class="col-lg-5 alert alert-info">
            @include('admin.components.forms.text', [
                'id' => $id.'[discord][id]',
                'name' => "ID Discord"
            ])
        </div>
        <div class="col-lg-12 alert alert-info">
            @include('admin.components.forms.text', [
                'id' => $id.'[server][ip]',
                'name' => "IP du serveur"
            ])
        </div>
    </div>
</div>
