@php($currentUsername = auth()->user()?->name ?? session('tebex.username'))

@if($currentUsername)
    <div class="d-flex justify-content-center mb-3">
        <div class="flex-shrink-0 d-flex align-items-center">
            <img src="{{ tebex_get_avatar($currentUsername, 48) }}"
                 class="me-3 rounded"
                 alt="{{ $currentUsername }}"
                 width="48">
        </div>
        <div class="align-self-center">
            <h3 class="mb-0">{{ $currentUsername }}</h3>
            @guest
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#usernameModal">
                    {{ trans('messages.actions.edit') }}
                </button>
            @endguest
        </div>
    </div>
@else
    <button type="button" class="btn btn-primary d-block" data-bs-toggle="modal" data-bs-target="#usernameModal">
        <i class="bi bi-box-arrow-in-right"></i> {{ trans('tebex::messages.modal.set_username') }}
    </button>
@endif
