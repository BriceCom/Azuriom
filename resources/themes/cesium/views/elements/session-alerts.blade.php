<div class="px-8">
    @if (session('success'))
        <div id="alert-flash-success" class="container px-4 py-5 mx-auto border rounded-2xl border-steel-200 mb-8"
            role="alert">
            <div class="flex">
                <div class="flex-shrink-0 my-auto">
                    <svg class="fill-white h-6 my-auto flex-shrink-0" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM15.7071 9.29289C16.0976 9.68342 16.0976 10.3166 15.7071 10.7071L12.0243 14.3899C11.4586 14.9556 10.5414 14.9556 9.97568 14.3899L8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929C8.68342 10.9024 9.31658 10.9024 9.70711 11.2929L11 12.5858L14.2929 9.29289C14.6834 8.90237 15.3166 8.90237 15.7071 9.29289Z">
                        </path>
                    </svg>
                </div>
                <div class="flex items-center justify-between flex-1 ml-4">
                    <p class="pr-3 my-auto text-sm font-medium text-white line-clamp-2">
                        {{ session('success') }}
                    </p>
                </div>
                <button type="button" class="inline-flex justify-center items-center h-4 w-4 my-auto px-4 text-white"
                    data-hs-remove-element="#alert-flash-success">
                    <span class="sr-only">Fermer</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 fill-white"
                        viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="32" d="M368 368L144 144M368 144L144 368" />
                    </svg>
                </button>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div id="alert-flash-error" class="container px-4 py-5 mx-auto border rounded-2xl border-steel-200 mb-8"
            role="alert">
            <div class="flex">
                <div class="flex-shrink-0 my-auto">
                    <svg class="fill-white h-6 my-auto flex-shrink-0" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7.10711 2.87868C7.66972 2.31607 8.43278 2 9.22843 2H14.7716C15.5672 2 16.3303 2.31607 16.8929 2.87868L21.1213 7.10711C21.6839 7.66972 22 8.43278 22 9.22843V14.7716C22 15.5672 21.6839 16.3303 21.1213 16.8929L16.8929 21.1213C16.3303 21.6839 15.5672 22 14.7716 22H9.22843C8.43278 22 7.66972 21.6839 7.10711 21.1213L2.87868 16.8929C2.31607 16.3303 2 15.5672 2 14.7716V9.22843C2 8.43278 2.31607 7.66972 2.87868 7.10711L7.10711 2.87868ZM13 8C13 7.44772 12.5523 7 12 7C11.4477 7 11 7.44772 11 8V13C11 13.5523 11.4477 14 12 14C12.5523 14 13 13.5523 13 13V8ZM13 15.9888C13 15.4365 12.5523 14.9888 12 14.9888C11.4477 14.9888 11 15.4365 11 15.9888V16C11 16.5523 11.4477 17 12 17C12.5523 17 13 16.5523 13 16V15.9888Z">
                        </path>
                    </svg>
                </div>
                <div class="flex items-center justify-between flex-1 ml-4">
                    <p class="pr-3 my-auto text-sm font-medium text-white line-clamp-2">
                        {{ session('error') }}
                    </p>
                </div>
                <button type="button" class="inline-flex justify-center items-center h-4 w-4 my-auto px-4 text-white"
                    data-hs-remove-element="#alert-flash-error">
                    <span class="sr-only">Fermer</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 fill-white"
                        viewBox="0 0 512 512">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="32" d="M368 368L144 144M368 144L144 368" />
                    </svg>
                </button>
            </div>
        </div>
    @endif
    <div class="rounded-xl container mx-auto" id="status-message"></div>
</div>
