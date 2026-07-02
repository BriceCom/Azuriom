@extends('admin.layouts.admin')

@section('title', trans('suggest::admin.settings.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('suggest.admin.settings.save') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="maxSuggestionsInput">{{ trans('suggest::admin.settings.max_suggestions') }}</label>
                    <input type="number" min="1" class="form-control @error('max_suggestions_per_user') is-invalid @enderror" id="maxSuggestionsInput" name="max_suggestions_per_user" value="{{ old('max_suggestions_per_user', $maxSuggestionsPerUser) }}">
                    <div class="form-text">{{ trans('suggest::admin.settings.max_suggestions_info') }}</div>

                    @error('max_suggestions_per_user')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="maxDescriptionLengthInput">{{ trans('suggest::admin.settings.max_description_length') }}</label>
                    <input type="number" min="50" max="4000" class="form-control @error('max_description_length') is-invalid @enderror" id="maxDescriptionLengthInput" name="max_description_length" value="{{ old('max_description_length', $maxDescriptionLength) }}">
                    <div class="form-text">{{ trans('suggest::admin.settings.max_description_length_info') }}</div>

                    @error('max_description_length')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="indexTitleInput">{{ trans('suggest::admin.settings.index_title') }}</label>
                    <input type="text" class="form-control @error('index_title') is-invalid @enderror" id="indexTitleInput" name="index_title" value="{{ old('index_title', $indexTitle) }}">

                    @error('index_title')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="indexSubtitleInput">{{ trans('suggest::admin.settings.index_subtitle') }}</label>
                    <textarea class="form-control @error('index_subtitle') is-invalid @enderror" id="indexSubtitleInput" name="index_subtitle" rows="3">{{ old('index_subtitle', $indexSubtitle) }}</textarea>

                    @error('index_subtitle')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="enableCommentsInput" name="enable_comments" value="1" @checked(old('enable_comments', $enableComments))>
                        <label class="form-check-label" for="enableCommentsInput">{{ trans('suggest::admin.settings.enable_comments') }}</label>
                    </div>
                </div>

                <div class="mb-4">
                    <h5>{{ trans('suggest::admin.settings.visible_filters') }}</h5>
                    <p class="text-muted">{{ trans('suggest::admin.settings.visible_filters_info') }}</p>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="disableCategoryFiltersInput" name="disable_category_filters" value="1" @checked(old('disable_category_filters', $disableCategoryFilters))>
                            <label class="form-check-label" for="disableCategoryFiltersInput">{{ trans('suggest::admin.settings.disable_category_filters') }}</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="filterAllInput" name="filter_all" value="1" @checked(old('filter_all', $filterAll))>
                                    <label class="form-check-label" for="filterAllInput">{{ trans('suggest::messages.filter.all') }}</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="filterPendingInput" name="filter_pending" value="1" @checked(old('filter_pending', $filterPending))>
                                    <label class="form-check-label" for="filterPendingInput">{{ trans('suggest::messages.filter.pending') }}</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="filterApprovedInput" name="filter_approved" value="1" @checked(old('filter_approved', $filterApproved))>
                                    <label class="form-check-label" for="filterApprovedInput">{{ trans('suggest::messages.filter.approved') }}</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="filterRejectedInput" name="filter_rejected" value="1" @checked(old('filter_rejected', $filterRejected))>
                                    <label class="form-check-label" for="filterRejectedInput">{{ trans('suggest::messages.filter.rejected') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="filterRecentInput" name="filter_recent" value="1" @checked(old('filter_recent', $filterRecent))>
                                    <label class="form-check-label" for="filterRecentInput">{{ trans('suggest::messages.filter.recent') }}</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="filterOldestInput" name="filter_oldest" value="1" @checked(old('filter_oldest', $filterOldest))>
                                    <label class="form-check-label" for="filterOldestInput">{{ trans('suggest::messages.filter.oldest') }}</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="filterPopularInput" name="filter_popular" value="1" @checked(old('filter_popular', $filterPopular))>
                                    <label class="form-check-label" for="filterPopularInput">{{ trans('suggest::messages.filter.popular') }}</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="filterUnpopularInput" name="filter_unpopular" value="1" @checked(old('filter_unpopular', $filterUnpopular))>
                                    <label class="form-check-label" for="filterUnpopularInput">{{ trans('suggest::messages.filter.unpopular') }}</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="filterMineInput" name="filter_mine" value="1" @checked(old('filter_mine', $filterMine))>
                                    <label class="form-check-label" for="filterMineInput">{{ trans('suggest::messages.filter.mine') }}</label>
                                </div>
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
