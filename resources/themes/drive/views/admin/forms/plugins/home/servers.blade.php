<x-admin.card :title="trans('theme::admin.menus.home.servers')">
    @include('admin.components.forms.switch', [
              'direction' => 'row',
              'id' => $id.'[on]',
              'name' => trans('theme::admin.enable')
          ])
</x-admin.card>
