@extends('admin.layouts.admin')

@section('title', trans('suggest::admin.discord.title'))

@include('admin.elements.color-picker')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fab fa-discord"></i> {{ trans('suggest::admin.discord.title') }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('suggest.admin.discord.save') }}" method="POST">
                @csrf

                <div class="form-check form-switch mb-4">
                    <input type="checkbox" class="form-check-input" data-bs-toggle="collapse" id="enabledSwitch" name="enabled" @checked($enabled)>
                    <label for="enabledSwitch">{{ trans('suggest::admin.discord.enabled') }}</label>
                </div>

                <div class="form-group">
                    <label for="webhookUrl">{{ trans('suggest::admin.discord.webhook_url') }}</label>
                    <div class="input-group">
                        <input type="url" class="form-control @error('webhook_url') is-invalid @enderror"
                               id="webhookUrl" name="webhook_url" value="{{ old('webhook_url', $webhookUrl) }}"
                               placeholder="https://discord.com/api/webhooks/...">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-info" id="testWebhook">
                                <i class="fas fa-vial"></i> {{ trans('suggest::admin.discord.test') }}
                            </button>
                        </div>
                    </div>
                    @error('webhook_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        {{ trans('suggest::admin.discord.webhook_url_info') }}
                    </small>
                </div>

                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="sendOnCreateSwitch" name="send_on_create" @checked($sendOnCreate)>
                            <label for="sendOnCreateSwitch">{{ trans('suggest::admin.discord.send_on_create') }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="sendOnAcceptSwitch" name="send_on_accept" @checked($sendOnAccept)>
                                <label for="sendOnAcceptSwitch">{{ trans('suggest::admin.discord.send_on_accept') }}</label>
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="sendOnRefuseSwitch" name="send_on_refuse" @checked($sendOnRefuse)>
                            <label for="sendOnRefuseSwitch">{{ trans('suggest::admin.discord.send_on_refuse') }}</label>
                        </div>
                    </div>
                </div>

                <!-- Customization Section -->
                <div class="card bg-body mt-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-palette"></i> {{ trans('suggest::admin.discord.customization') }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Color Customization -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="colorCreated">{{ trans('suggest::admin.discord.color_created') }}</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color color-picker" id="colorCreated" name="color_created" value="{{ old('color_created', $colorCreated) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="colorAccepted">{{ trans('suggest::admin.discord.color_accepted') }}</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color color-picker" id="colorAccepted" name="color_accepted" value="{{ old('color_accepted', $colorAccepted) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="colorRefused">{{ trans('suggest::admin.discord.color_refused') }}</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color color-picker" id="colorRefused" name="color_refused" value="{{ old('color_refused', $colorRefused) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Template Customization -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6>{{ trans('suggest::admin.discord.custom_templates') }}</h6>
                                <small class="text-muted">{{ trans('suggest::admin.discord.template_variables_help') }}</small>
                            </div>
                            <div class="col-md-4">
                                <label for="templateCreated">{{ trans('suggest::admin.discord.template_created') }}</label>
                                <textarea class="form-control" id="templateCreated" name="template_created" rows="3" placeholder="📝 **New Suggestion: {title}**">{{ old('template_created', $templateCreated) }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="templateAccepted">{{ trans('suggest::admin.discord.template_accepted') }}</label>
                                <textarea class="form-control" id="templateAccepted" name="template_accepted" rows="3" placeholder="✅ **Suggestion Accepted: {title}**">{{ old('template_accepted', $templateAccepted) }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="templateRefused">{{ trans('suggest::admin.discord.template_refused') }}</label>
                                <textarea class="form-control" id="templateRefused" name="template_refused" rows="3" placeholder="❌ **Suggestion Refused: {title}**">{{ old('template_refused', $templateRefused) }}</textarea>
                            </div>
                        </div>

                        <!-- Webhook Appearance -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="customUsername">{{ trans('suggest::admin.discord.custom_username') }}</label>
                                <input type="text" class="form-control" id="customUsername" name="custom_username" value="{{ old('custom_username', $customUsername) }}" placeholder="Suggestion Bot">
                            </div>
                            <div class="col-md-6">
                                <label for="customAvatarUrl">{{ trans('suggest::admin.discord.custom_avatar_url') }}</label>
                                <input type="url" class="form-control" id="customAvatarUrl" name="custom_avatar_url" value="{{ old('custom_avatar_url', $customAvatarUrl) }}" placeholder="https://example.com/avatar.png">
                            </div>
                        </div>

                        <!-- Display Options -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6>{{ trans('suggest::admin.discord.display_options') }}</h6>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="showAuthor" name="show_author" @checked($showAuthor)>
                                    <label for="showAuthor">{{ trans('suggest::admin.discord.show_author') }}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="showCategory" name="show_category" @checked($showCategory)>
                                    <label for="showCategory">{{ trans('suggest::admin.discord.show_category') }}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="showVotes" name="show_votes" @checked($showVotes)>
                                    <label for="showVotes">{{ trans('suggest::admin.discord.show_votes') }}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="showDescription" name="show_description" @checked($showDescription)>
                                    <label for="showDescription">{{ trans('suggest::admin.discord.show_description') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Settings -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="descriptionLength">{{ trans('suggest::admin.discord.description_length') }}</label>
                                <input type="number" class="form-control" id="descriptionLength" name="description_length" value="{{ old('description_length', $descriptionLength) }}" min="50" max="4000">
                                <small class="text-muted">{{ trans('suggest::admin.discord.description_length_help') }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-4">
                    <h6><i class="fas fa-info-circle"></i> {{ trans('suggest::admin.discord.how_it_works') }}</h6>
                    <ul class="mb-0">
                        @foreach(trans('suggest::admin.discord.feature_list') as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>

    <!-- Test Result Modal -->
    <div class="modal fade" id="testResultModal" tabindex="-1" aria-labelledby="testResultModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testResultModalLabel">{{ trans('suggest::admin.discord.test') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="testResult"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('messages.actions.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const testButton = document.getElementById('testWebhook');
    const webhookUrlInput = document.getElementById('webhookUrl');
    const testResultModal = new bootstrap.Modal(document.getElementById('testResultModal'));
    const testResult = document.getElementById('testResult');

    // Template variable helper
    const templateInputs = ['templateCreated', 'templateAccepted', 'templateRefused'];
    templateInputs.forEach(function(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.addEventListener('focus', function() {
                if (!this.dataset.helpShown) {
                    const helpText = document.createElement('small');
                    helpText.className = 'text-info d-block mt-1';
                    helpText.innerHTML = 'Available variables: {title}, {author}, {category}, {status}, {votes}, {url}, {description}';
                    this.parentNode.appendChild(helpText);
                    this.dataset.helpShown = 'true';
                }
            });
        }
    });

    testButton.addEventListener('click', function() {
        const webhookUrl = webhookUrlInput.value.trim();

        if (!webhookUrl) {
            alert('Please enter a webhook URL first.');
            return;
        }

        // Disable button and show loading
        testButton.disabled = true;
        testButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Testing...';

        // Send test request
        fetch('{{ route('suggest.admin.discord.test') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                webhook_url: webhookUrl
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                testResult.innerHTML = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' + data.message + '</div>';
            } else {
                testResult.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> ' + data.message + '</div>';
            }
            testResultModal.show();
        })
        .catch(error => {
            testResult.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> An error occurred: ' + error.message + '</div>';
            testResultModal.show();
        })
        .finally(() => {
            // Re-enable button
            testButton.disabled = false;
            testButton.innerHTML = '<i class="fas fa-vial"></i> Test';
        });
    });
});
</script>
@endpush
