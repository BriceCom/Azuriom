@include('admin.components.forms.switch', ['name' => 'Ne pas afficher', 'id' => $id.'[show]', 'direction' => 'row'])

@for($i = 1; $i <= 3; $i++)
    @include('admin.components.forms.text', ['id' => $id.'[stats]['.$i.']','name' => 'Stat '.$i])
@endfor
