@php
    $knownVoteName = $sessionVoteName ?? null;
    $hasKnownVoteName = filled($knownVoteName);
@endphp

<div>
    <div id="vote-session-form" class="col-md-6 {{ $hasKnownVoteName ? 'd-none ' : '' }}d-flex flex-column flex-md-row align-items-md-center gap-3">
        <input type="text" id="stepNameInput" name="name" class="form-control w-100"
               value="{{ $hasKnownVoteName ? $knownVoteName : $name }}"
               placeholder="Votre pseudo en jeu" required>

        <button type="submit" class="w-fit btn btn-primary text-uppercase">
            {{ trans('messages.actions.continue') }}
            <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
        </button>
    </div>

    @include('vote::_components.known-session-user', [
        'containerId' => 'vote-session-known',
        'containerClass' => '',
        'knownVoteName' => $knownVoteName,
        'isVisible' => $hasKnownVoteName,
        'avatarId' => 'vote-session-avatar',
        'nameId' => 'vote-session-name',
        'buttonId' => 'vote-change-name',
    ])
</div>

@once
    @push('scripts')
        @guest
            <script>
                (function () {
                    if (window.__hyversVoteSessionUserInitialized) {
                        return;
                    }

                    window.__hyversVoteSessionUserInitialized = true;

                    const initSessionUser = function () {
                        const voteNameForm = document.getElementById('voteNameForm');
                        const nameInput = document.getElementById('stepNameInput');
                        const formContainer = document.getElementById('vote-session-form');
                        const knownContainer = document.getElementById('vote-session-known');
                        const knownContainerStep2 = document.getElementById('vote-session-known-step2');
                        const knownNameElement = document.getElementById('vote-session-name');
                        const knownNameElementStep2 = document.getElementById('vote-session-name-step2');
                        const knownAvatarElement = document.getElementById('vote-session-avatar');
                        const knownAvatarElementStep2 = document.getElementById('vote-session-avatar-step2');
                        const changeNameButton = document.getElementById('vote-change-name');
                        const changeNameButtons = document.querySelectorAll('.vote-change-name-action');
                        const knownUserRow = document.getElementById('vote-known-user-row');
                        const knownUserPosition = document.getElementById('vote-known-user-position');
                        const knownUserAvatar = document.getElementById('vote-known-user-avatar');
                        const knownUserName = document.getElementById('vote-known-user-name');
                        const knownUserVotes = document.getElementById('vote-known-user-votes');

                        if (!voteNameForm || !nameInput || !formContainer || !knownContainer || !knownNameElement || !changeNameButton) {
                            return;
                        }

                        const normalizeName = function (name) {
                            return (name || '').trim();
                        };

                        const getTopTableInfo = function (name) {
                            if (!knownUserRow) {
                                return null;
                            }

                            const cleanName = normalizeName(name);
                            if (!cleanName) {
                                return null;
                            }
                            const normalizedTarget = cleanName.toLowerCase();

                            const cardBody = knownUserRow.closest('.card-body');
                            if (!cardBody) {
                                return null;
                            }

                            const mainTopTable = cardBody.querySelector('table.table');
                            if (!mainTopTable) {
                                return null;
                            }

                            const rows = mainTopTable.querySelectorAll('tbody tr');

                            for (let i = 0; i < rows.length; i++) {
                                const row = rows[i];
                                const nameCell = row.querySelector('td');
                                if (!nameCell) {
                                    continue;
                                }

                                const rowName = normalizeName(nameCell.textContent);
                                if (rowName.toLowerCase() !== normalizedTarget) {
                                    continue;
                                }

                                const positionCell = row.querySelector('th');
                                const votesCell = row.querySelector('td:last-child');
                                const positionText = normalizeName(positionCell ? positionCell.textContent : '');
                                const fallbackPosition = '#' + String(i + 1);
                                const position = positionText !== '' ? positionText : fallbackPosition;
                                const rawVotes = votesCell ? votesCell.textContent : '';
                                const numericVotes = parseInt(String(rawVotes).replace(/[^\d-]/g, ''), 10);

                                return {
                                    position: position || '-',
                                    votes: Number.isNaN(numericVotes) ? null : numericVotes,
                                };
                            }

                            return null;
                        };

                        const formatPosition = function (position) {
                            if (typeof position === 'number' && Number.isFinite(position) && position > 0) {
                                return '#' + String(position);
                            }

                            if (typeof position !== 'string') {
                                return null;
                            }

                            const cleanPosition = position.trim();
                            if (cleanPosition === '' || cleanPosition === '-') {
                                return null;
                            }

                            return cleanPosition.startsWith('#') ? cleanPosition : '#' + cleanPosition;
                        };

                        const updateKnownUserRow = function (name, votes, position) {
                            if (!knownUserRow || !knownUserAvatar || !knownUserName) {
                                return;
                            }

                            const cleanName = normalizeName(name);
                            if (!cleanName) {
                                return;
                            }

                            knownUserName.textContent = cleanName;
                            knownUserAvatar.src = 'https://mc-heads.net/avatar/' + encodeURIComponent(cleanName) + '/24';
                            knownUserAvatar.alt = cleanName;
                            knownUserRow.classList.remove('d-none');

                            const previousName = normalizeName(knownUserRow.getAttribute('data-current-name'));
                            const isSamePlayer = previousName !== '' && previousName.toLowerCase() === cleanName.toLowerCase();
                            const topInfo = getTopTableInfo(cleanName);
                            const providedPosition = formatPosition(position);
                            const topTablePosition = topInfo && topInfo.position ? formatPosition(topInfo.position) : null;
                            const currentPosition = isSamePlayer && knownUserPosition ? formatPosition(knownUserPosition.textContent) : null;
                            const resolvedPosition = providedPosition || topTablePosition || currentPosition || '-';

                            if (knownUserPosition) {
                                knownUserPosition.textContent = resolvedPosition;
                            }

                            let resolvedVotes = null;
                            if (typeof votes === 'number') {
                                resolvedVotes = votes;
                            } else if (topInfo && typeof topInfo.votes === 'number') {
                                resolvedVotes = topInfo.votes;
                            }

                            if (knownUserVotes && typeof resolvedVotes === 'number') {
                                knownUserVotes.textContent = String(resolvedVotes);
                            }

                            knownUserRow.setAttribute('data-current-name', cleanName);
                        };

                        const updateKnownPanels = function (name) {
                            const cleanName = normalizeName(name);

                            if (!cleanName) {
                                return;
                            }

                            if (knownNameElement) {
                                knownNameElement.textContent = cleanName;
                            }

                            if (knownNameElementStep2) {
                                knownNameElementStep2.textContent = cleanName;
                            }

                            if (knownAvatarElement) {
                                knownAvatarElement.src = 'https://mc-heads.net/avatar/' + encodeURIComponent(cleanName) + '/24';
                                knownAvatarElement.alt = cleanName;
                            }

                            if (knownAvatarElementStep2) {
                                knownAvatarElementStep2.src = 'https://mc-heads.net/avatar/' + encodeURIComponent(cleanName) + '/24';
                                knownAvatarElementStep2.alt = cleanName;
                            }

                            knownContainer.classList.remove('d-none');
                            if (knownContainerStep2) {
                                knownContainerStep2.classList.remove('d-none');
                                knownContainerStep2.classList.add('d-flex');
                            }
                        };

                        const hideKnownUserRow = function () {
                            if (!knownUserRow) {
                                return;
                            }

                            knownUserRow.classList.add('d-none');
                            knownUserRow.removeAttribute('data-current-name');
                        };

                        const setEditState = function () {
                            knownContainer.classList.add('d-none');
                            if (knownContainerStep2) {
                                knownContainerStep2.classList.remove('d-flex');
                                knownContainerStep2.classList.add('d-none');
                            }
                            formContainer.classList.remove('d-none');

                            if (typeof toggleStep === 'function') {
                                toggleStep(1);
                            }

                            nameInput.focus();
                        };

                        voteNameForm.addEventListener('submit', function () {
                            const typedName = normalizeName(nameInput.value);

                            if (!typedName) {
                                return;
                            }

                            updateKnownPanels(typedName);
                            updateKnownUserRow(typedName);
                        });

                        const verifyUserBaseUrl = voteNameForm.getAttribute('action');
                        if (window.axios && verifyUserBaseUrl && !window.__voteKnownUserInterceptorAttached) {
                            window.__voteKnownUserInterceptorAttached = true;

                            axios.interceptors.response.use(function (response) {
                                const responseConfig = response && response.config ? response.config : null;
                                const responseUrl = responseConfig && typeof responseConfig.url === 'string'
                                    ? responseConfig.url
                                    : '';

                                if (responseUrl.indexOf(verifyUserBaseUrl + '/') === -1) {
                                    return response;
                                }

                                const currentName = normalizeName(nameInput.value || knownNameElement.textContent);
                                if (!currentName) {
                                    return response;
                                }

                                const payload = response && response.data ? response.data : null;
                                const liveVotes = payload && typeof payload.votes === 'number' ? payload.votes : null;
                                const livePosition = payload && Object.prototype.hasOwnProperty.call(payload, 'position')
                                    ? payload.position
                                    : null;

                                updateKnownUserRow(currentName, liveVotes, livePosition);

                                return response;
                            }, function (error) {
                                return Promise.reject(error);
                            });
                        }

                        changeNameButtons.forEach(function (button) {
                            button.addEventListener('click', function (event) {
                                event.preventDefault();
                                setEditState();
                                hideKnownUserRow();

                                const clearSessionUrl = button.getAttribute('data-clear-url');

                                if (!clearSessionUrl) {
                                    return;
                                }

                                fetch(clearSessionUrl, {
                                    method: 'GET',
                                    credentials: 'same-origin',
                                }).catch(function () {
                                    // Le switch UI reste localement fonctionnel même si la purge session échoue.
                                });
                            });
                        });

                        const knownName = normalizeName(knownNameElement.textContent);

                        if (!knownContainer.classList.contains('d-none') && knownName && typeof setupVoteTimers === 'function') {
                            updateKnownPanels(knownName);
                            updateKnownUserRow(knownName);
                            setupVoteTimers(knownName);
                        }
                    };

                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', initSessionUser);
                    } else {
                        initSessionUser();
                    }
                })();
            </script>
        @endguest
    @endpush
@endonce
