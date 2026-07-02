<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">DUNGEONS</legend>
    <div class="d-flex flex-column flex-md-row gap-2">
        @for($i=1;$i<=5;$i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS {{$i}}</legend>
                <div class="d-flex flex-column gap-2">
                    <div>
                        @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[dungeons][link-'.$i.'][text]'])
                        @includeIf('components.forms.url', ['name' => 'url', 'id' => $id.'[dungeons][link-'.$i.'][url]'])
                    </div>
                    @includeIf('components.forms.switch', ['name' => 'Ouvrir dans un nouvel onglet', 'id' => $id.'[dungeons][link-'.$i.'][blank]'])
                </div>
            </fieldset>
        @endfor
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS UTILES</legend>
    <div class="d-flex flex-column flex-md-row gap-2">
        @for($i=1;$i<=5;$i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS {{$i}}</legend>
                <div class="d-flex flex-column gap-2">
                    <div>
                        @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[utility][link-'.$i.'][text]'])
                        @includeIf('components.forms.url', ['name' => 'url', 'id' => $id.'[utility][link-'.$i.'][url]'])
                    </div>
                    @includeIf('components.forms.switch', ['name' => 'Ouvrir dans un nouvel onglet', 'id' => $id.'[utility][link-'.$i.'][blank]'])
                </div>
            </fieldset>
        @endfor
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">AVANT CREDITS</legend>
    <div class="d-flex flex-column flex-md-row gap-2">
        @for($i=1;$i<=4;$i++)
            <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">LIENS {{$i}}</legend>
                <div class="d-flex flex-column gap-2">
                    <div>
                        @includeIf('components.forms.text', ['name' => 'Texte', 'id' => $id.'[important][link-'.$i.'][text]'])
                        @includeIf('components.forms.url', ['name' => 'url', 'id' => $id.'[important][link-'.$i.'][url]'])
                    </div>
                    @includeIf('components.forms.switch', ['name' => 'Ouvrir dans un nouvel onglet', 'id' => $id.'[important][link-'.$i.'][blank]'])
                </div>
            </fieldset>
        @endfor
    </div>
</fieldset>
