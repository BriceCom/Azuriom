<ul class="list-unstyled d-flex align-items-center justify-content-center mb-0">
    @if($suggestion->status === 'pending')
        @auth
            <li class="me-2 upvote-container">
                <form action="{{ route('suggest.vote', $suggestion) }}" method="POST" class="vote-form" data-vote="up" data-suggestion-id="{{ $suggestion->id }}">
                    @csrf
                    <input type="hidden" name="type" value="up">
                    <button type="submit" class="badge bg-success border-0 @if(Auth::check() && $suggestion->hasUpvoted(Auth::user())) active @endif">
                        <i class="bi bi-hand-thumbs-up-fill"></i> <span class="upvotes-count">{{ $suggestion->upvotes_count }}</span>
                    </button>
                </form>
            </li>
            <li class="downvote-container">
                <form action="{{ route('suggest.vote', $suggestion) }}" method="POST" class="vote-form" data-vote="down" data-suggestion-id="{{ $suggestion->id }}">
                    @csrf
                    <input type="hidden" name="type" value="down">
                    <button type="submit" class="badge bg-danger border-0 @if(Auth::check() && $suggestion->hasDownvoted(Auth::user())) active @endif">
                        <i class="bi bi-hand-thumbs-down-fill"></i> <span class="downvotes-count">{{ $suggestion->downvotes_count }}</span>
                    </button>
                </form>
            </li>
        @else
            <li class="me-2">
                <span class="badge bg-success">
                    <i class="bi bi-hand-thumbs-up-fill"></i> <span class="upvotes-count">{{ $suggestion->upvotes_count }}</span>
                </span>
            </li>
            <li>
                <span class="badge bg-danger">
                    <i class="bi bi-hand-thumbs-down-fill"></i> <span class="downvotes-count">{{ $suggestion->downvotes_count }}</span>
                </span>
            </li>
        @endauth
    @else
        <li class="me-2">
            <span class="badge bg-success">
                <i class="bi bi-hand-thumbs-up-fill"></i> <span class="upvotes-count">{{ $suggestion->upvotes_count }}</span>
            </span>
        </li>
        <li>
            <span class="badge bg-danger">
                <i class="bi bi-hand-thumbs-down-fill"></i> <span class="downvotes-count">{{ $suggestion->downvotes_count }}</span>
            </span>
        </li>
    @endif
</ul>
