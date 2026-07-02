<section>
    <h3 class="te-section-title">Page Builder</h3>
    <p class="te-help">Ajoutez des blocs, réordonnez-les: la prévisualisation est appliquée en direct.</p>
    <p class="te-help mb-2">
        Route courante: <strong id="teCurrentRouteLabel"></strong>
        <span id="teCurrentRouteKey" class="te-route-key d-block"></span>
    </p>

    <div class="te-page-actions mb-2">
        <button type="button" id="teResetAll" class="te-btn te-btn-danger">Reset blocs page</button>
        <button type="button" id="teOpenCatalogModal" class="te-btn te-btn-success">Ajouter un bloc</button>
    </div>

    <div class="te-page-builder">
        <div class="te-page-column">
            <h4 class="te-column-title">Blocs actifs</h4>
            <div id="teActiveBlocks" class="te-block-list te-block-list-active"></div>
        </div>
    </div>

    <template id="teActiveBlockTemplate">
        <article class="te-block-item">
            <div class="te-block-head">
                <strong class="te-block-name"></strong>
                <small class="te-block-id"></small>
            </div>
            <div class="te-block-actions">
                <button type="button" class="te-btn te-btn-ghost" data-action="up">↑</button>
                <button type="button" class="te-btn te-btn-ghost" data-action="down">↓</button>
                <button type="button" class="te-btn te-btn-ghost" data-action="duplicate">Dupliquer</button>
                <button type="button" class="te-btn te-btn-primary" data-action="edit">Édition</button>
                <button type="button" class="te-btn te-btn-danger" data-action="delete">Supprimer</button>
            </div>
        </article>
    </template>

    <div id="teCatalogModal" class="te-modal" hidden>
        <div class="te-modal-backdrop" data-te-close-catalog-modal></div>
        <div class="te-modal-content" role="dialog" aria-modal="true" aria-labelledby="teCatalogModalTitle">
            <div class="te-modal-header">
                <h4 id="teCatalogModalTitle" class="te-modal-title">Ajouter un bloc</h4>
                <button type="button" class="te-icon-btn" data-te-close-catalog-modal aria-label="Fermer">×</button>
            </div>
            <div class="te-modal-body">
                <div id="teBlockCatalog" class="row g-2"></div>
            </div>
        </div>
    </div>
</section>
