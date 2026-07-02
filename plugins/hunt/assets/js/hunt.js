/**
 * Hunt Plugin JavaScript
 * Handles hunt item spawning, positioning, interactions, and modals
 */

class HuntManager {
    constructor() {
        this.huntData = null;
        this.currentHuntItem = null;
        this.lastClickTime = 0;
        this.isProcessingClaim = false;
        this.spawnTimeout = null;
        this.modalBootstrap = null;
        this.translations = window.huntTranslations || {};
        this.hasSeenHunt = false;
        this.debug = window.HUNT_DEBUG === true;

        this.init();
    }

    /**
     * Log debug messages when debug mode is enabled.
     */
    log(...args) {
        if (this.debug) {
            console.log('[Hunt]', ...args);
        }
    }

    /**
     * Get translated text with parameter replacement
     */
    getTranslation(key, params = null) {
        const runtimeTranslations = window.huntTranslations || {};

        if (Object.keys(runtimeTranslations).length > 0) {
            this.translations = runtimeTranslations;
        }

        let text = this.translations[key] || key.replaceAll('_', ' ');

        if (params && typeof text === 'string') {
            Object.keys(params).forEach(function(paramKey) {
                const regex = new RegExp(':' + paramKey, 'g');
                text = text.replace(regex, params[paramKey]);
            });
        }

        return text;
    }

    /**
     * Initialize the hunt system
     */
    async init() {
        this.log('Initializing hunt manager');

        try {
            await this.loadHuntData();

            if (this.huntData?.hunt) {
                this.createModal();
                this.scheduleNextSpawn();

                if (!this.huntData.user?.authenticated) {
                    this.setupOfflineHandling();
                }
            }
        } catch (error) {
            console.error('Hunt initialization failed:', error);
        }
    }


