@push('footer-scripts')
    @props([
        "id" => $id,
        "inputText" => false,
        "inputUrl" => false,
        "inputUrlBlank" => false,
        "inputTexarea" => false,
        "inputWysiwyg" => false,
        "inputWysiwygHeight" => 400,
        "inputIcon" => false,
        "inputColor" => false,
    ])
    <script>

        document.querySelectorAll('.{{ $id }}-remove').forEach(function (el) {
            addListener(el);
        });

        document.querySelectorAll('#{{ $id }}-add-button').forEach(function (elm) {
            elm.addEventListener('click', function () {
                let input = '<div class="input-group mb-2 gap-2">';

                @if($inputUrlBlank)
                    input += `
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="{{ $name }}[{index}][target]">
                            <span class="form-check-label">{{trans('theme::admin.form.blank')}}</span>
                        </div>
                    `;
                @endif

                @if($inputText)
                    input += `<input type="text" placeholder="{{ $placeholder ?? trans('messages.fields.name') }}" name="{{ $name }}[{index}][name]" class="form-control">`;
                @endif

                @if($inputIcon)
                    input += '<input type="text" placeholder="bi bi-house" name="{{ $name }}[{index}][icon]" class="form-control">';
                @endif

                @if($inputUrl)
                    input += '<input type="url" placeholder="{{ trans('messages.fields.link') }}" name="{{ $name }}[{index}][href]" class="form-control">';
                @endif

                @if($inputColor)
                    input += `@include('admin.components.forms.color', ['name' => trans('theme::admin.form.color.color'), 'id' => $name.'[{index}][color]', 'hideLabel' => true])`;
                @endif

                    input += '<button class="btn btn-outline-danger {{ $id }}-remove" type="button"><i class="bi bi-x-lg"></i></button>';

                @if($inputTexarea)
                    input += `<textarea class="w-100 form-control" name="{{ $name }}[{index}][content]"></textarea>`
                @endif

                @if($inputWysiwyg)
                    input += `<textarea class="w-100 form-control html-editor" name="{{ $name }}[{index}][htmlContent]"></textarea>`
                @endif

                    input += '</div>';


                const newElement = document.createElement('div');
                newElement.innerHTML = input;

                addListener(newElement.querySelector('.{{ $id }}-remove'));

                document.getElementById('{{ $id }}-input').appendChild(newElement);

                @if($inputWysiwyg)
                    const newTextarea = newElement.querySelector('.html-editor');

                    console.log(newTextarea);

                    if (newTextarea) {
                        tinymce.init({
                            selector: '#{{$id}}, .html-editor',
                            target: newTextarea,
                            license_key: 'gpl',
                            promotion: false,
                            min_height: 200,
                            entity_encoding: 'raw',
                            toolbar: 'blocks bold italic underline strikethrough forecolor | undo redo',
                            relative_urls: false,
                            valid_children: "+body[style]",
                            extended_valid_elements: 'i[class],iframe[src|frameborder|scrolling|class|width|height|name|allow|title]',
                            content_css: '{{ (dark_theme() ? 'dark,' : '').asset('vendor/bootstrap-icons/bootstrap-icons.css') }}',
                            @if(dark_theme())
                            skin: 'oxide-dark',
                            @endif
                            paste_data_images: false
                        });
                    }
                @endif
            });
        });
    </script>
@endpush

<div id="{{ $id }}-input" data-listInput="true">

    @forelse($values ?? [] as $value)
        <div class="input-group align-items-center mb-2 gap-2">
            @if($inputUrlBlank)
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="{{ $name }}[{index}][target]" @if(isset($value['target'])) checked @endif">
                    <span class="form-check-label">{{trans('theme::admin.form.blank')}}</span>
                </div>
            @endif

            @if($inputText)
                    <input type="text" class="form-control" name="{{ $name }}[{index}][name]" placeholder="{{ $placeholder ?? trans('messages.fields.name') }}" value="{{ $value['name'] ?? '' }}">
            @endif

            @if($inputIcon)
                <input type="text" class="form-control" name="{{ $name }}[{index}][icon]"
                       placeholder="bi bi-house" value="{{ $value['icon'] ?? '' }}">
            @endif

            @if($inputUrl)
                <input type="url" class="form-control" name="{{ $name }}[{index}][href]"
                       value="{{ $value['href'] ?? '' }}">
            @endif


            @if($inputColor)
                @include('admin.components.forms.color', ['name' => trans('theme::admin.form.color.color'), 'id' => $name.'[{index}][color]', 'value' => $value['color'], 'hideLabel'=> true])
            @endif

            <button class="btn btn-outline-danger {{ $id }}-remove" type="button">
                <i class="bi bi-x-lg"></i>
            </button>


            @if($inputTexarea)
                <textarea class="w-100 form-control"
                          name="{{ $name }}[{index}][content]">{{ $value['content'] ?? '' }}</textarea>
            @endif

            @if($inputWysiwyg)
                <textarea class="w-100 form-control html-editor"
                          name="{{ $name }}[{index}][htmlContent]">{{ $value['htmlContent'] ?? '' }}</textarea>
            @endif
        </div>
    @empty
        <div class="input-group mb-2 gap-2"></div>
    @endforelse
</div>

@push('styles')
    <style>
        #{{ $id }}-input{
            .tox-tinymce{
                height: {{ $inputWysiwygHeight }}px !important;
            }
        }
    </style>
@endpush

<div class="my-1">
    <button type="button" id="{{ $id }}-add-button" class="btn btn-sm btn-success">
        <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
    </button>
</div>
