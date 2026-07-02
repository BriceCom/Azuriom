<section>
    <h3 class="te-section-title">{{ $te('page.title', 'Page Builder') }}</h3>
    <p class="te-help">{{ $te('page.help', 'Ajoutez des blocs, réordonnez-les: la prévisualisation est appliquée en direct.') }}</p>
    <p class="te-help mb-2">
        {{ $te('page.current_route', 'Route courante:') }} <strong id="teCurrentRouteLabel"></strong>
        <span id="teCurrentRouteKey" class="te-route-key d-block"></span>
    </p>

    <div class="te-page-actions mb-2">
        <button type="button" id="teResetAll" class="te-btn te-btn-danger">{{ $te('page.reset_blocks', 'Réinitialiser les blocs de la page') }}</button>
        <button type="button" id="teOpenCatalogModal" class="te-btn te-btn-success">{{ $te('page.add_block', 'Ajouter un bloc') }}</button>
        <button type="button" id="tePageUndo" class="te-btn te-btn-ghost" disabled>
            <i class="bi bi-arrow-counterclockwise"></i>
            <span>{{ $te('page.undo', 'Annuler') }}</span>
        </button>
        <button type="button" id="tePageRedo" class="te-btn te-btn-ghost" disabled>
            <i class="bi bi-arrow-clockwise"></i>
            <span>{{ $te('page.redo', 'Rétablir') }}</span>
        </button>
    </div>

    <section class="mb-3">
        <h4 class="te-section-title mb-2">{{ $te('page.presets_title', 'Presets JSON') }}</h4>
        <p class="te-help mb-2">{{ $te('page.presets_help', 'Exporter ou réimporter l’état complet du thème édité, y compris les blocs de page.') }}</p>

        <div class="te-page-actions mb-2">
            <button type="button" id="tePresetExport" class="te-btn te-btn-primary">{{ $te('common.generate', 'Générer') }}</button>
            <button type="button" id="tePresetCopy" class="te-btn te-btn-ghost">{{ $te('common.copy', 'Copier') }}</button>
            <button type="button" id="tePresetDownload" class="te-btn te-btn-success">{{ $te('common.download', 'Télécharger') }}</button>
            <button type="button" id="tePresetImport" class="te-btn te-btn-warning">{{ $te('common.import', 'Importer') }}</button>
            <label for="tePresetFile" class="te-btn te-btn-ghost mb-0">{{ $te('common.load_file', 'Charger un fichier') }}</label>
            <input id="tePresetFile" type="file" accept="application/json,.json" hidden>
        </div>

        <textarea
            id="tePresetJson"
            class="te-input w-100"
            rows="8"
            placeholder="{{ $te('page.placeholder', 'Le JSON du preset s’affiche ici.') }}"
            spellcheck="false"
        ></textarea>
    </section>

    <div class="te-page-builder">
        <div class="te-page-column">
            <h4 class="te-column-title">{{ $te('page.active_blocks', 'Blocs actifs') }}</h4>
            <p class="te-help mb-2">{{ $te('page.reorder_hint', 'Glissez-déposez les blocs pour les réordonner.') }}</p>
            <div id="teActiveBlocks" class="te-block-list te-block-list-active"></div>
        </div>
    </div>

    <template id="teActiveBlockTemplate">
        <article class="te-block-item">
            <div class="te-block-head">
                <span class="te-block-handle" aria-hidden="true" title="{{ $te('page.block_actions.drag', 'Déplacer le bloc') }}">
                    <i class="bi bi-grip-vertical"></i>
                </span>
                <strong class="te-block-name"></strong>
                <small class="te-block-id"></small>
            </div>
            <div class="te-block-actions">
                <button type="button" class="te-btn te-btn-ghost" data-action="up">{{ $te('page.block_actions.up', 'Monter') }}</button>
                <button type="button" class="te-btn te-btn-ghost" data-action="down">{{ $te('page.block_actions.down', 'Descendre') }}</button>
                <button type="button" class="te-btn te-btn-ghost" data-action="duplicate">{{ $te('page.block_actions.duplicate', 'Dupliquer') }}</button>
                <button type="button" class="te-btn te-btn-primary" data-action="edit">{{ $te('page.block_actions.edit', 'Édition') }}</button>
                <button type="button" class="te-btn te-btn-danger" data-action="delete">{{ $te('page.block_actions.delete', 'Supprimer') }}</button>
            </div>
        </article>
    </template>

    <div id="teCatalogModal" class="te-modal" hidden>
        <div class="te-modal-backdrop" data-te-close-catalog-modal></div>
        <div class="te-modal-content" role="dialog" aria-modal="true" aria-labelledby="teCatalogModalTitle">
            <div class="te-modal-header">
                <h4 id="teCatalogModalTitle" class="te-modal-title">{{ $te('page.catalog_title', 'Ajouter un bloc') }}</h4>
                <button type="button" class="te-icon-btn" data-te-close-catalog-modal aria-label="{{ $te('common.close', 'Fermer') }}">×</button>
            </div>
            <div class="te-modal-body">
                <div id="teBlockCatalog" class="row g-2"></div>
            </div>
        </div>
    </div>
</section>
