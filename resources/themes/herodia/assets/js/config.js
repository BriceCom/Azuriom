document.addEventListener('DOMContentLoaded', initVoteRewardsManagement);

function initVoteRewardsManagement() {
    document.querySelectorAll('.vote-reward-remove').forEach(attachRemoveListener);

    const addBtn = document.getElementById('addVoteRewardButton');
    if (addBtn) addBtn.addEventListener('click', addVoteReward);
}

function attachRemoveListener(btn) {
    btn.addEventListener('click', () => {
        const card = btn.closest('.vote-reward-card');
        if (card) card.remove();
    });
}

function addVoteReward() {
    const container = document.querySelector('#vote-rewards-container');
    if (!container) return;

    const index = container.querySelectorAll('.vote-reward-card').length;
    const positionLabel = 'Position';
    const rewardLabel = 'Reward';
    const positionPlaceholder = '1';
    const rewardPlaceholder = '5 diamond';
    const removeTitle = 'Remove';

    const html = `<div class="card mb-3 vote-reward-card border-secondary">
        <div class="card-body p-0">
            <div class="row align-items-end g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-hash me-2"></i>
                            ${positionLabel}
                        </label>
                        <input type="text" class="form-control" name="vote[rewards][${index}][position]" placeholder="${positionPlaceholder}">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label class="form-label fw-semibold">
                            ${rewardLabel}
                        </label>
                        <input type="text" class="form-control" name="vote[rewards][${index}][reward]" placeholder="${rewardPlaceholder}">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <button class="btn btn-outline-danger btn-sm vote-reward-remove w-100" type="button" title="${removeTitle}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>`;

    container.insertAdjacentHTML('beforeend', html);
    const newBtn = container.querySelector('.vote-reward-card:last-child .vote-reward-remove');
    if (newBtn) attachRemoveListener(newBtn);
}
