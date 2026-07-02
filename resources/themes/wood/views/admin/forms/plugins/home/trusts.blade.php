<div class="mb-3">
@include('admin.components.forms.switch', [
                'direction' => 'row',
                'id' => $id.'[off]',
                'name' => trans('theme::admin.disable')
            ])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
</div>

@for($i=1;$i<=4;$i++)
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Trust {{$i}}</legend>
            <div class="d-flex flex-column gap-2">
                @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[trusts]['.$i.'][title]'])
                @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[trusts]['.$i.'][text]'])
                @include('admin.components.forms.text', ['name' => trans('theme::admin.form.icon'), 'id' => $id.'[trusts]['.$i.'][icon]'])
                @include('admin.components.forms.color', ['name' => trans('theme::admin.form.color.color'), 'id' => $id.'[trusts]['.$i.'][color]', 'value' => '#F0FFAC'])
            </div>
    </fieldset>
    @endfor