<div class="h-100 d-flex flex-column">
    <div class="discord-list-wrapper">
        <ul class="discord-list list-unstyled my-3 px-2">
        </ul>
    </div>
    <div class="d-flex justify-content-between align-items-center px-2 text-sm mt-3">
        <span class="discord-list_count text-primary">{{ trans('theme::theme.home.online') }}</span>
        <a class="btn btn-primary rounded-pill text-sm" href="{{theme_config('settings.discord.link') ?? 'https://discord.gg/Gh2ddyBxUWvV'}}" rel="noopener" target="_blank">{{ trans('theme::theme.home.join') }}</a>
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
    </style>
@endpush
