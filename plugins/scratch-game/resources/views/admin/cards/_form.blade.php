<div class="row">
    <div class="col-md-12 mb-4">
        <h5 class="border-bottom pb-2">{{ trans('scratch-game::admin.common.general') }}</h5>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="name">{{ trans('scratch-game::admin.cards.fields.name') }}</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $card->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="price">{{ trans('scratch-game::admin.cards.fields.price') }}</label>
            <div class="input-group">
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" min="0" step="0.01" value="{{ old('price', $card->price ?? 0) }}" required>
                <span class="input-group-text">{{ money_name() }}</span>
            </div>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="free_interval_minutes">{{ trans('scratch-game::admin.cards.fields.free_interval_minutes') }}</label>
            <div class="input-group">
                <input type="number" class="form-control @error('free_interval_minutes') is-invalid @enderror" id="free_interval_minutes" name="free_interval_minutes" min="1" max="43200" step="1" value="{{ old('free_interval_minutes', $card->free_interval_minutes ?? '') }}">
                <span class="input-group-text">{{ trans('scratch-game::admin.cards.fields.free_interval_unit') }}</span>
            </div>
            <div class="form-text">{{ trans('scratch-game::admin.cards.fields.free_interval_help') }}</div>
            @error('free_interval_minutes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-12 mb-4 mt-2">
        <h5 class="border-bottom pb-2">{{ trans('scratch-game::admin.cards.fields.images') }}</h5>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="cover_image">{{ trans('scratch-game::admin.cards.fields.cover_image') }}</label>
            @php
                $coverCurrent = $card->cover_image ?? '';
                $coverImage = old('cover_image', $coverCurrent);
            @endphp

            <div class="d-flex align-items-center mb-2">
                <a class="input-group-text text-success me-2" href="{{ route('admin.images.create') }}" target="_blank" rel="noopener noreferrer" title="{{ trans('messages.actions.add') }}">
                    <i class="bi bi-upload"></i>
                </a>
                <select class="form-select @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" onchange="updateScratchImagePreview('cover')">
                    <option value="">{{ trans('messages.none') }}</option>
                    @foreach($images as $image)
                        <option value="{{ $image->file }}" data-preview-url="{{ image_url($image->file) }}" @selected($coverImage === $image->file)>{{ $image->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-2 d-none" id="coverPreviewWrapper">
                <img id="coverPreviewImage" src="" alt="cover preview" class="img-thumbnail" style="max-height: 120px;">
            </div>
            @error('cover_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="background_image">{{ trans('scratch-game::admin.cards.fields.background_image') }}</label>
            @php
                $backgroundCurrent = $card->background_image ?? '';
                $backgroundImage = old('background_image', $backgroundCurrent);
            @endphp

            <div class="d-flex align-items-center mb-2">
                <a class="input-group-text text-success me-2" href="{{ route('admin.images.create') }}" target="_blank" rel="noopener noreferrer" title="{{ trans('messages.actions.add') }}">
                    <i class="bi bi-upload"></i>
                </a>
                <select class="form-select @error('background_image') is-invalid @enderror" id="background_image" name="background_image" onchange="updateScratchImagePreview('background')">
                    <option value="">{{ trans('messages.none') }}</option>
                    @foreach($images as $image)
                        <option value="{{ $image->file }}" data-preview-url="{{ image_url($image->file) }}" @selected($backgroundImage === $image->file)>{{ $image->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-2 d-none" id="backgroundPreviewWrapper">
                <img id="backgroundPreviewImage" src="" alt="background preview" class="img-thumbnail" style="max-height: 120px;">
            </div>
            @error('background_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-12 mb-4 mt-2">
        <h5 class="border-bottom pb-2">{{ trans('scratch-game::admin.cards.fields.relations') }}</h5>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label mb-0" for="rewardsSelect">{{ trans('scratch-game::admin.cards.fields.rewards') }}</label>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearScratchMultiSelect('rewardsSelect')">
                    {{ trans('scratch-game::admin.buttons.reset') }}
                </button>
            </div>
            @php
                $selectedRewards = old('rewards', isset($card) ? $card->rewards->pluck('id')->toArray() : []);
            @endphp
            <select class="form-select @error('rewards') is-invalid @enderror" id="rewardsSelect" name="rewards[]" multiple>
                @foreach($rewards as $reward)
                    <option value="{{ $reward->id }}" @selected(in_array($reward->id, $selectedRewards))>
                        {{ $reward->name }} ({{ $reward->chance }}%)
                    </option>
                @endforeach
            </select>
            <div class="form-text">{{ trans('scratch-game::admin.common.hold_ctrl_multiple') }}</div>
            @error('rewards')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label mb-0" for="rolesSelect">{{ trans('scratch-game::admin.cards.fields.roles') }}</label>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearScratchMultiSelect('rolesSelect')">
                    {{ trans('scratch-game::admin.buttons.reset') }}
                </button>
            </div>
            @php
                $selectedRoles = old('roles', isset($card) ? $card->roles->pluck('id')->toArray() : []);
            @endphp
            <select class="form-select @error('roles') is-invalid @enderror" id="rolesSelect" name="roles[]" multiple>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @selected(in_array($role->id, $selectedRoles))>{{ $role->name }}</option>
                @endforeach
            </select>
            <div class="form-text">{{ trans('scratch-game::admin.cards.fields.roles_info') }}</div>
            @error('roles')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-12 mb-4 mt-2">
        <h5 class="border-bottom pb-2">{{ trans('scratch-game::admin.common.status') }}</h5>
    </div>

    <div class="col-md-6">
        <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" id="is_enabled" name="is_enabled" value="1" {{ old('is_enabled', $card->is_enabled ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_enabled">{{ trans('scratch-game::admin.cards.fields.is_enabled') }}</label>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function clearScratchMultiSelect(selectId) {
            const select = document.getElementById(selectId);

            if (!select) {
                return;
            }

            for (const option of select.options) {
                option.selected = false;
            }
        }

        function updateScratchImagePreview(type) {
            const select = document.getElementById(type + '_image');
            const wrapper = document.getElementById(type + 'PreviewWrapper');
            const image = document.getElementById(type + 'PreviewImage');

            if (!select || !wrapper || !image) {
                return;
            }

            const selectedOption = select.options[select.selectedIndex];
            const previewUrl = selectedOption ? selectedOption.dataset.previewUrl : '';

            if (!previewUrl) {
                wrapper.classList.add('d-none');
                image.src = '';
                return;
            }

            image.src = previewUrl;
            wrapper.classList.remove('d-none');
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateScratchImagePreview('cover');
            updateScratchImagePreview('background');
        });
    </script>
@endpush
