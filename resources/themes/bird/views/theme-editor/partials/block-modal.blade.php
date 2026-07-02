<div id="teBlockModal" class="te-modal" hidden>
    <div class="te-modal-backdrop"></div>
    <div class="te-modal-content" role="dialog" aria-modal="true" aria-labelledby="teBlockModalTitle">
        <div class="te-modal-header">
            <h4 id="teBlockModalTitle" class="te-modal-title">{{ $te('modal.configure_block', 'Configurer le bloc') }}</h4>
            <button type="button" class="te-icon-btn" data-te-close-modal aria-label="{{ $te('common.close', 'Fermer') }}">×</button>
        </div>
        <div id="teBlockModalBody" class="te-modal-body"></div>
        <div class="te-modal-footer">
            <button type="button" class="te-btn te-btn-ghost" data-te-close-modal>{{ $te('modal.cancel', 'Annuler') }}</button>
            <button type="button" class="te-btn te-btn-primary" id="teBlockModalSave">{{ $te('modal.apply', 'Appliquer') }}</button>
        </div>
    </div>
</div>
