<div class="p-2 d-flex flex-column flex-md-row gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.form.text')}}</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text') . trans('theme::admin.form.logout_brackets'), 'id' => $id.'[logout][text]'])
        </div>
    </fieldset>
</div>

<div class="p-2 d-flex flex-column flex-md-row gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.vote.rewards_top_vote')}}</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.switch', [
                           'id' => $id.'[rewards][on]',
                           'direction' => 'row',
                           'name' => trans('theme::admin.vote.rewards_on')
                           ])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[rewards][text]'])


            <div class="d-flex flex-wrap gap-2 mt-3">

                @for($i=1; $i<=10; $i++ )
                    <div class="col-lg-6 d-flex flex-row align-items-center gap-2">
                        @include('admin.components.forms.text', ['name' => trans('theme::admin.vote.reward_number', ['number' => $i]), 'id' => $id.'[rewards][top]['.$i.']'])
                        @include('admin.components.forms.color', ['name' => trans('theme::admin.form.color.color'), 'id' => $id.'[rewards][topColor]['.$i.']', 'value' => '#F8D32E'])
                    </div>
                @endfor
            </div>
        </div>
    </fieldset>
</div>
