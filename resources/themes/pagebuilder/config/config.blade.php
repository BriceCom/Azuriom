@extends('admin.layouts.admin')

@section('title', 'PageBuilder')

@section('content')
    @php
        $defaultPagebuilder = [
            'schema_version' => 3,
            'pages' => [],
            'global_sections' => [
                'headers' => ['active_id' => null, 'templates' => []],
                'footers' => ['active_id' => null, 'templates' => []],
            ],
        ];
    @endphp

    <div class="row g-3">
        <div class="col-12">
            <div class="alert alert-info mb-0">
                <i class="bi bi-info-circle"></i>
                Le thème <strong>PageBuilder</strong> se configure directement depuis le front avec le bouton
                <strong>“{{ trans('theme::pagebuilder.edit_page') }}”</strong> (admin uniquement).
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="h5 mb-3">Actions</h2>
                    <p class="text-muted mb-4">
                        En cas de besoin, vous pouvez réinitialiser la configuration du builder et les styles globaux.
                    </p>

                    <form action="{{ route('admin.themes.config', $theme) }}" method="POST">
                        @csrf
                        <input type="hidden" name="pagebuilder" value="{{ json_encode($defaultPagebuilder, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}">
                        <input type="hidden" name="styles" value="{}">
                        <button type="submit" class="btn btn-outline-danger"
                                onclick="return confirm('Confirmer la réinitialisation du PageBuilder ?');">
                            <i class="bi bi-arrow-counterclockwise"></i> Réinitialiser la configuration
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
