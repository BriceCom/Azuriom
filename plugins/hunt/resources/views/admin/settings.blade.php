@extends('admin.layouts.admin')

@section('title', trans('hunt::admin.settings.title'))

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">
            <i class="bi bi-info-circle"></i>
            {{ trans('hunt::admin.common.information') }}
        </h6>
    </div>

    <div class="card-body">
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            {{ trans('hunt::admin.settings.simplified_info') }}
        </div>

        <ul class="list-group">
            <li class="list-group-item">
                <strong>{{ trans('hunt::admin.settings.excluded_by_default') }}:</strong>
                <code>/admin*</code>, <code>/api*</code>, <code>/profile*</code>, <code>/login</code>, <code>/register</code>
            </li>
        </ul>
    </div>
</div>
@endsection
