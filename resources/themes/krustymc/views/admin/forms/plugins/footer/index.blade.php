<div class="p-2 d-flex flex-column gap-3">
{{--    <div class="d-flex flex-wrap gap-3">--}}
{{--        <fieldset class="d-flex flex-column gap-3 border border-warning p-2 w-50">--}}
{{--            <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">⭐ {{trans('theme::admin.footer.copyright')}}</legend>--}}
{{--            @include('admin.components.forms.switch', [--}}
{{--                'direction' => 'row',--}}
{{--                'id' => $id.'[dixept_copyright][off]',--}}
{{--                'name' => trans('theme::admin.footer.index.dixept_copyright.off')--}}
{{--            ])--}}
{{--        </fieldset>--}}
{{--    </div>--}}

    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])

@for($i=1;$i<=2;$i++)
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.form.links').' '. $i}}</legend>
            <div class="d-flex flex-column gap-2">
                @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[links]['.$i.'][title]'])

                @for($j=1;$j<=5;$j++)
                    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
                        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.form.links') .' '.$j}}</legend>
                        <div class="d-flex flex-column align-items-md-center flex-md-row gap-2">
                            @include('admin.components.forms.switch', [
                                'direction' => 'row',
                                'id' => $id.'[links]['.$i.']['.$j.'][blank]',
                                'name' => trans('theme::admin.form.blank')
                            ])
                            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[links]['.$i.'][links]['.$j.'][text]'])
                            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.link'), 'id' => $id.'[links]['.$i.'][links]['.$j.'][url]'])
                        </div>
                    </fieldset>
                @endfor
            </div>
    </fieldset>
    @endfor
</div>
