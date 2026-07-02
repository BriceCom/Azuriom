@push('footer-scripts')
    <script type="text/javascript">

        let getScrollToTopDOM = document.getElementById('scrollToTop')
        let showScroll = false;

        const checkScrollTop = () => {
            console.log('scrolling')
            if(!showScroll && window.scrollY>400){
                showScroll=true
                getScrollToTopDOM.classList.remove('opacity-0')
            } else if(showScroll && window.scrollY<400) {
                showScroll=false
                getScrollToTopDOM.classList.add('opacity-0')
            }
        }

        window.addEventListener('scroll', checkScrollTop);
    </script>
@endpush

<a id="scrollToTop" href="#top" class="opacity-0 position-fixed top-0" title="{{trans('theme::modules.scrollToTop.backToTop')}}">
    <i class="{{ theme_config('modules.ui.scrollToTop.icon') ?? 'bi bi-arrow-up-short' }}"></i>
</a>
