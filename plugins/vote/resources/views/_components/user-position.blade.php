@php
    $displayVoteUser = $sessionVoteUser ?? (isset($user) && $user !== null ? $user : null);
    $displayVoteName = $sessionVoteName ?? ($displayVoteUser !== null ? $displayVoteUser->name : null);
    $knownTopPosition = null;
    $knownTopVotes = max(0, (int) ($sessionVoteCount ?? (isset($userVotes) ? $userVotes : 0)));

    if (isset($displayVoteName) && $displayVoteName !== '') {
        foreach ($votes as $position => $voteEntry) {
            if (isset($voteEntry->user) && $voteEntry->user->name === $displayVoteName) {
                $knownTopPosition = $position;
                $knownTopVotes = (int) $voteEntry->votes;
                break;
            }
        }
    }
@endphp

<div id="vote-known-user-row"
     class="table-responsive mt-4 {{ isset($displayVoteName) && $displayVoteName !== '' ? '' : 'd-none' }}">
    <p class="mb-1">Votre position</p>
    <table class="table my-0">
        <tbody>
            <tr>
                <th scope="row" id="vote-known-user-position-cell">
                    <span id="vote-known-user-position">{{ $knownTopPosition !== null ? '#'.$knownTopPosition : '-' }}</span>
                </th>
                <td>
                    <span>
                        <img id="vote-known-user-avatar" aria-hidden="true" class="rounded-1"
                             src="{{ isset($displayVoteUser) && $displayVoteUser !== null ? $displayVoteUser->getAvatar(24) : (isset($displayVoteName) && $displayVoteName !== '' ? 'https://mc-heads.net/avatar/'.rawurlencode($displayVoteName).'/24' : '') }}"
                             width="24"
                             alt="{{ $displayVoteName ?? '' }}">
                    </span>
                    <span id="vote-known-user-name" class="ms-2">{{ $displayVoteName ?? '' }}</span>
                </td>
                <td class="text-end">
                    <span id="vote-known-user-votes">{{ $knownTopVotes }}</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@once
    @push('scripts')
        <script>
            (function () {
                const syncKnownPositionCellWidth = function () {
                    const topTable = document.getElementById('vote-top-table');
                    const knownPositionCell = document.getElementById('vote-known-user-position-cell');

                    if (!topTable || !knownPositionCell) {
                        return;
                    }

                    const firstTopHeaderCell = topTable.querySelector('thead th:first-child');
                    if (!firstTopHeaderCell) {
                        return;
                    }

                    knownPositionCell.style.width = firstTopHeaderCell.getBoundingClientRect().width + 'px';
                };

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', syncKnownPositionCellWidth);
                } else {
                    syncKnownPositionCellWidth();
                }

                window.addEventListener('resize', syncKnownPositionCellWidth);
            })();
        </script>
    @endpush
@endonce
