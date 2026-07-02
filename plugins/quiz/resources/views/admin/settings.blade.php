@extends('admin.layouts.admin')

@section('title', trans('quiz::admin.settings.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('quiz::admin.settings.title') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('quiz.admin.settings.save') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="delayHoursInput">{{ trans('quiz::admin.settings.delay_hours') }}</label>
                    <input type="number" class="form-control @error('delay_hours') is-invalid @enderror" id="delayHoursInput" name="delay_hours" value="{{ old('delay_hours', $delay_hours) }}" min="0">
                    @error('delay_hours')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="leaderboardSwitch" name="leaderboard" value="1" @checked($leaderboard)>
                        <label class="form-check-label" for="leaderboardSwitch">{{ trans('quiz::admin.settings.leaderboard_enabled') }}</label>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="adminResponsesSwitch" name="admin_responses" value="1" @checked($admin_responses)>
                        <label class="form-check-label" for="adminResponsesSwitch">{{ trans('quiz::admin.settings.admin_stats_enabled') }}</label>
                    </div>
                </div>

                <hr>

                <h6 class="text-uppercase text-muted">{{ trans('quiz::admin.settings.difficulty_rewards') }}</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-sm align-middle">
                        <thead>
                        <tr>
                            <th>{{ trans('quiz::admin.fields.difficulty') }}</th>
                            <th>{{ trans('quiz::admin.settings.reward_type') }}</th>
                            <th>{{ trans('quiz::admin.settings.reward_value') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(['easy', 'medium', 'hard'] as $difficulty)
                            <tr>
                                <td>{{ trans('quiz::admin.difficulties.' . $difficulty) }}</td>
                                <td>
                                    <select class="form-select" name="difficulty_rewards[{{ $difficulty }}][type]">
                                        <option value="points" @selected(($difficulty_rewards[$difficulty]['type'] ?? '') === 'points')>{{ trans('quiz::admin.settings.reward_points') }}</option>
                                        <option value="money" @selected(($difficulty_rewards[$difficulty]['type'] ?? '') === 'money')>{{ trans('quiz::admin.settings.reward_money') }}</option>
                                        <option value="item" @selected(($difficulty_rewards[$difficulty]['type'] ?? '') === 'item')>{{ trans('quiz::admin.settings.reward_item') }}</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="difficulty_rewards[{{ $difficulty }}][value]" value="{{ old('difficulty_rewards.' . $difficulty . '.value', $difficulty_rewards[$difficulty]['value'] ?? '') }}">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h6 class="text-uppercase text-muted">{{ trans('quiz::admin.settings.random_rewards') }}</h6>
                <div class="table-responsive mb-3">
                    <table class="table table-sm align-middle" id="randomRewardsTable">
                        <thead>
                        <tr>
                            <th>{{ trans('quiz::admin.settings.reward_type') }}</th>
                            <th>{{ trans('quiz::admin.settings.reward_value') }}</th>
                            <th>{{ trans('quiz::admin.settings.reward_probability') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($random_rewards as $index => $reward)
                            <tr>
                                <td>
                                    <select class="form-select" name="random_rewards[{{ $index }}][type]">
                                        <option value="points" @selected(($reward['type'] ?? '') === 'points')>{{ trans('quiz::admin.settings.reward_points') }}</option>
                                        <option value="money" @selected(($reward['type'] ?? '') === 'money')>{{ trans('quiz::admin.settings.reward_money') }}</option>
                                        <option value="item" @selected(($reward['type'] ?? '') === 'item')>{{ trans('quiz::admin.settings.reward_item') }}</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="random_rewards[{{ $index }}][value]" value="{{ old('random_rewards.' . $index . '.value', $reward['value'] ?? '') }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="random_rewards[{{ $index }}][probability]" value="{{ old('random_rewards.' . $index . '.probability', $reward['probability'] ?? 0) }}" min="0" step="0.01">
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-random-reward">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">{{ trans('quiz::admin.settings.no_random_rewards') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <button type="button" class="btn btn-sm btn-outline-success mb-4" id="addRandomReward">
                    <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
                </button>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection

@push('footer-scripts')
    <script>
        const randomRewardsTable = document.getElementById('randomRewardsTable').querySelector('tbody');
        const addRandomRewardButton = document.getElementById('addRandomReward');

        const rewardRowTemplate = (index) => `
            <tr>
                <td>
                    <select class="form-select" name="random_rewards[${index}][type]">
                        <option value="points">{{ trans('quiz::admin.settings.reward_points') }}</option>
                        <option value="money">{{ trans('quiz::admin.settings.reward_money') }}</option>
                        <option value="item">{{ trans('quiz::admin.settings.reward_item') }}</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control" name="random_rewards[${index}][value]" value="">
                </td>
                <td>
                    <input type="number" class="form-control" name="random_rewards[${index}][probability]" value="0" min="0" step="0.01">
                </td>
                <td class="text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-random-reward">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </td>
            </tr>`;

        const attachRemoveHandlers = () => {
            document.querySelectorAll('.remove-random-reward').forEach((button) => {
                button.addEventListener('click', () => {
                    const row = button.closest('tr');
                    row.remove();
                    if (randomRewardsTable.children.length === 0) {
                        randomRewardsTable.innerHTML = `<tr><td colspan="4" class="text-center text-muted">{{ trans('quiz::admin.settings.no_random_rewards') }}</td></tr>`;
                    }
                });
            });
        };

        attachRemoveHandlers();

        addRandomRewardButton.addEventListener('click', () => {
            if (randomRewardsTable.querySelector('td')) {
                randomRewardsTable.innerHTML = '';
            }
            const index = randomRewardsTable.querySelectorAll('tr').length;
            randomRewardsTable.insertAdjacentHTML('beforeend', rewardRowTemplate(index));
            attachRemoveHandlers();
        });
    </script>
@endpush
