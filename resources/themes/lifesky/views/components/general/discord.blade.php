<div class="h-100 d-flex flex-column">
    <div class="discord-list-wrapper">
        <ul class="discord-list list-unstyled my-3 px-2">
        </ul>
    </div>
    <div class="d-flex flex-column flex-md-row flex-wrap justify-content-between align-items-center px-2 fs-6 mt-4">
        <a class="btn btn-secondary rounded-pill text-xs text-uppercase" href="{{theme_config('settings.discord.link') ?? 'https://discord.gg/Gh2ddyBxUWvV'}}" rel="noopener" target="_blank">Nous rejoindre</a>
        <span class="discord-list_count text-xs fw-semibold ms-auto">{online} en ligne</span>
    </div>
</div>

@push('styles')
    <style>
        .discord-list-wrapper {
            height: 210px;
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
            background: var(--bs-secondary);
            border-radius: 50px;
            transition: background 0.123s linear;
        }

        /* Handle on hover */
        .discord-list-wrapper::-webkit-scrollbar-thumb:hover {
            background: rgba(var(--bs-primary-rgb), 0.6);
        }
    </style>
@endpush
