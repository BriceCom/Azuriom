<div class="d-flex flex-column rounded-3">
    <ul class="discord-list list-unstyled px-4 m-0 me-4 mt-4" style="height: {{$height ?? 260}}px;max-height: {{$height ?? 260}}px;overflow-y: scroll;overflow-x: hidden">
    </ul>
    <div class="d-flex justify-content-between align-items-end px-4 my-2 py-2">
        <span class="discord-list_count"> {{theme_config('block.discord.textonline') ?? 'Online'}}</span>
        <a class="btn btn-primary" href="{{theme_config('hero.discord.url') ?? 'https://discord.gg/Gh2ddyBxUWvV'}}" target="_blank">{{theme_config('block.discord.textjoin') ?? 'Join'}}</a>
    </div>
</div>

@push('styles')
    <style>
        .discord-list {
            overflow-y: scroll;
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

        .discord-list::-webkit-scrollbar {
            width: 8px;
        }

        /* Track */
        .discord-list::-webkit-scrollbar-track {
            border-radius: 3px;
        }

        /* Handle */
        .discord-list::-webkit-scrollbar-thumb {
            background: rgba(var(--bs-white-rgb), 0.85);
            border-radius: 2px;
            transition: background 0.123s linear;
        }

        /* Handle on hover */
        .discord-list::-webkit-scrollbar-thumb:hover {
            background: rgba(var(--bs-white-rgb), 0.6);
        }
    </style>
@endpush
