@push('footer-scripts')
    <script>
        window.huntTranslations = @json(trans('hunt::messages'));
        window.HUNT_DEBUG = false;

        document.addEventListener('DOMContentLoaded', function () {
            if (document.querySelector('script[src*="hunt.js"]')) {
                return;
            }

            const huntScript = document.createElement('script');
            huntScript.src = '{{ plugin_asset('hunt', 'js/hunt.js') }}';
            huntScript.onload = function () {
                if (window.HUNT_DEBUG) {
                    console.debug('[Hunt] script loaded');
                }
            };
            huntScript.onerror = function () {
                console.error('Failed to load hunt system');
            };
            document.head.appendChild(huntScript);
        });
    </script>
@endpush

@push('styles')
    <style>
        .hunt-item {
            position: fixed !important;
            z-index: 9999 !important;
            cursor: pointer;
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.3s ease;
            animation: huntPulse 2s infinite;
            pointer-events: auto;
            user-select: none;
            -webkit-user-drag: none;
        }

        .hunt-item.hunt-visible {
            opacity: 1;
            transform: scale(1);
        }

        .hunt-item.hunt-removing {
            opacity: 0;
            transform: scale(0.5);
            pointer-events: none;
        }

        .hunt-image {
            max-width: 80px;
            max-height: 80px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
            border-radius: 8px;
        }

        @keyframes huntPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .hunt-item:hover {
            transform: scale(1.15) !important;
            filter: brightness(1.2);
        }

        /* Styles pour le modal Azuriom/Bootstrap */
        .hunt-modal .modal-dialog {
            z-index: 10000;
        }

        @media (max-width: 768px) {
            .hunt-image {
                max-width: 60px;
                max-height: 60px;
            }
        }

        .hunt-item:focus {
            outline: 3px solid #0d6efd;
            outline-offset: 2px;
        }

        .hunt-item.hunt-clicked {
            animation: huntSuccess 0.3s ease-out forwards;
        }

        @keyframes huntSuccess {
            0% { transform: scale(1); }
            50% { transform: scale(1.3) rotate(5deg); }
            100% { transform: scale(0) rotate(15deg); opacity: 0; }
        }
    </style>
@endpush
