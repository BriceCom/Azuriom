@if(setting('suggest.enable_comments'))
    <div class="mt-5 pt-5">
        <div class="card">
            <div class="card-header">
                {{ trans('suggest::messages.comments.title') }}
                <span class="badge bg-secondary ms-2">{{ $suggestion->comments->count() }}</span>
            </div>

            <div class="card-body">
                @if($suggestion->comments->isEmpty())
                    <div class="text-muted py-3">
                        {{ trans('suggest::messages.comments.empty') }}
                    </div>
                @else
                    <div class="comments-list">
                        @foreach($suggestion->comments as $comment)
                            <div class="comment @if(!$loop->last) pb-3 mb-3 border-bottom @endif">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    @include('suggest::components.avatar', ['user' => $comment->author, 'date' => $comment->created_at])
                                    @can('delete', $comment)
                                        <form method="POST" action="{{ route('suggest.comments.destroy', [$suggestion, $comment]) }}" class="d-inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ trans('suggest::messages.comments.confirm_delete') }}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                                <div class="wysiwyg-content">
                                    {!! $comment->content !!}
                                </div>

                                <div class="comment-votes mt-3 d-flex align-items-center">
                                    <ul class="list-unstyled d-flex align-items-center mb-0">
                                        @auth
                                            <li class="me-2 upvote-container">
                                                <form action="{{ route('suggest.comments.vote', [$suggestion, $comment]) }}" method="POST" data-vote="up" data-comment-id="{{ $comment->id }}">
                                                    @csrf
                                                    <input type="hidden" name="type" value="up">
                                                    <button type="submit" class="badge bg-success border-0 @if(Auth::check() && $comment->hasUpvoted(Auth::user())) active @endif">
                                                        <i class="bi bi-hand-thumbs-up-fill"></i> <span class="upvotes-count">{{ $comment->upvotes_count }}</span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li class="downvote-container">
                                                <form action="{{ route('suggest.comments.vote', [$suggestion, $comment]) }}" method="POST" data-vote="down" data-comment-id="{{ $comment->id }}">
                                                    @csrf
                                                    <input type="hidden" name="type" value="down">
                                                    <button type="submit" class="badge bg-danger border-0 @if(Auth::check() && $comment->hasDownvoted(Auth::user())) active @endif">
                                                        <i class="bi bi-hand-thumbs-down-fill"></i> <span class="downvotes-count">{{ $comment->downvotes_count }}</span>
                                                    </button>
                                                </form>
                                            </li>
                                        @else
                                            <li class="me-2">
                                                <span class="badge bg-success">
                                                    <i class="bi bi-hand-thumbs-up-fill"></i> <span class="upvotes-count">{{ $comment->upvotes_count }}</span>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-hand-thumbs-down-fill"></i> <span class="downvotes-count">{{ $comment->downvotes_count }}</span>
                                                </span>
                                            </li>
                                        @endauth
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @include('suggest::components._comment-form', ['suggestion' => $suggestion])
            </div>
        </div>

    </div>
@endif
