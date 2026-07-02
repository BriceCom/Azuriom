@if(theme_config('premium.serveurliste.link'))
    <div class="page-height"
         style="
             --page-height-bar: {{theme_config('header.modules.pageHeight.height') ?? '8'}}px;
             --page-bg-bar: {{theme_config('header.modules.pageHeight.colorBg') ?? '#6c5e8f'}};
             --page-color-bar: {{theme_config('header.modules.pageHeight.color') ?? '#531cdb'}};
         "
    ></div>
@endif
