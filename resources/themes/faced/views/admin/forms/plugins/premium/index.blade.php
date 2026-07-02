<div class="p-2 d-flex flex-column gap-3">

    <p class="w-100 alert alert-warning mb-0">{{trans('theme::admin.active_premium')}}</p>

    <div class="row container gap-md-3">
        <div class="col-lg-5 alert alert-warning">
            @include('admin.components.forms.url', [
                'id' => $id.'[serveurliste][link]',
                'name' => trans('theme::admin.link_of_your_server_on'),
                'placeholder' => "https://www.serveurliste.com/minecraft/your_server",
                'pattern' => '^https:\/\/www\.serveurliste\.com\/.*'
            ])
        </div>
        <div class="col-lg-5 alert alert-warning">
            @include('admin.components.forms.text', [
                'id' => $id.'[serveurliste][token]',
                'name' => trans('theme::admin.link_of_your_server_token'),
                'placeholder' => "***********************************"
            ])
        </div>
    </div>
</div>
