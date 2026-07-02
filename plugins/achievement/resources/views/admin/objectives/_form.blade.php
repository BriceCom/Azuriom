@csrf

<div class="mb-3 form-check form-switch">
    <input type="checkbox" class="form-check-input" id="enableSwitch" name="is_enabled" value="1" @checked($objective->is_enabled ?? true)>
    <label class="form-check-label" for="enableSwitch">{{ trans('messages.fields.enabled') }}</label>
</div>

<div class="mb-3">
    <label class="form-label" for="nameInput">{{ trans('messages.fields.name') }}</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name', $objective->name ?? '') }}" required>

    @error('name')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="row">
    <div class="mb-3 col-md-4">
        <label class="form-label" for="hookSelect">{{ trans('achievement::admin.objectives.fields.hook') }}</label>
        <select class="form-select @error('hook') is-invalid @enderror" id="hookSelect" name="hook" required v-scope="{ hook: '{{ old('hook', $objective->hook ?? 'azuriom') }}' }">
            @foreach($hooks as $value => $label)
                <option value="{{ $value }}" @selected(old('hook', $objective->hook ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>

        @error('hook')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="mb-3 col-md-4">
        <label class="form-label" for="triggerSelect">{{ trans('achievement::admin.objectives.fields.trigger') }}</label>
        <select class="form-select @error('trigger') is-invalid @enderror" id="triggerSelect" name="trigger" required>
            @foreach($triggers as $hook => $hookTriggers)
                @foreach($hookTriggers as $value => $label)
                    <option value="{{ $value }}" data-hook="{{ $hook }}" @selected(old('trigger', $objective->trigger ?? '') === $value)>{{ $label . " | (" . $value . ")" }}</option>
                @endforeach
            @endforeach
        </select>

        @error('trigger')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror

        <div id="shop-trigger-help" style="display: none;">
            <small class="form-text text-muted mt-2">
                <strong>{{ trans('achievement::admin.objectives.shop_triggers_explanation') }}</strong><br>
                • <strong>spent:</strong> {{ trans('achievement::admin.objectives.shop_spent_description') }}<br>
                • <strong>points_spent:</strong> {{ trans('achievement::admin.objectives.shop_points_spent_description') }}
            </small>
        </div>
    </div>

    <div class="mb-3 col-md-4">
        <label class="form-label" for="amountInput">{{ trans('achievement::admin.objectives.fields.amount') }}</label>
        <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amountInput" name="amount" value="{{ old('amount', $objective->amount ?? '1') }}" min="1" required>

        @error('amount')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="descriptionInput">{{ trans('messages.fields.description') }}</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="descriptionInput" name="description" rows="3" required>{{ old('description', $objective->description ?? '') }}</textarea>

    @error('description')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="startDateInput">{{ trans('achievement::admin.objectives.fields.start_date') }}</label>
    <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" id="startDateInput" name="start_date" value="{{ old('start_date', isset($objective) && $objective->start_date ? $objective->start_date->format('Y-m-d\TH:i') : '') }}">
    <small class="form-text">{{ trans('achievement::admin.objectives.fields.start_date_info') }}</small>

    @error('start_date')
    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">{{ trans('achievement::admin.objectives.fields.visibility') }}</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="visibility" id="visibility_public" value="public" @checked(old('visibility', $objective->visibility ?? 'public') === 'public')>
        <label class="form-check-label" for="visibility_public">
            {{ trans('achievement::admin.objectives.visibility.public') }}
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="visibility" id="visibility_role" value="role" @checked(old('visibility', $objective->visibility ?? '') === 'role')>
        <label class="form-check-label" for="visibility_role">
            {{ trans('achievement::admin.objectives.visibility.role') }}
        </label>
    </div>
    <div id="role_visibility_container" class="mt-2 d-none">
        <select class="form-select @error('visibility_roles') is-invalid @enderror" id="visibility_roles" name="visibility_roles[]" multiple>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" @selected((old('visibility_roles') && in_array($role->id, old('visibility_roles'))) || (isset($objective) && $objective->roles->contains($role->id)))>{{ $role->name }}</option>
            @endforeach
        </select>
        @error('visibility_roles')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<h2 class="h4">{{ trans('achievement::admin.objectives.rewards_title') }}</h2>

<div id="rewards" v-scope="{ rewards: {{ json_encode(old('rewards', $objective->rewards ?? [])) }}, addReward() { this.rewards.push({type: 'money', value: '10'}); }, removeReward(index) { this.rewards.splice(index, 1); } }">
    <div class="card mb-3" v-for="(reward, i) in rewards" :key="i">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label class="form-label" :for="'rewardTypeSelect' + i">{{ trans('achievement::admin.objectives.fields.reward_type') }}</label>
                    <select class="form-select reward-type" :id="'rewardTypeSelect' + i" :name="'rewards[' + i + '][type]'" v-model="reward.type" required>
                        <option value="money">{{ trans('achievement::admin.objectives.rewards.money') }}</option>
                        <option value="command">{{ trans('achievement::admin.objectives.rewards.command') }}</option>
                        <option value="trophy">{{ trans('achievement::admin.objectives.rewards.trophy') }}</option>
                        @if(($scratchGameEnabled ?? false) === true && count($scratchCards ?? []) > 0)
                            <option value="scratch_game">{{ trans('achievement::admin.objectives.rewards.scratch_game') }}</option>
                        @endif
                    </select>
                </div>

                <div class="mb-3 col-md-4">
                    <label class="form-label" :for="'rewardValueInput' + i">{{ trans('achievement::admin.objectives.fields.reward_value') }}</label>

                    <div v-if="reward.type === 'money'" class="money-input">
                        <div class="input-group">
                            <input type="number" class="form-control" :id="'rewardValueInput' + i" :name="'rewards[' + i + '][value]'" v-model="reward.value" min="1" required>
                            <span class="input-group-text">{{ money_name() }}</span>
                        </div>
                    </div>

                    <div v-else-if="reward.type === 'command'" class="command-input border border-1 rounded-2 p-2">
                        <label class="form-label" :for="'rewardNameInput' + i">{{ trans('messages.fields.name') }}</label>
                        <input type="text" class="form-control mb-2" :id="'rewardNameInput' + i" :name="'rewards[' + i + '][name]'" v-model="reward.name" placeholder="{{ trans('messages.fields.name') }}">
                        <label class="form-label" :for="'rewardValueInput' + i">{{ trans('achievement::admin.objectives.fields.reward_value') }}</label>
                        <input type="text" class="form-control" :id="'rewardValueInput' + i" :name="'rewards[' + i + '][value]'" v-model="reward.value" required>
                        <small class="form-text">{{ trans('achievement::admin.objectives.command_info') }}</small>
                    </div>


                    <div v-else-if="reward.type === 'trophy'" class="trophy-input">
                        <div class="input-group">
                            <input type="number" class="form-control" :id="'rewardValueInput' + i" :name="'rewards[' + i + '][value]'" v-model="reward.value" min="1" required>
                            <span class="input-group-text">{{ achievement_trophy_name() }}</span>
                        </div>
                    </div>
                    @if(($scratchGameEnabled ?? false) === true && count($scratchCards ?? []) > 0)
                    <div v-else-if="reward.type === 'scratch_game'" class="scratch-input">
                        <select class="form-select" :id="'rewardValueInput' + i" :name="'rewards[' + i + '][value]'" v-model="reward.value" required>
                            <option value="" disabled>{{ trans('achievement::admin.objectives.fields.scratch_game_select') }}</option>
                            @foreach(($scratchCards ?? []) as $card)
                                <option value="{{ $card->id }}">{{ $card->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                </div>

                <div v-if="reward.type === 'command'" class="mb-3 col-md-3 server-select">
                    <label class="form-label" :for="'rewardServerSelect' + i">{{ trans('messages.fields.server') }} <span class="text-danger">*</span></label>
                    <select class="form-select" :id="'rewardServerSelect' + i" :name="'rewards[' + i + '][server_id]'" v-model="reward.server_id" required>
                        <option value="" disabled selected>{{ trans('messages.actions.select') }}</option>
                        @foreach($servers as $server)
                            <option value="{{ $server->id }}">{{ $server->name }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-danger">{{ trans('achievement::messages.fields.required') }} - {{ trans('achievement::admin.objectives.server_required') }}</small>
                </div>

                <div class="mb-3 col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-reward" @click="removeReward(i)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-success mb-3" id="add-reward-btn" @click="addReward()">
        <i class="bi bi-plus-lg"></i> {{ trans('achievement::admin.objectives.add_reward') }}
    </button>
</div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hookSelect = document.getElementById('hookSelect');
            const triggerSelect = document.getElementById('triggerSelect');

            function updateTriggers() {
                const selectedHook = hookSelect.value;
                const shopTriggerHelp = document.getElementById('shop-trigger-help');

                // Hide all options first
                for (const option of triggerSelect.options) {
                    option.style.display = 'none';
                }

                // Show only options for the selected hook
                for (const option of triggerSelect.options) {
                    if (option.dataset.hook === selectedHook) {
                        option.style.display = '';
                    }
                }

                // Show/hide shop trigger help text
                if (selectedHook === 'shop') {
                    shopTriggerHelp.style.display = 'block';
                } else {
                    shopTriggerHelp.style.display = 'none';
                }

                // Select the first visible option if the current one is hidden
                let hasVisible = false;
                for (const option of triggerSelect.options) {
                    if (option.style.display === '' && option.selected) {
                        hasVisible = true;
                        break;
                    }
                }

                if (!hasVisible) {
                    for (const option of triggerSelect.options) {
                        if (option.style.display === '') {
                            option.selected = true;
                            break;
                        }
                    }
                }
            }

            hookSelect.addEventListener('change', updateTriggers);

            // Initial update
            updateTriggers();

            // Role visibility functionality
            const visibilityRoleRadio = document.getElementById('visibility_role');
            const roleVisibilityContainer = document.getElementById('role_visibility_container');

            // Initial state
            if (visibilityRoleRadio.checked) {
                roleVisibilityContainer.classList.remove('d-none');
            }

            // Add event listeners to all visibility radio buttons
            document.querySelectorAll('input[name="visibility"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    if (visibilityRoleRadio.checked) {
                        roleVisibilityContainer.classList.remove('d-none');
                    } else {
                        roleVisibilityContainer.classList.add('d-none');
                    }
                });
            });
        });
    </script>
@endpush
