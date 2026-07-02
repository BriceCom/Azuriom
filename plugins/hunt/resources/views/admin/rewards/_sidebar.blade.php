<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-info-circle"></i> {{ trans('hunt::admin.common.information') }}
        </h5>
    </div>
    <div class="card-body">
        <h6>{{ trans('hunt::admin.rewards.fields.chance_percentage') }}</h6>
        <p class="text-muted small">{{ trans('hunt::admin.rewards.fields.chance_percentage_info') }}</p>

        <h6>{{ trans('hunt::admin.rewards.fields.money') }}</h6>
        <p class="text-muted small">{{ trans('hunt::admin.rewards.fields.money_info') }}</p>

        <h6>{{ trans('hunt::admin.rewards.fields.commands') }}</h6>
        <p class="text-muted small">{{ trans('hunt::admin.rewards.fields.commands_info') }}</p>

        <h6>{{ trans('hunt::admin.rewards.fields.roles') }}</h6>
        <p class="text-muted small">{{ trans('hunt::admin.rewards.fields.roles_info') }}</p>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="bi bi-code-slash"></i> {{ trans('hunt::admin.rewards.fields.commands') }} - {{ trans('hunt::admin.common.placeholders') }}
        </h5>
    </div>
    <div class="card-body">
        <p class="mb-2"><strong>{{ trans('hunt::admin.common.available_placeholders') }} {{ trans('hunt::admin.rewards.server_commands_only') }}:</strong></p>
        <ul class="list-unstyled mb-0">
            <li><code>{player}</code> - {{ trans('hunt::admin.common.player_name') }}</li>
            <li><code>{user}</code> - {{ trans('hunt::admin.common.user_name') }}</li>
            <li><code>{hunt}</code> - {{ trans('hunt::admin.hunts.title') }} {{ trans('messages.name') }}</li>
            <li><code>{reward}</code> - {{ trans('hunt::admin.rewards.title') }} {{ trans('messages.name') }}</li>
        </ul>
        <div class="alert alert-info mt-2">
            <small>
                <i class="bi bi-info-circle me-1"></i>
                {!! game()->trans('commands') !!}
            </small>
        </div>
    </div>
</div>
