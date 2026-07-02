document.addEventListener('DOMContentLoaded', function() {
    initVotingButtons();
});

/**
 * Initialize all voting buttons on the page
 */
function initVotingButtons() {
    const suggestionVoteForms = document.querySelectorAll('form[data-vote][data-suggestion-id]');

    const commentVoteForms = document.querySelectorAll('form[data-vote][data-comment-id]');

    // Add event listeners to suggestion vote forms
    suggestionVoteForms.forEach(form => {
        form.addEventListener('submit', handleVoteSubmit);
    });

    // Add event listeners to comment vote forms
    commentVoteForms.forEach(form => {
        form.addEventListener('submit', handleCommentVoteSubmit);
    });
}

/**
 * Handle comment vote form submission
 * @param {Event} event - The submit event
 */
function handleCommentVoteSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const button = form.querySelector('button[type="submit"]');
    const commentId = form.dataset.commentId;
    const suggestionId = form.closest('.comment').querySelector('[data-suggestion-id]')?.dataset.suggestionId ||
                        document.querySelector('[data-suggestion-id]')?.dataset.suggestionId;
    const voteType = form.querySelector('input[name="type"]').value;
    const csrfToken = form.querySelector('input[name="_token"]').value;

    const isActive = button.classList.contains('active');
    const shouldUnvote = isActive;

    const endpoint = shouldUnvote ?
        `/api/suggest/${suggestionId}/comments/${commentId}/unvote` :
        `/api/suggest/${suggestionId}/comments/${commentId}/vote`;

    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        credentials: 'include',
        body: JSON.stringify({ type: voteType })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.comment) {
            console.log(data.user_vote);
            updateCommentVoteCounts(commentId, data.comment);
            updateCommentVoteButtons(commentId, data.user_vote);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

/**
 * Handle vote form submission
 * @param {Event} event - The submit event
 */
function handleVoteSubmit(event) {
    event.preventDefault();
    const form = event.target;
    const button = form.querySelector('button[type="submit"]');
    const suggestionId = form.dataset.suggestionId;
    const voteType = form.querySelector('input[name="type"]').value;
    const csrfToken = form.querySelector('input[name="_token"]').value;

    const isActive = button.classList.contains('active');
    const shouldUnvote = isActive;

    const endpoint = shouldUnvote ? `/api/suggest/${suggestionId}/unvote` : `/api/suggest/${suggestionId}/vote`;

    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        credentials: 'include',
        body: JSON.stringify({ type: voteType })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.suggestion) {
            console.log(data.user_vote);
            updateVoteCounts(suggestionId, data.suggestion);
            updateVoteButtons(suggestionId, data.user_vote);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

/**
 * Update vote counts for a comment
 * @param {number} commentId - The comment ID
 * @param {Object} comment - The comment data
 */
function updateCommentVoteCounts(commentId, comment) {
    const upvotesElements = document.querySelectorAll(`[data-comment-id="${commentId}"] .upvotes-count`);
    upvotesElements.forEach(el => {
        el.textContent = comment.upvotes_count;
    });

    const downvotesElements = document.querySelectorAll(`[data-comment-id="${commentId}"] .downvotes-count`);
    downvotesElements.forEach(el => {
        el.textContent = comment.downvotes_count;
    });
}

/**
 * Update vote buttons for a comment
 * @param {number} commentId - The comment ID
 * @param {Object} userVote - The user's vote data
 */
function updateCommentVoteButtons(commentId, userVote) {
    const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`).closest('.comment');
    if (!commentElement) return;

    const upvoteContainer = commentElement.querySelector('.upvote-container');
    const downvoteContainer = commentElement.querySelector('.downvote-container');

    if (upvoteContainer && downvoteContainer) {
        const suggestionId = document.querySelector('[data-suggestion-id]')?.dataset.suggestionId;

        upvoteContainer.innerHTML = createCommentVoteButton(commentId, suggestionId, 'up', userVote);
        downvoteContainer.innerHTML = createCommentVoteButton(commentId, suggestionId, 'down', userVote);

        initVotingButtons();
    }
}

/**
 * Update vote counts for a suggestion
 * @param {number} suggestionId - The suggestion ID
 * @param {Object} suggestion - The suggestion data
 */
function updateVoteCounts(suggestionId, suggestion) {
    const upvotesElements = document.querySelectorAll(`[data-suggestion-id="${suggestionId}"] .upvotes-count`);
    upvotesElements.forEach(el => {
        el.textContent = suggestion.upvotes_count;
    });

    const downvotesElements = document.querySelectorAll(`[data-suggestion-id="${suggestionId}"] .downvotes-count`);
    downvotesElements.forEach(el => {
        el.textContent = suggestion.downvotes_count;
    });
}

/**
 * Update vote buttons for a suggestion
 * @param {number} suggestionId - The suggestion ID
 * @param {Object} userVote - The user's vote data
 */
function updateVoteButtons(suggestionId, userVote) {
    const suggestionElement = document.querySelector(`.suggestion-${suggestionId}`);
    if (!suggestionElement) return;

    const upvoteContainer = suggestionElement.querySelector('.upvote-container');
    const downvoteContainer = suggestionElement.querySelector('.downvote-container');

    if (upvoteContainer && downvoteContainer) {
        upvoteContainer.innerHTML = createVoteButton(suggestionId, 'up', userVote);
        downvoteContainer.innerHTML = createVoteButton(suggestionId, 'down', userVote);

        initVotingButtons();
    }
}

/**
 * Create a comment vote button HTML
 * @param {number} commentId - The comment ID
 * @param {number} suggestionId - The suggestion ID
 * @param {string} type - The vote type ('up' or 'down')
 * @param {Object} userVote - The user's vote data
 * @returns {string} The HTML for the comment vote button
 */
function createCommentVoteButton(commentId, suggestionId, type, userVote) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const buttonClass = type === 'up' ? 'bg-success' : 'bg-danger';
    const icon = type === 'up' ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-down-fill';
    const countClass = type === 'up' ? 'upvotes-count' : 'downvotes-count';

    const isActive = (type === 'up' && userVote.has_upvoted) || (type === 'down' && userVote.has_downvoted);
    const activeClass = isActive ? ' active' : '';

    const count = document.querySelector(`[data-comment-id="${commentId}"] .${countClass}`).textContent;

    return `
        <form action="/suggest/${suggestionId}/comments/${commentId}/vote" method="POST" data-vote="${type}" data-comment-id="${commentId}">
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="type" value="${type}">
            <button type="submit" class="badge ${buttonClass} border-0${activeClass}">
                <i class="bi ${icon}"></i> <span class="${countClass}">${count}</span>
            </button>
        </form>
    `;
}

/**
 * Create a vote button HTML
 * @param {number} suggestionId - The suggestion ID
 * @param {string} type - The vote type ('up' or 'down')
 * @param {Object} userVote - The user's vote data
 * @returns {string} The HTML for the vote button
 */
function createVoteButton(suggestionId, type, userVote) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const buttonClass = type === 'up' ? 'bg-success' : 'bg-danger';
    const icon = type === 'up' ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-down-fill';
    const countClass = type === 'up' ? 'upvotes-count' : 'downvotes-count';

    const isActive = (type === 'up' && userVote.has_upvoted) || (type === 'down' && userVote.has_downvoted);
    const activeClass = isActive ? ' active' : '';

    const count = document.querySelector(`[data-suggestion-id="${suggestionId}"] .${countClass}`).textContent;

    return `
        <form action="/suggest/${suggestionId}/vote" method="POST" data-vote="${type}" data-suggestion-id="${suggestionId}">
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="type" value="${type}">
            <button type="submit" class="badge ${buttonClass} border-0${activeClass}">
                <i class="bi ${icon}"></i> <span class="${countClass}">${count}</span>
            </button>
        </form>
    `;
}
