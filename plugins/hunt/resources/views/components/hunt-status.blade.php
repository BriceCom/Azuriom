@if($hunt->isActive() && $hunt->isCurrent())
    <span class="badge bg-success">{{ trans('hunt::messages.current_hunt') }}</span>
@elseif($hunt->isActive() && $hunt->end_date < now())
    <span class="badge bg-warning">{{ trans('hunt::admin.common.finalized') }}</span>
@elseif($hunt->isActive())
    <span class="badge bg-info">{{ trans('hunt::messages.active') }}</span>
@else
    <span class="badge bg-secondary">{{ trans('hunt::messages.ended') }}</span>
@endif
