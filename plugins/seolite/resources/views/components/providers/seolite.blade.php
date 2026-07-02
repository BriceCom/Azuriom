@can('seolite.view')
    @push('styles')
        <link rel="stylesheet" href="{{ plugin_asset("seolite", "css/styles.css") }}">
    @endpush

    @push('footer-scripts')
        <script>
            function trans(key, params = null) {
                const translations = {

                    // Sections keys
                    'seolite::messages.seo_score': '{{ trans("seolite::messages.seo_score") }}',
                    'seolite::messages.metadata': '{{ trans("seolite::messages.metadata") }}',
                    'seolite::messages.headings': '{{ trans("seolite::messages.headings") }}',
                    'seolite::messages.keyword_analysis': '{{ trans("seolite::messages.keyword_analysis") }}',
                    'seolite::messages.readability_score': '{{ trans("seolite::messages.readability_score") }}',
                    'seolite::messages.alternative_text_images': '{{ trans("seolite::messages.alternative_text_images") }}',
                    'seolite::messages.image_optimization': '{{ trans("seolite::messages.image_optimization") }}',
                    'seolite::messages.recommendations': '{{ trans("seolite::messages.recommendations") }}',

                    // Readability keys
                    'seolite::messages.very_easy': '{{ trans("seolite::messages.very_easy") }}',
                    'seolite::messages.easy': '{{ trans("seolite::messages.easy") }}',
                    'seolite::messages.standard': '{{ trans("seolite::messages.standard") }}',
                    'seolite::messages.difficult': '{{ trans("seolite::messages.difficult") }}',
                    'seolite::messages.very_difficult': '{{ trans("seolite::messages.very_difficult") }}',
                    'seolite::messages.empty_text': '{{ trans("seolite::messages.empty_text") }}',
                    'seolite::messages.no_content': '{{ trans("seolite::messages.no_content") }}',
                    'seolite::messages.very_easy_text': '{{ trans("seolite::messages.very_easy_text") }}',
                    'seolite::messages.easy_text': '{{ trans("seolite::messages.easy_text") }}',
                    'seolite::messages.standard_text': '{{ trans("seolite::messages.standard_text") }}',
                    'seolite::messages.difficult_text': '{{ trans("seolite::messages.difficult_text") }}',
                    'seolite::messages.very_difficult_text': '{{ trans("seolite::messages.very_difficult_text") }}',
                    'seolite::messages.readability_score_prefix': '{{ trans("seolite::messages.readability_score_prefix") }}',
                    'seolite::messages.very_easy_to_read': '{{ trans("seolite::messages.very_easy_to_read") }}',
                    'seolite::messages.easy_to_read': '{{ trans("seolite::messages.easy_to_read") }}',
                    'seolite::messages.standard_difficulty': '{{ trans("seolite::messages.standard_difficulty") }}',
                    'seolite::messages.difficult_to_read': '{{ trans("seolite::messages.difficult_to_read") }}',
                    'seolite::messages.very_difficult_to_read': '{{ trans("seolite::messages.very_difficult_to_read") }}',
                    'seolite::messages.very_difficult_to_read_desc': '{{ trans("seolite::messages.very_difficult_to_read_desc") }}',
                    'seolite::messages.difficult_to_read_desc': '{{ trans("seolite::messages.difficult_to_read_desc") }}',
                    'seolite::messages.the_text_is_empty': '{{ trans("seolite::messages.the_text_is_empty") }}',

                    // Image optimization keys
                    'seolite::messages.missing_alternative_text': '{{ trans("seolite::messages.missing_alternative_text") }}',
                    'seolite::messages.image_format_analysis': '{{ trans("seolite::messages.image_format_analysis") }}',
                    'seolite::messages.webp_format_tooltip': '{{ trans("seolite::messages.webp_format_tooltip") }}',
                    'seolite::messages.webp_info_description': '{{ trans("seolite::messages.webp_info_description") }}',
                    'seolite::messages.click_to_analyze_image_formats': '{{ trans("seolite::messages.click_to_analyze_image_formats") }}',
                    'seolite::messages.webp_images': '{{ trans("seolite::messages.webp_images") }}',
                    'seolite::messages.other_formats': '{{ trans("seolite::messages.other_formats") }}',
                    'seolite::messages.optimized': '{{ trans("seolite::messages.optimized") }}',
                    'seolite::messages.optimized_webp_format': '{{ trans("seolite::messages.optimized_webp_format") }}',
                    'seolite::messages.not_optimized_webp': '{{ trans("seolite::messages.not_optimized_webp") }}',
                    'seolite::messages.no_images_found': '{{ trans("seolite::messages.no_images_found") }}',
                    'seolite::messages.view_image': '{{ trans("seolite::messages.view_image") }}',
                    'seolite::messages.image': '{{ trans("seolite::messages.image") }}',

                    // Keyword analysis keys
                    'seolite::messages.keyword_analyzed': '{{ trans("seolite::messages.keyword_analyzed") }}',
                    'seolite::messages.please_enter_keyword': '{{ trans("seolite::messages.please_enter_keyword") }}',
                    'seolite::messages.unable_to_analyze_content': '{{ trans("seolite::messages.unable_to_analyze_content") }}',

                    // Recommendation keys
                    'seolite::messages.register_server_voting_sites': '{{ trans("seolite::messages.register_server_voting_sites") }}',
                    'seolite::messages.register_server_voting_sites_desc': '{!! trans("seolite::messages.register_server_voting_sites_desc") !!}',
                    'seolite::messages.complex_headings_detected_desc': '{!! trans("seolite::messages.complex_headings_detected_desc") !!}',
                    'seolite::messages.fill_alt_tags': '{{ trans("seolite::messages.fill_alt_tags") }}',
                    'seolite::messages.fill_alt_tags_desc': '{{ trans("seolite::messages.fill_alt_tags_desc") }}',
                    'seolite::messages.include_cta_meta': '{{ trans("seolite::messages.include_cta_meta") }}',
                    'seolite::messages.include_cta_meta_desc': '{{ trans("seolite::messages.include_cta_meta_desc") }}',
                    'seolite::messages.use_short_sentences': '{{ trans("seolite::messages.use_short_sentences") }}',
                    'seolite::messages.use_short_sentences_desc': '{{ trans("seolite::messages.use_short_sentences_desc") }}',
                    'seolite::messages.long_sentences_detected_desc': '{{ trans("seolite::messages.long_sentences_detected_desc") }}',
                    'seolite::messages.standard_readability_improvements_desc': '{{ trans("seolite::messages.standard_readability_improvements_desc") }}',

                    // Chars
                    'seolite::messages.chars': '{{ trans("seolite::messages.chars") }}',
                    'seolite::messages.length': '{{ trans("seolite::messages.length") }}',

                    // Recommendations keys
                    'seolite::messages.standard_readability_improvements': '{{ trans("seolite::messages.standard_readability_improvements") }}',
                    'seolite::messages.long_sentences_detected': '{{ trans("seolite::messages.long_sentences_detected") }}',
                    'seolite::messages.complex_headings_detected': '{{ trans("seolite::messages.complex_headings_detected") }}',
                    'seolite::messages.paragraphs_too_long': '{{ trans("seolite::messages.paragraphs_too_long") }}',
                    'seolite::messages.paragraphs_too_long_desc': '{{ trans("seolite::messages.paragraphs_too_long_desc") }}',
                    'seolite::messages.insufficient_internal_linking': '{{ trans("seolite::messages.insufficient_internal_linking") }}',
                    'seolite::messages.insufficient_internal_linking_desc': '{{ trans("seolite::messages.insufficient_internal_linking_desc") }}',
                    'seolite::messages.no_external_links': '{{ trans("seolite::messages.no_external_links") }}',
                    'seolite::messages.no_external_links_desc': '{{ trans("seolite::messages.no_external_links_desc") }}',
                    'seolite::messages.h1_length_issue': '{{ trans("seolite::messages.h1_length_issue") }}',
                    'seolite::messages.broken_heading_hierarchy': '{{ trans("seolite::messages.broken_heading_hierarchy") }}',
                    'seolite::messages.broken_heading_hierarchy_desc': '{{ trans("seolite::messages.broken_heading_hierarchy_desc") }}',
                    'seolite::messages.title_too_short': '{{ trans("seolite::messages.title_too_short") }}',
                    'seolite::messages.title_too_long': '{{ trans("seolite::messages.title_too_long") }}',
                    'seolite::messages.title_could_be_longer': '{{ trans("seolite::messages.title_could_be_longer") }}',
                    'seolite::messages.meta_description_too_short': '{{ trans("seolite::messages.meta_description_too_short") }}',
                    'seolite::messages.mobile_responsive_check': '{{ trans("seolite::messages.mobile_responsive_check") }}',
                    'seolite::messages.mobile_responsive_desc': '{{ trans("seolite::messages.mobile_responsive_desc") }}',
                    'seolite::messages.optimize_images_webp': '{{ trans("seolite::messages.optimize_images_webp") }}',
                    'seolite::messages.optimize_images_webp_desc': '{{ trans("seolite::messages.optimize_images_webp_desc") }}',
                    'seolite::messages.regular_content_updates': '{{ trans("seolite::messages.regular_content_updates") }}',
                    'seolite::messages.regular_content_updates_desc': '{{ trans("seolite::messages.regular_content_updates_desc") }}',
                    'seolite::messages.monitor_page_loading_speed': '{{ trans("seolite::messages.monitor_page_loading_speed") }}',
                    'seolite::messages.monitor_page_loading_speed_desc': '{{ trans("seolite::messages.monitor_page_loading_speed_desc") }}',
                    'seolite::messages.missing_meta_description': '{{ trans("seolite::messages.missing_meta_description") }}',
                    'seolite::messages.meta_description_could_be_longer': '{{ trans("seolite::messages.meta_description_could_be_longer") }}',
                    'seolite::messages.meta_description_too_long': '{{ trans("seolite::messages.meta_description_too_long") }}',
                    'seolite::messages.missing_meta_description_desc': '{{ trans("seolite::messages.missing_meta_description_desc") }}',
                    'seolite::messages.missing_canonical_url': '{{ trans("seolite::messages.missing_canonical_url") }}',
                    'seolite::messages.missing_canonical_url_desc': '{{ trans("seolite::messages.missing_canonical_url_desc") }}',
                    'seolite::messages.missing_open_graph_tags': '{{ trans("seolite::messages.missing_open_graph_tags") }}',
                    'seolite::messages.missing_open_graph_tags_desc': '{{ trans("seolite::messages.missing_open_graph_tags_desc") }}',

                    // Tooltips
                    'seolite::messages.modify_in_theme_files': "{{ trans("seolite::messages.modify_in_theme_files") }}",
                    'seolite::messages.modify_in_admin_panel': "{{ trans("seolite::messages.modify_in_admin_panel") }}",

                    // Other keys
                    'seolite::messages.connect_google_console': '{{ trans("seolite::messages.connect_google_console") }}',
                    'seolite::messages.soon_seo_pro': '{{ trans("seolite::messages.soon_seo_pro") }}',
                    'seolite::messages.support': '{{ trans("seolite::messages.support") }}'
                };

                let value = translations[key] || key;
                if (params && typeof value === 'string') {
                    Object.keys(params).forEach(function(p) {
                        const re = new RegExp(':'+p, 'g');
                        value = value.replace(re, params[p]);
                    });
                }
                return value;
            }
        </script>

        <script src="{{plugin_asset('seolite', 'js/config.js')}}"></script>
        <script src="{{plugin_asset('seolite', 'js/utilities.js')}}"></script>

        <script>
            const APP = document.getElementById('app');

            const offCanvas = document.createElement('div');
            offCanvas.innerHTML = `@include("seolite::components.offcanvas.offcanvas")`;

            const triggerButton = document.createElement('div');
            triggerButton.innerHTML = `@include("seolite::components.offcanvas.trigger-button")`;

            APP.prepend(offCanvas);
            APP.prepend(triggerButton);

            document.addEventListener('DOMContentLoaded', function() {
                const offcanvas = document.getElementById('seoliteOffcanvas');

                if (offcanvas) {
                    offcanvas.addEventListener('hidden.bs.offcanvas', function() {
                        // Reset highlighting if there's a current element being viewed
                        if (CURRENT_ELM_VIEWING) {
                            CURRENT_ELM_VIEWING.style.outline = 'unset';
                            CURRENT_ELM_VIEWING.style.outlineOffset = 'unset';
                            CURRENT_ELM_VIEWING.style.boxShadow = 'unset';
                            CURRENT_ELM_VIEWING.style.border = 'unset';
                            CURRENT_ELM_VIEWING.style.position = CURRENT_ELM_VIEWING.dataset.originalPosition || 'unset';
                            CURRENT_ELM_VIEWING.style.zIndex = CURRENT_ELM_VIEWING.dataset.originalZIndex || 'unset';
                            CURRENT_ELM_VIEWING = null;
                        }
                    });

                    // Enable scrolling behind the open offcanvas
                    offcanvas.dataset.bsBackdrop = 'false';
                    offcanvas.dataset.bsScroll = 'true';
                }
            });
        </script>

        <script src="{{plugin_asset('seolite', 'js/module/headings.js')}}"></script>
        <script src="{{plugin_asset('seolite', 'js/module/metas.js')}}"></script>
        <script src="{{plugin_asset('seolite', 'js/module/img-alt.js')}}"></script>
        <script src="{{plugin_asset('seolite', 'js/module/img-opti.js')}}"></script>
        <script src="{{plugin_asset('seolite', 'js/module/readability.js')}}"></script>
        <script src="{{plugin_asset('seolite', 'js/module/keyword-analysis.js')}}"></script>
        <script src="{{plugin_asset('seolite', 'js/module/recommendations.js')}}"></script>
        <script src="{{plugin_asset('seolite', 'js/module/score.js')}}"></script>
    @endpush
@endcan
