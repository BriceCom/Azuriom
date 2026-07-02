<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Hero</legend>
    <div class="d-flex flex-column gap-2">
        @includeIf('components.forms.text', ['name' => 'Titre', 'id' => $id.'[hero][title]'])
        @includeIf('components.forms.text', ['name' => 'Sous-titre', 'id' => $id.'[hero][subtitle]'])
    </div>
</fieldset>
<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Contenu</legend>
    <div class="d-flex flex-column gap-2">
        <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Récompenses top voteurs</legend>

            <div class="d-flex flex-row flex-wrap gap-2">
                @for($i = 1; $i<=10;$i++)
                    @includeIf('components.forms.text', ['name' => 'Récompense voteur ('.$i.')', 'id' => $id.'[top-vote-reward]['.$i.']'])
                @endfor
            </div>
        </fieldset>
    </div>
</fieldset>

