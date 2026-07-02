@push('footer-scripts')
    @props([
        "id" => "links",
        "inputUrl" => false,
        "inputUrlBlank" => false,
        "inputTexarea" => false,
        "inputTexareaWysiwyg" => false,
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

                    input += `<input type="text" placeholder="{{ $placeholder ?? trans('messages.fields.name') }}" name="{{ $name }}[{index}][name]" class="form-control">`;

                @if($inputUrl)
                    input += '<input type="url" placeholder="{{ trans('messages.fields.link') }}" name="{{ $name }}[{index}][href]" class="form-control">';
                @endif

                    input += '<button class="btn btn-outline-danger {{ $id }}-remove" type="button"><i class="bi bi-x-lg"></i></button>';

                @if($inputTexarea)
                    input += `<textarea class="w-100 form-control {{isset($inputTexareaWysiwyg) ? 'html-editor':''}}" name="{{ $name }}[{index}][content]"></textarea>`
                @endif

                    input += '</div>';


                const newElement = document.createElement('div');
                newElement.innerHTML = input;

                addListener(newElement.querySelector('.{{ $id }}-remove'));

                document.getElementById('{{ $id }}-input').appendChild(newElement);

                initTinyMCE();
            });
        });
    </script>
@endpush

<div id="{{ $id }}-input" data-listInput="true">

    @forelse($values ?? [] as $value)
        <div class="input-group align-items-center mb-2 gap-2">
            @if($inputUrlBlank)
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="{{ $name }}[{index}][target]"
                           checked="{{ $value['target'] ?? 'false' }}">
                    <span class="form-check-label">{{trans('theme::admin.form.blank')}}</span>
                </div>
            @endif

            <input type="text" class="form-control" name="{{ $name }}[{index}][name]"
                   placeholder="{{ $placeholder ?? trans('messages.fields.name') }}" value="{{ $value['name'] ?? '' }}">

            @if($inputUrl)
                <input type="url" class="form-control" name="{{ $name }}[{index}][href]"
                       value="{{ $value['href'] ?? '' }}">
            @endif

            <button class="btn btn-outline-danger {{ $id }}-remove" type="button">
                <i class="bi bi-x-lg"></i>
            </button>


            @if($inputTexarea)
                <textarea class="w-100 form-control {{isset($inputTexareaWysiwyg) ? 'html-editor':''}}"
                          name="{{ $name }}[{index}][content]">{{ $value['content'] ?? '' }}</textarea>
            @endif
        </div>
    @empty
        <div class="input-group mb-2 gap-2">
            @if($inputUrlBlank)
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="{{ $name }}[{index}][target]">
                    <span class="form-check-label">{{trans('theme::admin.form.blank')}}</span>
                </div>
            @endif

            <input type="text" class="form-control" name="{{ $name }}[{index}][name]"
                   placeholder="{{ $placeholder ?? trans('messages.fields.name') }}">

            @if($inputUrl)
                <input type="url" class="form-control" placeholder="{{ trans('messages.fields.link') }}" name="{{ $name }}[{index}][href]">
            @endif

            <button class="btn btn-outline-danger {{ $id }}-remove" type="button">
                <i class="bi bi-x-lg"></i>
            </button>


            @if($inputTexarea)
                    <textarea class="w-100 form-control {{isset($inputTexareaWysiwyg) ? 'html-editor':''}}" name="{{ $name }}[{index}][content]"></textarea>
            @endif

        </div>
    @endforelse
</div>

<div class="my-1">
    <button type="button" id="{{ $id }}-add-button" class="btn btn-sm btn-success">
        <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
    </button>
</div>
