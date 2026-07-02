<div class="p-2 d-flex flex-column flex-md-row gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Page</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'). " Choisir sur quel site voter", 'id' => $id.'[chooseSiteText]'])
        </div>
    </fieldset>
</div>

<div class="p-2 d-flex flex-column flex-md-row gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Section récompense</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[rewardTitle]'])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[rewardText]'])
        </div>
    </fieldset>
</div>


<div class="p-2 d-flex flex-column flex-md-row gap-3">
    <fieldset class="d-flex flex-column gap-3 border p-2 w-100">
        <legend class="float-none w-auto p-2 py-0 bg-dark text-white text-lg">Section classement</legend>
        <div class="d-flex flex-column gap-2">
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[topTitle]'])
            @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[topText]'])
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

            <div class="d-flex flex-wrap gap-2 mt-3">

                @for($i=1; $i<=10; $i++ )
                    <div class="col-lg-6 d-flex flex-row align-items-center gap-2">
                        @include('admin.components.forms.text', ['name' => trans('theme::admin.vote.reward_number', ['number' => $i]), 'id' => $id.'[rewards][top]['.$i.']'])
                        @include('admin.components.forms.color', ['name' => trans('theme::admin.form.color.color'), 'id' => $id.'[rewards][topColor]['.$i.']', 'value' => '#1E1E1E'])
                    </div>
                @endfor
            </div>
        </div>
    </fieldset>
</div>
