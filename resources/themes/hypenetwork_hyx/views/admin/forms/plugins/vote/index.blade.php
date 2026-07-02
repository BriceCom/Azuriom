<div class="p-2 d-flex flex-column gap-3">

    @include('admin.components.forms.image-azuriom', ['name' => 'Image récompense', 'id' => $id.'[rewardImg]'])

    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Récompenses</legend>
        <div class="d-flex flex-wrap gap-2">
            @for($i = 1; $i <= 10; $i++)
                    @include('admin.components.forms.text', ['name' => 'Récompense '.$i, 'id' => $id.'[reward]['.$i.']'])
            @endfor
        </div>
    </fieldset>

</div>
