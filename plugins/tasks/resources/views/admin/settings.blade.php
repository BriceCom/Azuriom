@extends('admin.layouts.admin')

@section('title', trans('tasks::admin.settings.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">{{ trans('tasks::admin.settings.title') }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('tasks.admin.settings.update') }}" method="POST">
                @csrf

                <!-- Status Categorization Settings -->
                <h5 class="mb-3">{{ trans('tasks::admin.statistics.tasks_by_status') }}</h5>

                <div class="mb-3">
                    <label class="form-label">{{ trans('tasks::admin.settings.pending_statuses') }}</label>
                    <select class="form-select @error('pending_statuses') is-invalid @enderror" name="pending_statuses[]" multiple>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" @selected(in_array($status->id, $pendingStatuses))>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">{{ trans('tasks::admin.settings.pending_statuses_info') }}</div>

                    @error('pending_statuses')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ trans('tasks::admin.settings.in_progress_statuses') }}</label>
                    <select class="form-select @error('in_progress_statuses') is-invalid @enderror" name="in_progress_statuses[]" multiple>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" @selected(in_array($status->id, $inProgressStatuses))>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">{{ trans('tasks::admin.settings.in_progress_statuses_info') }}</div>

                    @error('in_progress_statuses')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ trans('tasks::admin.settings.completed_statuses') }}</label>
                    <select class="form-select @error('completed_statuses') is-invalid @enderror" name="completed_statuses[]" multiple>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" @selected(in_array($status->id, $completedStatuses))>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">{{ trans('tasks::admin.settings.completed_statuses_info') }}</div>

                    @error('completed_statuses')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>


                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>
        </div>
    </div>
@endsection

