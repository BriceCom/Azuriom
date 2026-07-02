<fieldset class="d-flex flex-column gap-3 border p-2 w-100">
    <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Récompenses top voteurs</legend>

    <div class="d-flex flex-wrap gap-2">
        @for($i = 1; $i<=12;$i++)
            @includeIf('admin.components.forms.text', ['name' => 'Récompense voteur ('.$i.')', 'id' => $id.'[top-vote-reward]['.$i.']'])
        @endfor
    </div>
</fieldset>
