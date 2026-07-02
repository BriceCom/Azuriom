@push('footer-scripts')
    @props([
        "id" => "links",
        "inputUrl" => false
    ])
    <script>

        document.querySelectorAll('.{{ $id }}-remove').forEach(function (el) {
            addListener(el);
        });

        document.querySelectorAll('#{{ $id }}-add-button').forEach(function (elm) {
            elm.addEventListener('click', function () {
                let input = '<div class="input-group mb-2 gap-2"><input type="text" placeholder="{{ $placeholder ?? trans('messages.fields.name') }}" name="{{ $name }}[{index}][name]" class="form-control">';

                @if($inputUrl) input += '<input type="url" placeholder="{{ trans('messages.fields.link') }}" name="{{ $name }}[{index}][href]" class="form-control">';
                @endif

                    input += '<button class="btn btn-outline-danger {{ $id }}-remove" type="button"><i class="bi bi-x-lg"></i></button>';
                input += '</div>';

                const newElement = document.createElement('div');
                newElement.innerHTML = input;

                addListener(newElement.querySelector('.{{ $id }}-remove'));

                document.getElementById('{{ $id }}-input').appendChild(newElement);
            });
        });
    </script>
@endpush

<div id="{{ $id }}-input" data-listInput="true">

    @forelse($values ?? [] as $value)
        <div class="input-group mb-2 gap-2">
            <input type="text" class="form-control" name="{{ $name }}[{index}][text]" placeholder="{{ $placeholder ?? trans('messages.fields.name') }}" value="{{ $value['text'] ?? '' }}">
            @if($inputUrl) <input type="url" class="form-control" name="{{ $name }}[{index}][href]" value="{{ $value['href'] ?? '' }}"> @endif
            <button class="btn btn-outline-danger {{ $id }}-remove" type="button">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @empty
        <div class="input-group mb-2 gap-2">
            <input type="text" class="form-control" name="{{ $name }}[{index}][name]" placeholder="{{ $placeholder ?? trans('messages.fields.name') }}">
            @if($inputUrl) <input type="url" class="form-control" placeholder="{{ trans('messages.fields.link') }}" name="{{ $name }}[{index}][href]"> @endif
            <button class="btn btn-outline-danger {{ $id }}-remove" type="button">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    @endforelse
</div>

<div class="my-1">
    <button type="button" id="{{ $id }}-add-button" class="btn btn-sm btn-success">
        <i class="bi bi-plus-lg"></i> {{ trans('messages.actions.add') }}
    </button>
</div>
