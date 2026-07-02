
<div class="card-stat card-discord">
    <div class="card-bottom-shadow card-gradient-from-bottom">
        <div class="card card-gradient-from-bottom-content pb-4">
            <div class="card-title gradient-left-100-dark py-2 px-4 d-flex align-items-center justify-content-between">
                <h2 class="line-clamp-1 mb-0 h4 py-2 fw-semibold">Serveur Discord</h2>
                <span class="discord-list_count opacity-25">{online} en ligne</span>
            </div>
            <div class="discord-list-wrapper px-3">
                <ul class="discord-list list-unstyled my-3 px-2">
                </ul>
            </div>

            <div class="d-flex justify-content-center align-items-center px-2 mt-3">
                <a class="btn btn-primary text-sm fs-6" href="{{theme_config('settings.discord.link') ?? 'https://discord.gg/Gh2ddyBxUWvV'}}" rel="noopener" target="_blank">Nous rejoindre
                    <i class="ms-1"><svg width="10" height="18" viewBox="0 0 10 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_d_3_115)">
                                <path d="M1.98568 15L10 7.5L1.98568 0L0 1.85824L6.02865 7.5L0 13.1418L1.98568 15Z" fill="white"/>
                            </g>
                            <defs>
                                <filter id="filter0_d_3_115" x="0" y="0" width="10" height="18" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feOffset dy="3"/>
                                    <feComposite in2="hardAlpha" operator="out"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.17 0"/>
                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3_115"/>
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3_115" result="shape"/>
                                </filter>
                            </defs>
                        </svg>
                    </i></a>
            </div>

        </div>
    </div>
</div>

@push('styles')
    <style>
        .discord-list-wrapper {
            height: 300px;
            flex-grow: 1;
            overflow-y: scroll;
            overflow-x: hidden;
        }
        .discord-status-dnd{
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #cb2e2e;
        }

        .discord-status-dnd::after{
            background-color: #7a0909;
            content: "";
            width: 4px;
            height: 2px;
        }

        .discord-status-online{
            background-color: limegreen;
        }

        .discord-status-idle{
            background-color: #8e00d7;
        }

        .discord-list-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        /* Track */
        .discord-list-wrapper::-webkit-scrollbar-track {
            border-radius: 50px;
            background: var(--bs-body-bg);
        }

        /* Handle */
        .discord-list-wrapper::-webkit-scrollbar-thumb {
            background: var(--bs-primary);
            border-radius: 50px;
            transition: background 0.123s linear;
        }

        /* Handle on hover */
        .discord-list-wrapper::-webkit-scrollbar-thumb:hover {
            background: rgba(var(--bs-primary-rgb), 0.6);
        }
    </style>
@endpush
