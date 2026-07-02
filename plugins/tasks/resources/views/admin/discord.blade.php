@extends('admin.layouts.admin')

@section('title', trans('tasks::admin.settings.discord.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('tasks::admin.settings.discord.title') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('tasks.admin.discord.update') }}" method="POST">
                @csrf

                <p class="text-muted">{{ trans('tasks::admin.settings.discord.description') }}</p>

                <!-- Enable Discord Webhooks -->
                <div class="mb-3 form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="discordEnabled" name="discord_enabled"
                           @checked($discord->enabled) data-bs-toggle="collapse" data-bs-target="#discordSettings">
                    <label class="form-check-label" for="discordEnabled">
                        {{ trans('tasks::admin.settings.discord.enable') }}
                    </label>
                </div>

                <div id="discordSettings" class="{{ $discord->enabled ? 'show' : 'collapse' }}">
                    <!-- Global Webhook URL -->
                    <div class="mb-3">
                        <label for="discordWebhookUrl" class="form-label">
                            {{ trans('tasks::admin.settings.discord.webhook_url') }}
                        </label>
                        <div class="input-group">
                            <input type="url" class="form-control @error('discord_webhook_url') is-invalid @enderror"
                                   id="discordWebhookUrl" name="discord_webhook_url"
                                   value="{{ old('discord_webhook_url', $discord->webhook_url) }}">
                            <button type="button" class="btn btn-outline-primary" id="testWebhook">
                                {{ trans('tasks::admin.settings.discord.test') }}
                            </button>
                        </div>
                        <div class="form-text">{{ trans('tasks::admin.settings.discord.webhook_url_info') }}</div>
                        <div id="webhookTestResult" class="mt-2" style="display: none;"></div>

                        @error('discord_webhook_url')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Event Notifications -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">{{ trans('tasks::admin.settings.discord.events') }}</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">{{ trans('tasks::admin.settings.discord.events_info') }}</p>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="sendOnCreated"
                                               name="discord_send_on_created" @checked($discord->send_on_created)>
                                        <label class="form-check-label" for="sendOnCreated">
                                            {{ trans('tasks::admin.settings.discord.event_created') }}
                                        </label>
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="sendOnStarted"
                                               name="discord_send_on_started" @checked($discord->send_on_started)>
                                        <label class="form-check-label" for="sendOnStarted">
                                            {{ trans('tasks::admin.settings.discord.event_started') }}
                                        </label>
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="sendOnCompleted"
                                               name="discord_send_on_completed" @checked($discord->send_on_completed)>
                                        <label class="form-check-label" for="sendOnCompleted">
                                            {{ trans('tasks::admin.settings.discord.event_completed') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="sendOnArchived"
                                               name="discord_send_on_archived" @checked($discord->send_on_archived)>
                                        <label class="form-check-label" for="sendOnArchived">
                                            {{ trans('tasks::admin.settings.discord.event_archived') }}
                                        </label>
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="sendOnComment"
                                               name="discord_send_on_comment" @checked($discord->send_on_comment)>
                                        <label class="form-check-label" for="sendOnComment">
                                            {{ trans('tasks::admin.settings.discord.event_comment') }}
                                        </label>
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="sendOnLogs"
                                               name="discord_send_on_logs" @checked($discord->send_on_logs)>
                                        <label class="form-check-label" for="sendOnLogs">
                                            {{ trans('tasks::admin.settings.discord.event_logs') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event-specific Webhook URLs -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">{{ trans('tasks::admin.settings.discord.specific_webhooks') }}</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">{{ trans('tasks::admin.settings.discord.specific_webhooks_info') }}</p>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="webhookUrlCreated" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.webhook_created') }}
                                        </label>
                                        <input type="url" class="form-control @error('discord_webhook_url_created') is-invalid @enderror"
                                               id="webhookUrlCreated" name="discord_webhook_url_created"
                                               value="{{ old('discord_webhook_url_created', $discord->webhook_url_created) }}">

                                        @error('discord_webhook_url_created')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="webhookUrlStarted" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.webhook_started') }}
                                        </label>
                                        <input type="url" class="form-control @error('discord_webhook_url_started') is-invalid @enderror"
                                               id="webhookUrlStarted" name="discord_webhook_url_started"
                                               value="{{ old('discord_webhook_url_started', $discord->webhook_url_started) }}">

                                        @error('discord_webhook_url_started')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="webhookUrlCompleted" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.webhook_completed') }}
                                        </label>
                                        <input type="url" class="form-control @error('discord_webhook_url_completed') is-invalid @enderror"
                                               id="webhookUrlCompleted" name="discord_webhook_url_completed"
                                               value="{{ old('discord_webhook_url_completed', $discord->webhook_url_completed) }}">

                                        @error('discord_webhook_url_completed')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="webhookUrlArchived" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.webhook_archived') }}
                                        </label>
                                        <input type="url" class="form-control @error('discord_webhook_url_archived') is-invalid @enderror"
                                               id="webhookUrlArchived" name="discord_webhook_url_archived"
                                               value="{{ old('discord_webhook_url_archived', $discord->webhook_url_archived) }}">

                                        @error('discord_webhook_url_archived')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="webhookUrlComment" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.webhook_comment') }}
                                        </label>
                                        <input type="url" class="form-control @error('discord_webhook_url_comment') is-invalid @enderror"
                                               id="webhookUrlComment" name="discord_webhook_url_comment"
                                               value="{{ old('discord_webhook_url_comment', $discord->webhook_url_comment) }}">

                                        @error('discord_webhook_url_comment')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="webhookUrlLogs" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.webhook_logs') }}
                                        </label>
                                        <input type="url" class="form-control @error('discord_webhook_url_logs') is-invalid @enderror"
                                               id="webhookUrlLogs" name="discord_webhook_url_logs"
                                               value="{{ old('discord_webhook_url_logs', $discord->webhook_url_logs) }}">

                                        @error('discord_webhook_url_logs')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event Colors -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">{{ trans('tasks::admin.settings.discord.colors') }}</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">{{ trans('tasks::admin.settings.discord.colors_info') }}</p>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="colorCreated" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.color_created') }}
                                        </label>
                                        <input type="color" class="form-control form-control-color"
                                               id="colorCreated" name="discord_color_created"
                                               value="{{ old('discord_color_created', $discord->color_created) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="colorStarted" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.color_started') }}
                                        </label>
                                        <input type="color" class="form-control form-control-color"
                                               id="colorStarted" name="discord_color_started"
                                               value="{{ old('discord_color_started', $discord->color_started) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="colorCompleted" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.color_completed') }}
                                        </label>
                                        <input type="color" class="form-control form-control-color"
                                               id="colorCompleted" name="discord_color_completed"
                                               value="{{ old('discord_color_completed', $discord->color_completed) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="colorArchived" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.color_archived') }}
                                        </label>
                                        <input type="color" class="form-control form-control-color"
                                               id="colorArchived" name="discord_color_archived"
                                               value="{{ old('discord_color_archived', $discord->color_archived) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="colorComment" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.color_comment') }}
                                        </label>
                                        <input type="color" class="form-control form-control-color"
                                               id="colorComment" name="discord_color_comment"
                                               value="{{ old('discord_color_comment', $discord->color_comment) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="colorLogs" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.color_logs') }}
                                        </label>
                                        <input type="color" class="form-control form-control-color"
                                               id="colorLogs" name="discord_color_logs"
                                               value="{{ old('discord_color_logs', $discord->color_logs) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Message Templates -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">{{ trans('tasks::admin.settings.discord.templates') }}</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">{{ trans('tasks::admin.settings.discord.templates_info') }}</p>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="templateCreated" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.template_created') }}
                                        </label>
                                        <textarea class="form-control" id="templateCreated" name="discord_template_created" rows="3">{{ old('discord_template_created', $discord->template_created) }}</textarea>
                                        <div class="form-text">{{ trans('tasks::admin.settings.discord.template_info') }}</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="templateStarted" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.template_started') }}
                                        </label>
                                        <textarea class="form-control" id="templateStarted" name="discord_template_started" rows="3">{{ old('discord_template_started', $discord->template_started) }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="templateCompleted" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.template_completed') }}
                                        </label>
                                        <textarea class="form-control" id="templateCompleted" name="discord_template_completed" rows="3">{{ old('discord_template_completed', $discord->template_completed) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="templateArchived" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.template_archived') }}
                                        </label>
                                        <textarea class="form-control" id="templateArchived" name="discord_template_archived" rows="3">{{ old('discord_template_archived', $discord->template_archived) }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="templateComment" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.template_comment') }}
                                        </label>
                                        <textarea class="form-control" id="templateComment" name="discord_template_comment" rows="3">{{ old('discord_template_comment', $discord->template_comment) }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="templateLogs" class="form-label">
                                            {{ trans('tasks::admin.settings.discord.template_logs') }}
                                        </label>
                                        <textarea class="form-control" id="templateLogs" name="discord_template_logs" rows="3">{{ old('discord_template_logs', $discord->template_logs) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <h6 class="alert-heading">{{ trans('tasks::admin.settings.discord.variables_title') }}</h6>
                                <p>{{ trans('tasks::admin.settings.discord.variables_info') }}</p>
                                <ul class="mb-0">
                                    <li><code>{title}</code> - {{ trans('tasks::admin.settings.discord.var_title') }}</li>
                                    <li><code>{author}</code> - {{ trans('tasks::admin.settings.discord.var_author') }}</li>
                                    <li><code>{status}</code> - {{ trans('tasks::admin.settings.discord.var_status') }}</li>
                                    <li><code>{url}</code> - {{ trans('tasks::admin.settings.discord.var_url') }}</li>
                                    <li><code>{description}</code> - {{ trans('tasks::admin.settings.discord.var_description') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Webhook Appearance -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">{{ trans('tasks::admin.settings.discord.appearance') }}</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">{{ trans('tasks::admin.settings.discord.appearance_info') }}</p>

                            <div class="mb-3">
                                <label for="customUsername" class="form-label">
                                    {{ trans('tasks::admin.settings.discord.custom_username') }}
                                </label>
                                <input type="text" class="form-control @error('discord_custom_username') is-invalid @enderror"
                                       id="customUsername" name="discord_custom_username"
                                       value="{{ old('discord_custom_username', $discord->custom_username) }}">
                                <div class="form-text">{{ trans('tasks::admin.settings.discord.custom_username_info') }}</div>

                                @error('discord_custom_username')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="customAvatarUrl" class="form-label">
                                    {{ trans('tasks::admin.settings.discord.custom_avatar') }}
                                </label>
                                <input type="url" class="form-control @error('discord_custom_avatar_url') is-invalid @enderror"
                                       id="customAvatarUrl" name="discord_custom_avatar_url"
                                       value="{{ old('discord_custom_avatar_url', $discord->custom_avatar_url) }}">
                                <div class="form-text">{{ trans('tasks::admin.settings.discord.custom_avatar_info') }}</div>

                                @error('discord_custom_avatar_url')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Content Display -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">{{ trans('tasks::admin.settings.discord.content') }}</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">{{ trans('tasks::admin.settings.discord.content_info') }}</p>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="showAuthor"
                                               name="discord_show_author" @checked($discord->show_author)>
                                        <label class="form-check-label" for="showAuthor">
                                            {{ trans('tasks::admin.settings.discord.show_author') }}
                                        </label>
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="showAssignees"
                                               name="discord_show_assignees" @checked($discord->show_assignees)>
                                        <label class="form-check-label" for="showAssignees">
                                            {{ trans('tasks::admin.settings.discord.show_assignees') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="showTags"
                                               name="discord_show_tags" @checked($discord->show_tags)>
                                        <label class="form-check-label" for="showTags">
                                            {{ trans('tasks::admin.settings.discord.show_tags') }}
                                        </label>
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="showDescription"
                                               name="discord_show_description" @checked($discord->show_description)>
                                        <label class="form-check-label" for="showDescription">
                                            {{ trans('tasks::admin.settings.discord.show_description') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="descriptionLength" class="form-label">
                                    {{ trans('tasks::admin.settings.discord.description_length') }}
                                </label>
                                <input type="number" class="form-control @error('discord_description_length') is-invalid @enderror"
                                       id="descriptionLength" name="discord_description_length" min="10" max="2000"
                                       value="{{ old('discord_description_length', $discord->description_length) }}">
                                <div class="form-text">{{ trans('tasks::admin.settings.discord.description_length_info') }}</div>

                                @error('discord_description_length')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection

@push('footer-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Test webhook functionality
            const testButton = document.getElementById('testWebhook');
            const webhookUrlInput = document.getElementById('discordWebhookUrl');
            const resultDiv = document.getElementById('webhookTestResult');

            if (testButton && webhookUrlInput && resultDiv) {
                testButton.addEventListener('click', function() {
                    const webhookUrl = webhookUrlInput.value.trim();

                    if (!webhookUrl) {
                        resultDiv.innerHTML = '<div class="alert alert-danger">{{ trans('tasks::admin.settings.discord.enter_webhook') }}</div>';
                        resultDiv.style.display = 'block';
                        return;
                    }

                    resultDiv.innerHTML = '<div class="alert alert-info">{{ trans('tasks::admin.settings.discord.testing_webhook') }}</div>';
                    resultDiv.style.display = 'block';

                    fetch('{{ route('tasks.admin.discord.test') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ webhook_url: webhookUrl })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            resultDiv.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                        } else {
                            resultDiv.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
                        }
                    })
                    .catch(error => {
                        resultDiv.innerHTML = '<div class="alert alert-danger">Error: ' + error.message + '</div>';
                    });
                });
            }
        });
    </script>
@endpush
