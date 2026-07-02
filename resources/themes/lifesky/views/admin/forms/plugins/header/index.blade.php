<div class="p-2 d-flex flex-column gap-3">
    @include('admin.components.forms.text', [
        'id' => $id.'[btn][text]',
        'name' => "Texte boutton"
    ])
    @include('admin.components.forms.text', [
        'id' => $id.'[btn][url]',
        'name' => "Lien boutton"
    ])
</div>
