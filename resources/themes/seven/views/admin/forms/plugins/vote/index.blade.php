<div class="p-2 d-flex flex-column flex-md-row gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">{{trans('theme::admin.form.text')}}</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title') . trans('theme::admin.form.logout_brackets'), 'id' => $id.'[title]'])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text') . trans('theme::admin.form.logout_brackets'), 'id' => $id.'[text]'])
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
                    @include('admin.components.forms.text', ['name' => trans('theme::admin.vote.reward_number', ['number' => $i]), 'id' => $id.'[rewards][top]['.$i.']'])
                @endfor
            </div>
        </div>
    </fieldset>
</div>