    /**
     * Load hunt data from server
     */
    async loadHuntData() {
        const response = await fetch('/hunt/data', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        this.huntData = await response.json();
        this.log('Loaded hunt data', this.huntData);
    }

    /**
     * Schedule the next hunt spawn based on spawn rate and user conditions
     */
    scheduleNextSpawn() {
        const auth = this.huntData.user?.authenticated;
        this.log('Hunt: Scheduling next spawn, authenticated:', auth);

        if (!this.huntData?.hunt || this.huntData.hunt.is_capped) {
            this.log('Hunt: No hunt available or hunt is capped, stopping spawn scheduling');
            return;
        }

        if (!auth && this.hasSeenHunt) {
            this.log('Hunt: Unauthenticated user has already seen a hunt, no more spawns');
            return;
        }

        if (this.spawnTimeout) {
            clearTimeout(this.spawnTimeout);
        }

        if (auth && this.huntData.user.progress?.on_cooldown) {
            const cooldownMs = this.huntData.user.progress.cooldown_remaining_minutes * 60 * 1000;
            const minDelay = Math.max(cooldownMs, 5000);
            this.log('Hunt: User on cooldown, waiting', minDelay / 1000, 'seconds');
            this.spawnTimeout = setTimeout(() => this.scheduleNextSpawn(), minDelay);
            return;
        }

        if (auth && this.huntData.user.progress?.remaining_claims <= 0) {
            this.log('Hunt: User reached daily limit, no more spawns');
            return;
        }

        const spawnRate = this.huntData.hunt.spawn_rate || 50;
        const spawnDelaySeconds = this.huntData.hunt.spawn_delay_seconds || 0;

        this.log('Hunt: Spawn rate:', spawnRate + '%', 'Spawn delay:', spawnDelaySeconds, 'seconds');

        const spawnDelayMs = spawnDelaySeconds * 1000;

        if (spawnDelayMs > 0) {
            this.log('Hunt: Waiting spawn delay of', spawnDelaySeconds, 'seconds before attempting spawn');
            this.spawnTimeout = setTimeout(() => {
                this.attemptSpawnWithProbability(spawnRate);
            }, spawnDelayMs);
        } else {
            this.attemptSpawnWithProbability(spawnRate);
        }
    }

    /**
     * Attempt spawn based on probability
     */
    attemptSpawnWithProbability(spawnRate) {
        const randomChance = Math.random() * 100;
        this.log('Hunt: Spawn attempt - chance roll:', randomChance.toFixed(2), 'needed:', spawnRate);

        if (randomChance <= spawnRate) {
            this.log('Hunt: Spawn successful! Hunt appearing...');
            this.trySpawnHunt();
        } else {
            this.log('Hunt: Spawn failed, scheduling next attempt');
            const nextAttemptDelay = (30 + Math.random() * 30) * 1000;
            this.spawnTimeout = setTimeout(() => this.scheduleNextSpawn(), nextAttemptDelay);
        }
    }

    testSpawn() {
        this.log('Hunt : test mode spawn')
        const spawnDelayMs = (this.huntData.hunt.spawn_delay_seconds || 0) * 1000;

        this.spawnTimeout = setTimeout(() => {
            this.trySpawnHunt();
        }, spawnDelayMs);
    }

    /**
     * Attempt to spawn a hunt item
     */
    trySpawnHunt() {
        if (this.currentHuntItem || !this.huntData?.hunt) {
            this.log('Hunt: Cannot spawn - hunt item already exists or no hunt data');
            this.scheduleNextSpawn();
            return;
        }

        this.log('Hunt: Spawning hunt item:', this.huntData.hunt.name);
        this.spawnHuntItem();
    }

    /**
     * Spawn hunt item on screen
     */
    spawnHuntItem() {
        this.log('Hunt: Creating hunt item element');
        const huntItem = document.createElement('div');
        huntItem.className = 'hunt-item';
        huntItem.tabIndex = 0;
        huntItem.innerHTML = `
            <img src="${this.huntData.hunt.image}"
                 alt="${this.huntData.hunt.name}"
                 class="hunt-image">
        `;

        this.positionHuntItem(huntItem);

        huntItem.addEventListener('click', (e) => this.handleHuntClick(e));

        huntItem.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.handleHuntClick(e);
            }
        });

        document.body.appendChild(huntItem);
        this.currentHuntItem = huntItem;
        this.log('Hunt: Hunt item added to page and visible');

        if (!this.huntData.user?.authenticated) {
            this.hasSeenHunt = true;
            this.log('Hunt: Marked hunt as seen for unauthenticated user');
        }

        setTimeout(() => huntItem.classList.add('hunt-visible'), 50);
    }

    /**
     * Position hunt item randomly on screen
     */
    positionHuntItem(element) {
        const maxX = window.innerWidth - 100;
        const maxY = window.innerHeight - 100;

        const x = Math.random() * maxX;
        const y = Math.random() * maxY;

        element.style.left = x + 'px';
        element.style.top = y + 'px';
    }

    /**
     * Handle hunt item click
     */
    async handleHuntClick(event) {
        this.log('Hunt: Hunt item clicked!');
        event.preventDefault();
        event.stopPropagation();

        if (!event.isTrusted) {
            this.log('Hunt: Click rejected - not a trusted user event (possible bot)');
            return;
        }

        const now = Date.now();
        if (now - this.lastClickTime < 2000) {
            this.log('Hunt: Click rejected - too fast clicking (anti-bot protection)');
            return;
        }
        this.lastClickTime = now;

        if (this.isProcessingClaim) {
            this.log('Hunt: Click rejected - already processing a claim');
            return;
        }

        this.log('Hunt: Processing hunt claim...');
        this.isProcessingClaim = true;

        try {
            await this.processClaim();
        } finally {
            this.isProcessingClaim = false;
        }
    }

    /**
     * Process hunt claim
     */
    async processClaim() {
        this.log('Hunt: Sending claim request to server...');
        try {
            const response = await fetch('/hunt/claim', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            });

            this.log('Hunt: Received server response, status:', response.status);
            const result = await response.json();
            this.log('Hunt: Claim result:', result);

            this.removeHuntItem();

            if (result.success) {
                this.log('Hunt: Claim successful! Showing success modal');
                this.showSuccessModal(result);
                if (this.huntData.user?.authenticated) {
                    this.huntData.user.progress = result.user_progress;
                    this.log('Hunt: Updated user progress:', result.user_progress);
                }
            } else {
                this.log('Hunt: Claim failed, showing error modal:', result.message);
                this.showErrorModal(result);
            }

        } catch (error) {
            console.error('Hunt: Claim processing failed with error:', error);
            this.removeHuntItem();
            this.showGenericErrorModal();
        }

        this.log('Hunt: Scheduling next spawn after claim processing');
        this.scheduleNextSpawn();
    }

    /**
     * Remove current hunt item
     */
    removeHuntItem() {
        if (this.currentHuntItem) {
            this.currentHuntItem.classList.add('hunt-removing');
            setTimeout(() => {
                if (this.currentHuntItem) {
                    this.currentHuntItem.remove();
                    this.currentHuntItem = null;
                }
            }, 300);
        }
    }

    /**
     * Create Bootstrap modal for hunt results
     */
    createModal() {
        const modalHtml = `
            <div class="modal fade" id="huntModal" tabindex="-1" aria-labelledby="huntModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="huntModalLabel">${this.getTranslation('hunt_result')}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="${this.getTranslation('close')}"></button>
                        </div>
                        <div class="modal-body" id="huntModalBody">
                            <!-- Content  -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">${this.getTranslation('close')}</button>
                            <a href="/hunt" class="btn btn-primary" id="huntLeaderboardBtn">${this.getTranslation('view_leaderboard_btn')}</a>
                        </div>
                    </div>
                </div>
            </div>
        `;

        const existingModal = document.getElementById('huntModal');
        if (existingModal) {
            existingModal.remove();
        }

        document.body.insertAdjacentHTML('beforeend', modalHtml);

        const modalElement = document.getElementById('huntModal');
        this.modalBootstrap = new bootstrap.Modal(modalElement);
    }

    /**
     * Show success modal
     */
    showSuccessModal(result) {
        const modalBody = document.getElementById('huntModalBody');
        const modalTitle = document.getElementById('huntModalLabel');

        modalTitle.textContent = result.hunt.name;

        let content = '';

        if (result.reward) {
            content += `
                <div class="mb-3">
                    <p class="fw-semibold mb-1">${this.getTranslation('reward_received', {reward: result.reward.name})}</p>
                    ${result.reward.money > 0 ? `<p class="mb-0">${this.getTranslation('money_earned_amount', {amount: result.reward.money})}</p>` : ''}
                </div>
            `;
        } else {
            content += `
                <div class="alert alert-info">
                    <p>${this.getTranslation('no_reward_this_time')}</p>
                </div>
            `;
        }

        if (result.user_progress) {
            content += `
                <hr class="my-3">
                <div>
                    <p class="fw-semibold mb-2">${this.getTranslation('daily_progress')}</p>
                    <p class="mb-2">${this.getTranslation('daily_progress_summary', {current: result.user_progress.claims_today, total: result.user_progress.max_claims})}</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: ${(result.user_progress.claims_today / result.user_progress.max_claims * 100)}%" aria-valuenow="${result.user_progress.claims_today}" aria-valuemin="0" aria-valuemax="${result.user_progress.max_claims}"></div>
                    </div>
                </div>
            `;
        }

        if (result.global_cap && result.global_cap > 0) {
            content += `
                <hr class="my-3">
                <div class="mt-3">
                    <p>${this.getTranslation('total_claims')}: ${result.global_claims} / ${result.global_cap}</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar"
                             style="width: ${(result.global_claims / result.global_cap * 100)}%"
                             aria-valuenow="${result.global_claims}"
                             aria-valuemin="0"
                             aria-valuemax="${result.global_cap}">
                        </div>
                    </div>
                </div>
            `;
        }

        if (result.warnings && result.warnings.length > 0) {
            content += `
                <div class="alert alert-warning mt-3">
                    <h6>${this.getTranslation('warnings')}:</h6>
                    <ul>
                        ${result.warnings.map(warning => `<li>${warning}</li>`).join('')}
                    </ul>
                </div>
            `;
        }

        modalBody.innerHTML = content;

        const leaderboardBtn = document.getElementById('huntLeaderboardBtn');
        leaderboardBtn.href = this.buildHuntUrl(result.hunt);

        this.modalBootstrap.show();
    }

    /**
     * Show error modal
     */
    showErrorModal(result) {
        const modalBody = document.getElementById('huntModalBody');
        const modalTitle = document.getElementById('huntModalLabel');

        modalTitle.textContent = result.hunt?.name || this.getTranslation('title');

        let content = '';

        switch (result.error) {
            case 'not_authenticated':
                content = `
                    <div class="alert alert-warning">
                        <h6>${this.huntData.hunt.name}</h6>
                        <p>${this.getTranslation('unfortunately_not_logged_in')}</p>
                    </div>
                `;
                break;

            case 'global_cap_reached':
                content = `
                    <div class="alert alert-info">
                        <h6>${result.hunt.name}</h6>
                        <p>${this.getTranslation('hunt_cap_reached')}</p>
                        ${result.hunt.global_cap ? `<p>${this.getTranslation('total_rewards_given', {total: result.hunt.global_cap})}</p>` : ''}
                    </div>
                `;
                break;

            case 'daily_limit_reached':
                content = `
                    <div class="alert alert-info">
                        <h6>${this.getTranslation('daily_limit_reached')}</h6>
                        <p>${this.getTranslation('daily_limit_message')}</p>
                        ${result.user_progress ? `<p>${this.getTranslation('claims_today')}: ${result.user_progress.claims_today} / ${result.user_progress.max_claims}</p>` : ''}
                    </div>
                `;
                break;

            case 'cooldown_active':
                content = `
                    <div class="alert alert-warning">
                        <h6>${this.getTranslation('cooldown_active')}</h6>
                        <p>${this.getTranslation('cooldown_remaining')}</p>
                        ${result.cooldown_remaining ? `<p>${this.getTranslation('time_remaining')}: ${result.cooldown_remaining} ${this.getTranslation('minutes')}</p>` : ''}
                    </div>
                `;
                break;

            case 'spawn_failed':
                content = `
                    <div class="alert alert-info">
                        <h6>${this.getTranslation('better_luck_next_time')}</h6>
                        <p>${this.getTranslation('hunt_didnt_reward')}</p>
                        ${result.cooldown_minutes ? `<p>${this.getTranslation('next_attempt_available', {minutes: result.cooldown_minutes})}</p>` : ''}
                    </div>
                `;
                break;

            default:
                content = `
                    <div class="alert alert-danger">
                        <h6>${this.getTranslation('error')}</h6>
                        <p>${result.message || this.getTranslation('failed_to_process')}</p>
                    </div>
                `;
        }

        modalBody.innerHTML = content;

        const leaderboardBtn = document.getElementById('huntLeaderboardBtn');
        leaderboardBtn.href = this.buildHuntUrl(result.hunt);

        this.modalBootstrap.show();
    }

    /**
     * Build the hunt detail URL from available hunt data.
     */
    buildHuntUrl(hunt) {
        if (hunt?.id) {
            return `/hunt/${hunt.id}`;
        }

        return '/hunt';
    }

    /**
     * Show generic error modal
     */
    showGenericErrorModal() {
        const modalBody = document.getElementById('huntModalBody');
        const modalTitle = document.getElementById('huntModalLabel');

        modalTitle.textContent = this.getTranslation('hunt_error');
        modalBody.innerHTML = `
            <div class="alert alert-danger">
                <h6>${this.getTranslation('connection_error')}</h6>
                <p>${this.getTranslation('failed_to_process')}</p>
            </div>
        `;

        this.modalBootstrap.show();
    }

    /**
     * Setup handling for offline users
     */
    setupOfflineHandling() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('.hunt-item') && !this.huntData.user?.authenticated) {
                e.preventDefault();
                e.stopPropagation();

                this.removeHuntItem();
                this.showOfflineModal();
            }
        });
    }

    /**
     * Show offline user modal
     */
    showOfflineModal() {
        const modalBody = document.getElementById('huntModalBody');
        const modalTitle = document.getElementById('huntModalLabel');

        modalTitle.textContent = this.huntData.hunt.name;
        modalBody.innerHTML = `
            <div class="alert alert-warning">
                <h6>${this.huntData.hunt.name}</h6>
                <p>${this.getTranslation('unfortunately_not_logged_in')}</p>
            </div>
        `;

        this.modalBootstrap.show();
        this.scheduleNextSpawn();
    }
}


new HuntManager();
