<div class="row">
    <div class="col-md-12 mb-4">
        <h5 class="border-bottom pb-2">{{ trans('scratch-game::admin.common.general') }}</h5>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="name">{{ trans('scratch-game::admin.rewards.fields.name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $reward->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="chance">{{ trans('scratch-game::admin.rewards.fields.chance') }}</label>
            <div class="input-group">
                <input type="number" class="form-control @error('chance') is-invalid @enderror" id="chance" name="chance" value="{{ old('chance', $reward->chance ?? 100) }}" min="0.01" max="100" step="0.01" required>
                <span class="input-group-text">%</span>
            </div>
            @error('chance')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="money">{{ trans('scratch-game::admin.rewards.fields.money') }}</label>
            <div class="input-group">
                <span class="input-group-text">{{ money_name() }}</span>
                <input type="number" class="form-control @error('money') is-invalid @enderror" id="money" name="money" value="{{ old('money', $reward->money ?? '') }}" min="0" step="0.01">
            </div>
            @error('money')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="image">{{ trans('scratch-game::admin.rewards.fields.image') }}</label>

            @if(isset($reward) && $reward->hasImage())
                <div class="mb-2">
                    <img src="{{ $reward->imageUrl() }}" alt="{{ $reward->name }}" class="img-thumbnail" style="max-height: 120px;">
                </div>
            @endif

            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-12 mb-4 mt-2">
        <h5 class="border-bottom pb-2">{{ trans('scratch-game::admin.rewards.fields.commands_section') }}</h5>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label">{{ trans('scratch-game::admin.rewards.fields.commands') }}</label>
            <div id="commands-container">
                @php
                    $commands = \Azuriom\Plugin\ScratchGame\Models\ScratchReward::normalizeCommands(old('commands', $reward->commands ?? []));
                @endphp
                @if(!empty($commands))
                    @foreach($commands as $index => $command)
                        <div class="row g-2 mb-2 command-group">
                            <div class="col-md-4">
                                <input type="text"
                                       class="form-control @error('commands.'.$index.'.name') is-invalid @enderror"
                                       name="commands[{{ $index }}][name]"
                                       value="{{ $command['name'] }}"
                                       placeholder="{{ trans('scratch-game::admin.rewards.fields.command_name') }}">
                            </div>
                            <div class="col-md-7">
                                <input type="text"
                                       class="form-control @error('commands.'.$index.'.command') is-invalid @enderror"
                                       name="commands[{{ $index }}][command]"
                                       value="{{ $command['command'] }}"
                                       placeholder="{{ trans('scratch-game::admin.rewards.fields.command_line') }}">
                            </div>
                            <div class="col-md-1 d-flex">
                                <button type="button" class="btn btn-outline-danger w-100" onclick="removeCommand(this)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row g-2 mb-2 command-group">
                        <div class="col-md-4">
                            <input type="text"
                                   class="form-control"
                                   name="commands[0][name]"
                                   placeholder="{{ trans('scratch-game::admin.rewards.fields.command_name') }}">
                        </div>
                        <div class="col-md-7">
                            <input type="text"
                                   class="form-control"
                                   name="commands[0][command]"
                                   placeholder="{{ trans('scratch-game::admin.rewards.fields.command_line') }}">
                        </div>
                        <div class="col-md-1 d-flex">
                            <button type="button" class="btn btn-outline-danger" onclick="removeCommand(this)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addCommand()">
                <i class="bi bi-plus"></i> {{ trans('scratch-game::admin.rewards.fields.add_command') }}
            </button>
            <div class="form-text">{{ trans('scratch-game::admin.rewards.fields.commands_info') }}</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="serversSelect">{{ trans('scratch-game::admin.rewards.fields.servers') }}</label>
            @php
                $selectedServers = old('servers', isset($reward) ? $reward->servers->pluck('id')->toArray() : []);
            @endphp
            <select class="form-select @error('servers') is-invalid @enderror" id="serversSelect" name="servers[]" multiple>
                @foreach($servers as $server)
                    <option value="{{ $server->id }}" @selected(in_array($server->id, $selectedServers))>
                        {{ $server->name }} ({{ $server->type }})
                    </option>
                @endforeach
            </select>
            <div class="form-text">{{ trans('scratch-game::admin.common.hold_ctrl_multiple') }}</div>
            @error('servers')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-check form-switch mt-4">
            <input type="checkbox" class="form-check-input" id="need_online" name="need_online" value="1" {{ old('need_online', $reward->need_online ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="need_online">{{ trans('scratch-game::admin.rewards.fields.need_online') }}</label>
            <div class="form-text">{{ trans('scratch-game::admin.rewards.fields.need_online_info') }}</div>
            @error('need_online')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-12 mb-4 mt-2">
        <h5 class="border-bottom pb-2">{{ trans('scratch-game::admin.common.status') }}</h5>
    </div>

    <div class="col-md-6">
        <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" id="is_enabled" name="is_enabled" value="1" {{ old('is_enabled', $reward->is_enabled ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_enabled">{{ trans('scratch-game::admin.rewards.fields.is_enabled') }}</label>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        let commandIndex = {{ count($commands) > 0 ? count($commands) : 1 }};

        function addCommand() {
            const container = document.getElementById('commands-container');
            const div = document.createElement('div');
            div.className = 'row g-2 mb-2 command-group';
            div.innerHTML = `
                <div class="col-md-4">
                    <input type="text" class="form-control" name="commands[${commandIndex}][name]" placeholder="{{ trans('scratch-game::admin.rewards.fields.command_name') }}">
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="commands[${commandIndex}][command]" placeholder="{{ trans('scratch-game::admin.rewards.fields.command_line') }}">
                </div>
                <div class="col-md-1 d-flex">
                    <button type="button" class="btn btn-outline-danger w-100" onclick="removeCommand(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;

            container.appendChild(div);
            commandIndex++;
        }

        function removeCommand(button) {
            const commandGroups = document.querySelectorAll('.command-group');

            if (commandGroups.length > 1) {
                button.closest('.command-group').remove();
            }
        }
    </script>
@endpush
