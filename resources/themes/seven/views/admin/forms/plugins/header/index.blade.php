<div class="p-2 d-flex flex-column gap-3">

<div onchange="handleOptionChange()">
        @include('admin.components.forms.select', [
        'name' => 'Variant',
        'id' => $id.'[variant]',
        'options' => [
            ['value' => '0','text' => 'Variant 1'],
            ['value' => '1','text' => 'Variant 2'],
         ],
         'onchange'=> "handleOptionChange(this)"
    ])
</div>

<div id="toto" class="@if(theme_config('header.index.variant') == 2) d-flex @endif ">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Logo</legend>
        @include('admin.components.forms.range', ['name' => trans('theme::admin.pixel'), 'id' => $id.'[hero][img][height]', 'value' => 430,'max' => 500, 'min' => 64, 'step' => 1])
    </fieldset>
</div>

<script>
    function handleOptionChange() {
        const extraFields = document.getElementById('header_index_variant');

        if (extraFields.value == 1) {
            document.getElementById('toto').classList.remove('d-none');
        } else {
            document.getElementById('toto').classList.add('d-none');
        }
    }
</script>
</div>

