<x-admin.card :title="trans('theme::admin.menus.settings.discord')" :icon="'bi bi-discord'">
    @include('admin.components.forms.url', [
                'id' => $id.'[link]',
                'name' => trans('theme::admin.your_discord_link'),
                'placeholder' => "https://discord.gg/ZdSPkxK5xT"
            ])

    @include('admin.components.forms.text', [
                'id' => $id.'[id]',
                'nameToUpper' => false,
                'name' => strtoupper(trans('theme::admin.your_id_discord')).' <a href="https://www.youtube.com/watch?v=7CXfutvFdsE" target="_blank" rel="noopener, nofollow">'.trans('theme::admin.how_to_get_our_id').'</a>',
                'placeholder' => "1025845189115400303",
            ])
</x-admin.card>
