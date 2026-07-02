<div class="row">
    <div class="col-md-12 mb-4">
        <h5 class="border-bottom pb-2">{{ trans('hunt::admin.common.general') }}</h5>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="name">{{ trans('hunt::admin.rewards.fields.name') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $reward->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="chances">{{ trans('hunt::admin.rewards.fields.chance_percentage') }} <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="number" class="form-control @error('chances') is-invalid @enderror" id="chances" name="chances" value="{{ old('chances', $reward->chances ?? 100.00) }}" min="0.01" max="100" step="0.01" required>
                <span class="input-group-text">%</span>
            </div>
            <div class="form-text">{{ trans('hunt::admin.rewards.fields.chance_percentage_info') }}</div>
            @error('chances')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="hunt_ids">{{ trans('hunt::admin.hunts.title') }}</label>
            @php
                $selectedHuntIds = collect(old('hunt_ids', isset($reward) ? $reward->hunts->pluck('id')->all() : ($preselectedHuntIds ?? [])))
                    ->map(static fn ($huntId) => (int) $huntId)
                    ->all();
            @endphp
            <select class="form-select @error('hunt_ids') is-invalid @enderror" id="hunt_ids" name="hunt_ids[]" multiple>
                @foreach($hunts as $availableHunt)
                    <option value="{{ $availableHunt->id }}" @selected(in_array($availableHunt->id, $selectedHuntIds, true))>
                        {{ $availableHunt->name }}
                    </option>
                @endforeach
            </select>
            <div class="form-text">{{ trans('hunt::admin.common.hold_ctrl_multiple') }}</div>
            @error('hunt_ids')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-12 mb-4 mt-4">
        <h5 class="border-bottom pb-2">{{ trans('hunt::admin.rewards.fields.rewards') }}</h5>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="money">{{ trans('hunt::admin.rewards.fields.money') }}</label>
            <div class="input-group">
                <span class="input-group-text">{{ money_name() }}</span>
                <input type="number" class="form-control @error('money') is-invalid @enderror" id="money" name="money" value="{{ old('money', $reward->money ?? '') }}" min="0" step="0.01">
            </div>
            <div class="form-text">{{ trans('hunt::admin.rewards.fields.money_info') }}</div>
            @error('money')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    @if(($scratchGameEnabled ?? false) === true)
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="scratchCardInput">{{ trans('hunt::admin.rewards.fields.scratch_card') }}</label>
                <select class="form-select @error('scratch_card_id') is-invalid @enderror" id="scratchCardInput" name="scratch_card_id">
                    <option value="">{{ trans('hunt::admin.rewards.fields.scratch_card_none') }}</option>
                    @foreach(($scratchCards ?? []) as $card)
                        <option value="{{ $card->id }}" @selected(old('scratch_card_id', $reward->scratch_card_id ?? '') == $card->id)>
                            {{ $card->name }}
                        </option>
                    @endforeach
                </select>
                @error('scratch_card_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    @endif


    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label">{{ trans('hunt::admin.rewards.fields.commands') }}</label>
            <div id="commands-container">
                @php
                    $commands = old('commands', $reward->commands ?? []);
                @endphp
                @if(!empty($commands))
                    @foreach($commands as $index => $command)
                        <div class="input-group mb-2 command-group">
                            <input type="text" class="form-control @error('commands.'.$index) is-invalid @enderror" name="commands[]" value="{{ $command }}">
                            <button type="button" class="btn btn-outline-danger" onclick="removeCommand(this)">
                                <i class="bi bi-trash"></i>
                            </button>
                            @error('commands.'.$index)
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                @else
                    <div class="input-group mb-2 command-group">
                        <input type="text" class="form-control" name="commands[]">
                        <button type="button" class="btn btn-outline-danger" onclick="removeCommand(this)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addCommand()">
                <i class="bi bi-plus"></i> {{ trans('hunt::admin.rewards.fields.add_command') }}
            </button>
            <div class="form-text">{{ trans('hunt::admin.rewards.fields.commands_info') }}</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="serversSelect">{{ trans('hunt::admin.rewards.fields.servers') }}</label>
            <select class="form-select @error('servers') is-invalid @enderror" id="serversSelect" name="servers[]" multiple>
                @foreach($servers as $server)
                    <option value="{{ $server->id }}" @selected(isset($reward) && $reward->servers->contains($server))>
                        {{ $server->name }}
                    </option>
                @endforeach
            </select>
            @error('servers')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-check form-switch mt-4">
            <input type="checkbox" class="form-check-input" id="need_online" name="need_online" value="1" {{ old('need_online', $reward->need_online ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="need_online">{{ trans('hunt::admin.rewards.fields.need_online') }}</label>
            <div class="form-text">{{ trans('hunt::admin.common.require_online_execution') }}</div>
        </div>
    </div>

    <div class="col-md-12 mb-4 mt-4">
        <h5 class="border-bottom pb-2">{{ trans('hunt::admin.rewards.fields.roles') }}</h5>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label" for="rolesSelect">{{ trans('hunt::admin.rewards.fields.roles') }}</label>
            <select class="form-select @error('roles') is-invalid @enderror" id="rolesSelect" name="roles[]" multiple>
                @foreach($roles as $role)
                    @php
                        $selectedRoles = old('roles', isset($reward) ? $reward->roles->pluck('id')->toArray() : []);
                        if (!isset($reward) && empty($selectedRoles) && $role->id === $roles->first()->id) {
                            $selectedRoles = [$role->id];
                        }
                    @endphp
                    <option value="{{ $role->id }}" @selected(in_array($role->id, $selectedRoles))>{{ $role->name }}</option>
                @endforeach
            </select>
            <div class="form-text">{{ trans('hunt::admin.rewards.fields.roles_info') }}</div>
            @error('roles')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-12 mb-4 mt-4">
        <h5 class="border-bottom pb-2">{{ trans('hunt::admin.common.status') }}</h5>
    </div>

    <div class="col-md-6">
        <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" id="is_enabled" name="is_enabled" value="1" {{ old('is_enabled', $reward->is_enabled ?? 1) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_enabled">{{ trans('hunt::admin.rewards.fields.is_enabled') }}</label>
            <div class="form-text">{{ trans('hunt::admin.common.enable_feature') }}</div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function addCommand() {
            const container = document.getElementById('commands-container');
            const div = document.createElement('div');
            div.className = 'input-group mb-2 command-group';
            div.innerHTML = `
                <input type="text" class="form-control" name="commands[]" placeholder="{{ trans('hunt::admin.rewards.fields.commands_info') }}">
                <button type="button" class="btn btn-outline-danger" onclick="removeCommand(this)">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            container.appendChild(div);
        }

        function removeCommand(button) {
            const commandGroups = document.querySelectorAll('.command-group');
            if (commandGroups.length > 1) {
                button.closest('.command-group').remove();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const moneyInput = document.getElementById('money');
            const commandsContainer = document.getElementById('commands-container');
            const scratchCardInput = document.getElementById('scratchCardInput');

            if (form) {
                form.addEventListener('submit', function(e) {
                    const money = parseFloat(moneyInput.value) || 0;
                    const commands = Array.from(commandsContainer.querySelectorAll('input[name="commands[]"]'))
                        .map(input => input.value.trim())
                        .filter(value => value !== '');
                    const hasScratchCard = scratchCardInput && scratchCardInput.value !== '';

                    if (money <= 0 && commands.length === 0 && !hasScratchCard) {
                        e.preventDefault();
                        alert('{{ trans('hunt::admin.rewards.validation.reward_required') }}');
                        return false;
                    }

                    if (commands.length > 0) {
                        const servers = Array.from(document.querySelectorAll('select[name="servers[]"] option:checked'));
                        if (servers.length === 0) {
                            e.preventDefault();
                            alert('{{ trans('hunt::admin.rewards.validation.servers_required_for_commands') }}');
                            return false;
                        }
                    }
                });
            }
        });
    </script>
@endpush
