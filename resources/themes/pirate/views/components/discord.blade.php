@push('styles')
    <link href="{{ theme_asset('css/components/discord.css') }}" rel="stylesheet">
@endpush
<section
            <svg id="wave" viewBox="0 0 1440 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <path style="transform:translate(0, 0px); opacity:1" fill="#6c0000" d="M0,80L26.7,75C53.3,70,107,60,160,50C213.3,40,267,30,320,25C373.3,20,427,20,480,31.7C533.3,43,587,67,640,63.3C693.3,60,747,30,800,21.7C853.3,13,907,27,960,36.7C1013.3,47,1067,53,1120,51.7C1173.3,50,1227,40,1280,31.7C1333.3,23,1387,17,1440,21.7C1493.3,27,1547,43,1600,45C1653.3,47,1707,33,1760,23.3C1813.3,13,1867,7,1920,13.3C1973.3,20,2027,40,2080,48.3C2133.3,57,2187,53,2240,48.3C2293.3,43,2347,37,2400,38.3C2453.3,40,2507,50,2560,58.3C2613.3,67,2667,73,2720,78.3C2773.3,83,2827,87,2880,86.7C2933.3,87,2987,83,3040,80C3093.3,77,3147,73,3200,73.3C3253.3,73,3307,77,3360,70C3413.3,63,3467,47,3520,35C3573.3,23,3627,17,3680,26.7C3733.3,37,3787,63,3813,76.7L3840,90L3840,100L3813.3,100C3786.7,100,3733,100,3680,100C3626.7,100,3573,100,3520,100C3466.7,100,3413,100,3360,100C3306.7,100,3253,100,3200,100C3146.7,100,3093,100,3040,100C2986.7,100,2933,100,2880,100C2826.7,100,2773,100,2720,100C2666.7,100,2613,100,2560,100C2506.7,100,2453,100,2400,100C2346.7,100,2293,100,2240,100C2186.7,100,2133,100,2080,100C2026.7,100,1973,100,1920,100C1866.7,100,1813,100,1760,100C1706.7,100,1653,100,1600,100C1546.7,100,1493,100,1440,100C1386.7,100,1333,100,1280,100C1226.7,100,1173,100,1120,100C1066.7,100,1013,100,960,100C906.7,100,853,100,800,100C746.7,100,693,100,640,100C586.7,100,533,100,480,100C426.7,100,373,100,320,100C266.7,100,213,100,160,100C106.7,100,53,100,27,100L0,100Z"></path>
            </svg>
            <div class="d-flex justify-content-between align-items-center section-2 p-3">
                <div>
                    <h5 class="mb-0 discord-title fw-bold">...</h5>
                    <h6 class="mb-0"><span class="discord-online">0</span> @lang('theme::theme.discord.members')</h6>
                </div>

                <a href="#" class="btn btn-light btn-sm discord-join" target="_blank">@lang('theme::theme.discord.join')</a>
            </div>
        </div>
        <div
        @if($isAdmin)
            data-editor-parent="#editor2-{{ $loop->index }}"
            data-editor-data-label="@lang('theme::theme.data.labels.discord-invite')"
            data-editor-data="discord-invite"
            data-editor-data-value="{{ getConfigValue($section['data']['discord-invite']) }}"
        @endif
        data-toggle="discord-invite" class="d-none"
        >{{ getConfigValue($section['data']['discord-invite']) }}</div>
        @if($isAdmin)
            <div class="toolbox">
                <div class="toolbox-container">
                    <button
                        data-editor-parent="#editor2-{{ $loop->index }}"
                        data-editor-action="data">
                            <i class="bi bi-pen-fill"></i>
                    </button>
                    <button
                        data-editor-parent="#editor2-{{ $loop->index }}"
                        data-editor-action="settings">
                            <i class="bi bi-gear-fill"></i>
                    </button>
                    <button
                        data-editor-parent="#editor2-{{ $loop->index }}"
                        data-editor-action="visibility"
                        data-editor-action-value="{{ getConfigValue($section['visibility']) }}">
                            <i class="bi bi-trash-fill"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
</section>
@push('scripts')
    <script src="{{ theme_asset('js/components/discord.js') }}" ></script>
@endpush
