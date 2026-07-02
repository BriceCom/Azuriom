@props(['suggestion', 'show' => false])

<div class="card suggestion-{{ $suggestion->id }}">
    <div class="card-header d-flex justify-content-between align-items-sm-start">
        <div>
            @if($suggestion->category && !$show)
                <span class="badge" style="background-color: {{ $suggestion->category->color }}">
                                                <i class="bi bi-tag-fill"></i> {{ $suggestion->category->name }}
                                        </span>
            @endif
            <span class="mb-0 ms-2">{{ $suggestion->title }}</span>
        </div>
        <span
            class="badge bg-{{ $suggestion->status === 'approved' ? 'success' : ($suggestion->status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ trans('suggest::messages.status.' . $suggestion->status) }}
                                    </span>
    </div>

    <div class="card-body">
        @if($show)
            {!! $suggestion->content !!}
        @else
            <p>{{ Str::limit($suggestion->stripped_content, 250) }}</p>
        @endif

        @if(!$show)
            <div class="d-flex justify-content-end">
                <a href="{{ route('suggest.show', $suggestion) }}">{{ trans('suggest::messages.read_more') }}</a>
            </div>
        @endif
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            @include('suggest::components.avatar', ['user' => $suggestion->user, 'date' => $suggestion->created_at])

           @include('suggest::components.vote')
        </div>
    </div>
</div>
