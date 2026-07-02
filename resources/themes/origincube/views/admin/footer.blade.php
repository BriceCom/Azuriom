<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LOGO</legend>
    <div class="d-flex flex-column flex-md-row gap-2">
        @includeIf('admin.components.forms.image-azuriom', ['name' => 'Image', 'id' => $id.'[image]'])
        <div class="flex-grow-1">
            @includeIf('admin.components.forms.range', ['name' => 'Hauteur max', 'id' => $id.'[imageHeightMax]', 'value' => 0, 'min' => 1, 'step' => 1, 'max' => 800])
        </div>
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">NOTRE SITE WEB</legend>
    <div class="d-flex flex-column flex-md-row gap-2">
        @for($i=1;$i<=5;$i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS {{$i}}</legend>
                <div class="d-flex flex-column gap-2">
                    <div>
                        @includeIf('admin.components.forms.text', ['name' => 'Texte', 'id' => $id.'[urWeb][link-'.$i.'][text]'])
                        @includeIf('admin.components.forms.url', ['name' => 'url', 'id' => $id.'[urWeb][link-'.$i.'][url]'])
                    </div>
                    @includeIf('admin.components.forms.switch', ['name' => 'Ouvrir dans un nouvel onglet', 'id' => $id.'[urWeb][link-'.$i.'][blank]'])
                </div>
            </fieldset>
        @endfor
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">NOUS SOUTENIR</legend>
    <div class="d-flex flex-column flex-md-row gap-2">
        @for($i=1;$i<=5;$i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS {{$i}}</legend>
                <div class="d-flex flex-column gap-2">
                    <div>
                        @includeIf('admin.components.forms.text', ['name' => 'Texte', 'id' => $id.'[supportUs][link-'.$i.'][text]'])
                        @includeIf('admin.components.forms.url', ['name' => 'url', 'id' => $id.'[supportUs][link-'.$i.'][url]'])
                    </div>
                    @includeIf('admin.components.forms.switch', ['name' => 'Ouvrir dans un nouvel onglet', 'id' => $id.'[supportUs][link-'.$i.'][blank]'])
                </div>
            </fieldset>
        @endfor
    </div>
</fieldset>
