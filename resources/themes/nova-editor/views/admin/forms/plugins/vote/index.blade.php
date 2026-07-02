<x-admin.card :title="trans('theme::admin.vote.page')">
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[title]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[text]'])
</x-admin.card>

<x-admin.card :title="trans('theme::admin.vote.reward_section')">
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[rewardTitle]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[rewardText]'])
</x-admin.card>

<x-admin.card :title="trans('theme::admin.vote.leaderboard_section')">
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.title'), 'id' => $id.'[topTitle]'])
    @include('admin.components.forms.text', ['name' => trans('theme::admin.form.text'), 'id' => $id.'[topText]'])
</x-admin.card>

<x-admin.card :title="trans('theme::admin.vote.rewards_leaderboard')">

    @include('admin.components.forms.switch', [
                           'id' => $id.'[rewards][on]',
                           'direction' => 'row',
                           'name' => trans('theme::admin.vote.rewards_on')
                           ])

    @include('admin.components.forms.text', ['name' => trans('theme::admin.text_in_the_table'), 'id' => $id.'[rewards][text]'])

    <div class="d-flex flex-wrap gap-1">
        @for($i=1; $i<=10; $i++ )
            <div class="col-lg-6 d-flex flex-row align-items-center gap-2">
                @include('admin.components.forms.text', ['name' => trans('theme::admin.vote.reward_number', ['number' => $i]), 'id' => $id.'[rewards][top]['.$i.']'])
                @include('admin.components.forms.color', ['name' => trans('theme::admin.form.color.color'), 'id' => $id.'[rewards][topColor]['.$i.']', 'value' => '#FF0000'])
            </div>
        @endfor

{{--    For the next version illimied rewards settings    --}}
{{--        @include('admin.components.forms.list-input', ['id' => 'vote', 'name' => $id.'[reward]', 'inputColor' => true, 'values' => theme_config('vote.index.reward') ?? []])--}}
    </div>
</x-admin.card>
