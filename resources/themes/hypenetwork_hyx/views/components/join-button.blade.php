@php($joinText = $joinText ?? null)
<button
    class="clipboard d-flex flex-row align-items-center cursor-pointer border-0 mb-0 py-2 px-4 rounded-3 btn btn-{{$btn??'primary'}}"
    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Adresse copiée!"
    data-bs-trigger="manual"
>
    <span class="d-flex align-items-center gap-2 text-uppercase">
       {{$joinText ?? (theme_config('home.index.ip.text') ?? 'play.hypenetwork.fr')}}
       <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path
                d="M6.3 2.84003C6.073 2.69691 5.81176 2.6173 5.54351 2.60952C5.27527 2.60173 5.00985 2.66605 4.77493 2.79577C4.54001 2.92549 4.34419 3.11585 4.20789 3.34702C4.07159 3.57818 3.9998 3.84167 4 4.11003V15.89C3.9998 16.1584 4.07159 16.4219 4.20789 16.653C4.34419 16.8842 4.54001 17.0746 4.77493 17.2043C5.00985 17.334 5.27527 17.3983 5.54351 17.3905C5.81176 17.3828 6.073 17.3032 6.3 17.16L15.644 11.269C15.8584 11.1339 16.0351 10.9466 16.1576 10.7247C16.28 10.5028 16.3442 10.2535 16.3442 10C16.3442 9.74658 16.28 9.49726 16.1576 9.27534C16.0351 9.05343 15.8584 8.86617 15.644 8.73103L6.3 2.84103V2.84003Z"
                fill="currentColor"/>
       </svg>
    </span>
</button>
