@extends('admin.layouts.admin')

@section('title', 'Reborn')

@section('content')
    @php
        $defaultComposer = [
            'schema_version' => 1,
            'theme' => [
                'mode' => 'light',
                'header' => [
                    'position' => 'top',
                    'width' => 280,
                ],
                'footer' => [
                    'position' => 'default',
                ],
                'colorsLight' => [
                    'primary' => '#0d6efd',
                    'secondary' => '#6c757d',
                    'success' => '#198754',
                    'info' => '#0dcaf0',
                    'warning' => '#ffc107',
                    'danger' => '#dc3545',
                    'light' => '#f8f9fa',
                    'dark' => '#212529',
                    'body' => '#ffffff',
                    'text' => '#212529',
                ],
                'colorsDark' => [
                    'primary' => '#6ea8fe',
                    'secondary' => '#adb5bd',
                    'success' => '#75b798',
                    'info' => '#6edff6',
                    'warning' => '#ffda6a',
                    'danger' => '#ea868f',
                    'light' => '#f8f9fa',
                    'dark' => '#dee2e6',
                    'body' => '#111827',
                    'text' => '#f1f5f9',
                ],
                'bootstrap' => [
                    'buttonRadius' => 6,
                    'cardPaddingY' => 16,
                    'cardPaddingX' => 16,
                    'buttonPaddingY' => 6,
                    'buttonPaddingX' => 12,
                    'buttonWeight' => 500,
                    'formRadius' => 6,
                    'navPaddingY' => 0.5,
                    'navPaddingX' => 0.85,
                    'cardShadowLevel' => 1,
                    'buttonShadowLevel' => 0,
                    'linkColor' => '#0d6efd',
                    'linkHoverColor' => '#0a58ca',
                ],
            ],
            'global' => [
                'blocks' => [
                    ['id' => 'global-custom-css', 'type' => 'custom-css', 'enabled' => true, 'settings' => ['css' => '']],
                ],
                'sidebar_blocks' => [],
            ],
            'pages' => [],
        ];
    @endphp

    <div class="row g-3">
        <div class="col-12">
            <div class="alert alert-info mb-0">
                <i class="bi bi-info-circle"></i>
                Le thème <strong>Reborn</strong> se configure côté front avec le panneau
                <strong>“{{ trans('theme::reborn.open_builder') }}”</strong> (admin uniquement).
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="h5 mb-3">Réinitialisation</h2>
                    <p class="text-muted mb-4">
                        Cette action remet la configuration Reborn (position header/footer, blocs globaux, sidebar, blocs de page et styles)
                        à l'état par défaut.
                    </p>

                    <form action="{{ route('admin.themes.config', $theme) }}" method="POST">
                        @csrf
                        <input type="hidden" name="composer" value="{{ json_encode($defaultComposer, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}">
                        <button type="submit" class="btn btn-outline-danger"
                                onclick="return confirm('Confirmer la réinitialisation complète de Reborn ?');">
                            <i class="bi bi-arrow-counterclockwise"></i> Réinitialiser Reborn
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
