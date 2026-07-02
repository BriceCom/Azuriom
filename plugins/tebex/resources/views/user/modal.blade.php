<div class="modal fade" id="usernameModal" tabindex="-1" aria-labelledby="usernameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="usernameModalLabel">{{ trans('tebex::messages.modal.username_title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('tebex.cart.username') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="input-tebex-username" class="form-label">{{ trans('tebex::messages.modal.enter_username') }}</label>
                        <input type="text"
                               name="username"
                               class="form-control"
                               id="input-tebex-username"
                               placeholder="{{ trans('tebex::messages.modal.username_placeholder') }}"
                               minlength="3"
                               value="{{ auth()->user()?->name ?? session('tebex.username', '') }}"
                               required>
                        <div class="invalid-feedback">{{ trans('tebex::messages.modal.username_validation') }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('messages.actions.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('messages.actions.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('usernameModal');
        const inputEl = document.getElementById('input-tebex-username');

        modalEl.addEventListener('shown.bs.modal', function () {
            inputEl.focus();
        });
    });
</script>
