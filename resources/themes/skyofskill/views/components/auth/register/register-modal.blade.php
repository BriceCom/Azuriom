@php
    $conditions = setting('conditions');

    if ($conditions !== null) {
        $rawConditions = preg_match('/^https?:\/\//i', $conditions)
            ? trans('auth.conditions', ['url' => $conditions])
            : Illuminate\Support\Str::between(Azuriom\Support\Markdown::parse($conditions, true), '<p>', '</p>');

        $conditions = new Illuminate\Support\HtmlString($rawConditions);
    }

    $registerConditions = $conditions;
@endphp

<div class="modal fade" id="registerModal"  tabindex="-1" aria-labelledby="registerModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="registerModal">S'enregistrer</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="monFormulaire" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="name">{{ trans('auth.name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">{{ trans('auth.email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">{{ trans('auth.password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password-confirm">{{ trans('auth.confirm_password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    @if($registerConditions !== null)
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input @error('conditions') is-invalid @enderror" type="checkbox" name="conditions" id="conditions" required @checked(old('conditions'))>

                                <label class="form-check-label" for="conditions">
                                    {{ $registerConditions }}
                                </label>

                                @error('conditions')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="age_condition" id="age_condition" @checked(old('age_condition'))>

                                <label class="form-check-label" for="age_condition">
                                    Je confirme avoir plus de 18 ans ou être accompagné de mon responsable légal pour m'inscrire sur ce site.
                                </label>
                            </div>
                        </div>
                    @endif

                    @include('elements.captcha', ['center' => true])


                    <div class="d-flex flex-wrap gap-2 align-items-md-center text-start mt-4">
                        <button type="submit" class="block btn btn-primary">
                            {{ trans('auth.register') }}
                        </button>

                        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" class="text-sm">
                            Déjà inscrit?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('footer-scripts')
<script>
    @if(isset($errors->messages()['password']) || isset($errors->messages()['password-confirm']))
        const loginModal = document.querySelector('#loginModal');
        console.log(loginModal);
        if(!loginModal.classList.contains('show')){
            {
                document.addEventListener('DOMContentLoaded', function() {new bootstrap.Modal(document.querySelector('#registerModal')).show()});
            }
        }
    @endif
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('conditions');
        const ageCheckbox = document.getElementById('age_condition');

        ageCheckbox.addEventListener('change', function() {
            if (this.checked) {
                checkbox.checked = true;
            }

            if(checkbox.checked && !this.checked){
                checkbox.checked = false
            }
        });

        checkbox.addEventListener('change', function() {
            if (this.checked) {
                ageCheckbox.checked = true;
            }
        });
    });
</script>
@endpush
