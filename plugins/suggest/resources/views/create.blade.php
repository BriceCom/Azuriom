@extends('layouts.app')

@section('title', trans('suggest::messages.create'))

@include('admin.elements.editor')

@section('content')
    <div class="container content">
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('suggest.index', $indexQuery) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> {{ trans('messages.actions.cancel') }}
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm mb-4">
                    <p class="card-header">{{ trans('suggest::messages.create') }}</p>
                    <div class="card-body">
                        <form action="{{ route('suggest.store') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="category_id" class="form-label">{{ trans('suggest::messages.fields.category') }}</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                    <option value="" disabled @selected(empty($selectedCategoryId))>{{ trans('suggest::messages.fields.select_category') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected((string) $selectedCategoryId === (string) $category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">{{ trans('suggest::messages.fields.title') }}</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required maxlength="80">
                                <div class="form-text">{{ trans('suggest::messages.fields.title_help') }}</div>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">{{ trans('suggest::messages.fields.description') }}</label>
                                <textarea class="form-control html-editor @error('content') is-invalid @enderror" id="content" name="content" rows="5">{{ old('content') }}</textarea>
                                <div class="form-text">
                                    {{ trans('suggest::messages.fields.description_help', ['max' => $maxDescriptionLength]) }},
                                    <span id="contentCounter" data-max="{{ $maxDescriptionLength }}">{{ $currentDescriptionLength }}/{{ $maxDescriptionLength }}</span>
                                </div>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('suggest.index', $indexQuery) }}" class="btn btn-danger">
                                    {{ trans('messages.actions.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const contentField = document.getElementById('content');
            const contentCounter = document.getElementById('contentCounter');

            if (!contentField || !contentCounter) {
                return;
            }

            const maxLength = Number.parseInt(contentCounter.dataset.max ?? '0', 10);
            const updateCounter = (currentLength) => {
                contentCounter.textContent = `${currentLength}/${maxLength}`;
            };

            const countTextLengthFromHtml = (htmlContent) => {
                const textarea = document.createElement('textarea');
                textarea.innerHTML = htmlContent;
                const decodedHtmlContent = textarea.value;

                const doc = new DOMParser().parseFromString(decodedHtmlContent, 'text/html');
                const textContent = (doc.body.textContent ?? '').trim();

                return Array.from(textContent).length;
            };

            const updateFromTextarea = () => {
                updateCounter(countTextLengthFromHtml(contentField.value));
            };

            const bindTinyMceCounter = (editor) => {
                const updateFromEditor = () => {
                    const textContent = editor.getContent({ format: 'text' }).trim();
                    updateCounter(Array.from(textContent).length);
                };

                editor.on('init', updateFromEditor);
                editor.on('keyup', updateFromEditor);
                editor.on('change', updateFromEditor);
                editor.on('SetContent', updateFromEditor);
                editor.on('Undo', updateFromEditor);
                editor.on('Redo', updateFromEditor);
                updateFromEditor();
            };

            contentField.addEventListener('input', updateFromTextarea);
            updateFromTextarea();

            if (window.tinymce) {
                tinymce.on('AddEditor', (event) => {
                    if (event.editor.id === 'content') {
                        bindTinyMceCounter(event.editor);
                    }
                });

                const existingEditor = tinymce.get('content');
                if (existingEditor) {
                    bindTinyMceCounter(existingEditor);
                }
            }
        });
    </script>
@endpush
