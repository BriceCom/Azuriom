@php($counterPartial++)
<div class="card border border-white shadow-lg">
    @if(isset($pageTitle))
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title fs-4 mb-0">
                {{$pageTitle}}
            </h4>
        </div>
    @endif
    <div class="card-body pt-0">
        @if(isset($filedsBuilder))
            @foreach($filedsBuilder as $field)
                @if($field['type'] === 'text')
                    <div class="my-2">
                        @include('admin.pattern.form.input-text')
                    </div>
                @endif
                @if($field['type'] === 'checkbox')
                    @include('admin.pattern.form.input-checkbox')
                @endif
                @if($field['type'] === 'range')
                    @include('admin.pattern.form.input-range')
                @endif
                @if($field['type'] === 'color')
                    @include('admin.pattern.form.input-color')
                @endif
                @if($field['type'] === 'select')
                    @include('admin.pattern.form.select')
                @endif
                @if($field['type'] === 'images')
                    @include('admin.pattern.form.image')
                @endif
                @if($field['type'] === 'textarea')
                    @include('admin.pattern.form.textarea')
                @endif
                @if($field['type'] === 'builderInputs')
                    @include('admin.pattern.form.builder-input')
                @endif
            @endforeach
        @endif
    </div>
</div>
