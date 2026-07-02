<div class="p-2 d-flex flex-column gap-3">
    <div class="row container gap-md-3">
        <div class="col-12 alert alert-info">
            @include('admin.components.forms.text', [
                'id' => $id.'[server][text]',
                'name' => "Texte du boutton nous rejoindre"
            ])
        </div>
        <div class="col-12 alert alert-info">
            @include('admin.components.forms.text', [
                'id' => $id.'[server][url]',
                'name' => "Lien du bouton nous rejoindre"
            ])
        </div>
{{--        <div class="col-lg-5 alert alert-info">--}}
{{--            @include('admin.components.forms.url', [--}}
{{--                'id' => $id.'[discord][link]',--}}
{{--                'name' => trans('theme::admin.your_discord_link'),--}}
{{--                'placeholder' => "https://discord.gg/ZdSPkxK5xT"--}}
{{--            ])--}}
{{--        </div>--}}
{{--        <div class="col-lg-5 alert alert-info">--}}
{{--            @include('admin.components.forms.text', [--}}
{{--                'id' => $id.'[discord][id]',--}}
{{--                'nameToUpper' => false,--}}
{{--                'name' => strtoupper(trans('theme::admin.your_id_discord')).' <a href="https://www.youtube.com/watch?v=Pslqx3lSu_8" target="_blank" rel="noopener, nofollow">'.trans('theme::admin.how_to_get_our_id').'</a>',--}}
{{--                'placeholder' => "1025845189115400303",--}}
{{--            ])--}}
{{--        </div>--}}
    </div>
</div>
