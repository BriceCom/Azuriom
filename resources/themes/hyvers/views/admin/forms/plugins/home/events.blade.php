<div class="mb-3">
@include('admin.components.forms.switch', [
                'direction' => 'row',
                'id' => $id.'[off]',
                'name' => trans('theme::admin.disable')
            ])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])
</div>

@for($i=1;$i<=4;$i++)
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Event {{$i}}</legend>
            <div class="d-flex flex-column gap-2">
                @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[events]['.$i.'][text]'])
                @include('admin.components.forms.text', ['name' => trans('theme::admin.form.icon'), 'id' => $id.'[events]['.$i.'][icon]'])
            </div>
    </fieldset>
    @endfor
