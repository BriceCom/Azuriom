<x-admin.card :title="trans('theme::admin.menus.premium.name')"
              :subtitle="trans('theme::admin.what_the_advanced_mode')"
              :icon="'bi bi-star-fill'">
    <p class="m-0">{{trans('theme::admin.active_premium')}}</p>

    @include('admin.components.forms.url', [
                   'id' => $id.'[serveurliste][link]',
                   'name' => trans('theme::admin.link_of_your_server_on'),
                   'placeholder' => "https://www.serveurliste.com/minecraft/your_server",
                   'pattern' => '^(https?:\/\/)?(www\.)?serveurliste\.com\/[^\/]+\/.+'
               ])

    @include('admin.components.forms.text', [
               'id' => $id.'[serveurliste][token]',
               'name' => trans('theme::admin.link_of_your_server_token'),
               'placeholder' => "***********************************"
           ])
</x-admin.card>
