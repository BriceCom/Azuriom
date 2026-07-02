@push('footer-scripts')
    <script>
        const registerPage = document.getElementById('user_register');
        const login = document.getElementById('user_login');

        if (registerPage) {
            const card = registerPage.querySelector('.card-body');

            card.appendChild(getOAuthComponent())
        }

        if (login) {
            const card = login.querySelector('.card-body');

            card.appendChild(getOAuthComponent(true))
        }

        function getOAuthComponent(login){
            const oauthPage = document.createElement('div');

            if(login){
                oauthPage.innerHTML = `@include('components.oauth.oauth', ['login' => true])`;
            } else {
                oauthPage.innerHTML = `@include('components.oauth.oauth', ['login' => false])`;
            }

            return oauthPage
        }
    </script>
@endpush
