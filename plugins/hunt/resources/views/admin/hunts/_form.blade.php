<div class="row">
    <div class="col-md-12 mb-4">
        <h5 class="border-bottom pb-2">{{ trans('hunt::admin.common.general') }}</h5>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="name">{{ trans('hunt::admin.hunts.fields.name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $hunt->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6 d-none">
        <div class="mb-3">
            <label class="form-label" for="slug">{{ trans('hunt::admin.hunts.fields.slug') }}</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $hunt->slug ?? '') }}">
            <div class="form-text">{{ trans('hunt::admin.common.leave_empty_auto_generate') }}</div>
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label" for="description">{{ trans('hunt::admin.hunts.fields.description') }}</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $hunt->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="image">{{ trans('hunt::admin.hunts.fields.image') }}</label>

            @if(isset($hunt) && $hunt->hasImage())
                <div class="mb-2">
                    <img src="{{ $hunt->imageUrl() }}" alt="{{ $hunt->name }}" class="img-thumbnail" style="max-height: 100px;">
                </div>
            @endif

            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" {{ !isset($hunt) || !$hunt->hasImage() ? 'required' : '' }}>
            <div class="form-text">{{ trans('hunt::admin.common.max_image_size', ['size' => '2MB']) }}</div>
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-12 mb-4 mt-4">
        <h5 class="border-bottom pb-2">{{ trans('hunt::admin.common.configuration') }}</h5>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label" for="priority">{{ trans('hunt::admin.hunts.fields.priority') }}</label>
            <input type="number" class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" value="{{ old('priority', $hunt->priority ?? 1) }}" min="0" max="1000" required>
            <div class="form-text">{{ trans('hunt::admin.hunts.fields.priority_info') }}</div>
            @error('priority')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label" for="max_per_day">{{ trans('hunt::admin.hunts.fields.max_per_day') }}</label>
            <input type="number" class="form-control @error('max_per_day') is-invalid @enderror" id="max_per_day" name="max_per_day" value="{{ old('max_per_day', $hunt->max_per_day ?? 1) }}" min="1" max="100" required>
            <div class="form-text">{{ trans('hunt::admin.hunts.fields.max_per_day_info') }}</div>
            @error('max_per_day')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label" for="global_cap">{{ trans('hunt::admin.hunts.fields.global_cap') }}</label>
            <input type="number" class="form-control @error('global_cap') is-invalid @enderror" id="global_cap" name="global_cap" value="{{ old('global_cap', $hunt->global_cap ?? '') }}" min="0">
            <div class="form-text">{{ trans('hunt::admin.hunts.fields.global_cap_info') }}</div>
            @error('global_cap')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="spawn_rate">{{ trans('hunt::admin.hunts.fields.spawn_rate') }}</label>
            <div class="input-group">
                <input type="number" class="form-control @error('spawn_rate') is-invalid @enderror" id="spawn_rate" name="spawn_rate" value="{{ old('spawn_rate', $hunt->spawn_rate ?? 10.00) }}" min="0.01" max="100" step="0.01" required>
                <span class="input-group-text">%</span>
            </div>
            <div class="form-text">{{ trans('hunt::admin.hunts.fields.spawn_rate_info') }}</div>
            @error('spawn_rate')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="cooldown_minutes">{{ trans('hunt::admin.hunts.fields.cooldown_minutes') }}</label>
            <div class="input-group">
                <input type="number" class="form-control @error('cooldown_minutes') is-invalid @enderror" id="cooldown_minutes" name="cooldown_minutes" value="{{ old('cooldown_minutes', $hunt->cooldown_minutes ?? 30) }}" min="1" max="1440" required>
                <span class="input-group-text">{{ trans('hunt::messages.minutes') }}</span>
            </div>
            <div class="form-text">{{ trans('hunt::admin.hunts.fields.cooldown_minutes_info') }}</div>
            @error('cooldown_minutes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="spawn_delay_seconds">{{ trans('hunt::admin.hunts.fields.spawn_delay_seconds') }}</label>
            <div class="input-group">
                <input type="number" class="form-control @error('spawn_delay_seconds') is-invalid @enderror" id="spawn_delay_seconds" name="spawn_delay_seconds" value="{{ old('spawn_delay_seconds', $hunt->spawn_delay_seconds ?? 0) }}" min="0" max="3600" required>
                <span class="input-group-text">{{ trans('hunt::admin.hunts.fields.seconds') }}</span>
            </div>
            <div class="form-text">{{ trans('hunt::admin.hunts.fields.spawn_delay_seconds_info') }}</div>
            @error('spawn_delay_seconds')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-12 mb-4 mt-4">
        <h5 class="border-bottom pb-2">
            {{ trans('hunt::admin.common.schedule') }}
            @if(isset($hunt) && $hunt->exists)
                <small class="text-warning ms-2">
                    <i class="bi bi-exclamation-triangle"></i>
                    {{ trans('hunt::admin.hunts.validation.cannot_modify_dates') }}
                </small>
            @endif
        </h5>
    </div>

    @if(isset($hunt) && $hunt->exists)
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="start_date_display">{{ trans('hunt::admin.hunts.fields.start_date') }}</label>
                <input type="text" class="form-control" id="start_date_display" value="{{ $hunt->start_date->format('Y-m-d H:i') }}" readonly>
                <div class="form-text text-warning">
                    <i class="bi bi-lock"></i>
                    {{ trans('hunt::admin.hunts.validation.cannot_modify_dates') }}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="end_date_display">{{ trans('hunt::admin.hunts.fields.end_date') }}</label>
                <input type="text" class="form-control" id="end_date_display" value="{{ $hunt->end_date->format('Y-m-d H:i') }}" readonly>
                <div class="form-text text-warning">
                    <i class="bi bi-lock"></i>
                    {{ trans('hunt::admin.hunts.validation.cannot_modify_dates') }}
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="start_date">{{ trans('hunt::admin.hunts.fields.start_date') }}</label>
                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}">
                <div class="form-text">{{ trans('hunt::admin.hunts.fields.start_date_info') }}</div>
                @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="end_date">{{ trans('hunt::admin.hunts.fields.end_date') }}</label>
                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', now()->addDays(7)->format('Y-m-d\TH:i')) }}" required>
                <div class="form-text">{{ trans('hunt::admin.hunts.fields.end_date_info') }}</div>
                @error('end_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    @endif

    <div class="col-md-12 mb-4 mt-4">
        <h5 class="border-bottom pb-2">{{ trans('hunt::admin.rewards.title') }}</h5>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label" for="rewardsSelect">{{ trans('hunt::admin.rewards.title') }}</label>
            @if(isset($rewards) && $rewards->isNotEmpty())
                <select class="form-select @error('rewards') is-invalid @enderror" id="rewardsSelect" name="rewards[]" multiple>
                    @php
                        $selectedRewards = old('rewards', isset($hunt) ? $hunt->rewards->pluck('id')->toArray() : []);
                    @endphp
                    @foreach($rewards as $reward)
                        <option value="{{ $reward->id }}" @selected(in_array($reward->id, $selectedRewards))>
                            {{ $reward->name }} ({{ $reward->chances }}% - {{ $reward->money ?? 0 }} {{ money_name() }})
                        </option>
                    @endforeach
                </select>
                <div class="form-text">{{ trans('hunt::admin.common.hold_ctrl_multiple') }}</div>
                @error('rewards')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            @else
                <div class="alert alert-info">
                    <p class="mb-2">{{ trans('hunt::admin.rewards.no_rewards') }}</p>
                    <a href="{{ route('hunt.admin.rewards.create') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-plus"></i> {{ trans('hunt::admin.rewards.create') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="col-md-12 mb-4 mt-4">
        <h5 class="border-bottom pb-2">{{ trans('hunt::admin.common.status') }}</h5>
    </div>

    <div class="col-md-6">
        <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $hunt->is_active ?? 1) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">{{ trans('hunt::admin.hunts.fields.is_active') }}</label>
            <div class="form-text">{{ trans('hunt::admin.common.enable_feature') }}</div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" id="is_archived" name="is_archived" value="1" {{ old('is_archived', $hunt->is_archived ?? 0) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_archived">{{ trans('hunt::admin.hunts.fields.is_archived') }}</label>
            <div class="form-text">{{ trans('hunt::admin.common.archive_description') }}</div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            @if(isset($hunt) && $hunt->exists)
                const originalSlug = slugInput.value;
                nameInput.addEventListener('input', function() {
                    if (!slugInput.dataset.manual && (slugInput.value === originalSlug || slugInput.value === '')) {
                        slugInput.value = this.value
                            .toLowerCase()
                            .replace(/[^a-z0-9\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-')
                            .trim('-');
                    }
                });

                slugInput.addEventListener('input', function() {
                    this.dataset.manual = 'true';
                });
            @else
                nameInput.addEventListener('input', function() {
                    if (!slugInput.dataset.manual) {
                        slugInput.value = this.value
                            .toLowerCase()
                            .replace(/[^a-z0-9\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-')
                            .trim('-');
                    }
                });

                slugInput.addEventListener('input', function() {
                    this.dataset.manual = 'true';
                });

            @endif
        });
    </script>
@endpush
