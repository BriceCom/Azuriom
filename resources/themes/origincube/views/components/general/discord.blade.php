<div class="h-100 d-flex flex-column">
    <div class="discord-list-wrapper">
        <ul class="discord-list list-unstyled my-3 px-2">
        </ul>
    </div>
    <div class="d-flex justify-content-between align-items-center px-2 fs-6 mt-3">
        <span class="discord-list_count text-primary">{online} en ligne</span>
        <a class="btn btn-primary rounded-pill fs-6" href="{{theme_config('hero.discord.url') ?? 'https://discord.gg/Gh2ddyBxUWvV'}}" rel="noopener" target="_blank">Rejoindre</a>
    </div>
</div>

@push('styles')
    <style>
        .discord-list-wrapper {
            flex-grow: 1;
            height: 0;
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
            width: 6px;
            height: 2px;
        }

        .discord-status-online{
            background-color: limegreen;
        }

        .discord-status-idle{
            background-color: darkorange;
        }

        .discord-list-wrapper::-webkit-scrollbar {
            width: 8px;
        }

        /* Track */
        .discord-list-wrapper::-webkit-scrollbar-track {
            border-radius: 50px;
            background: #DCDCDC;
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
