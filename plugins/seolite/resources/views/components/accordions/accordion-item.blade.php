@props([
    'id',
    'title',
    'content',
    'showScore' => true
])

<div class="accordion-item">
    <div class="accordion-header">
        <button id="{{$id}}--trigger" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{$id}}-accordion" aria-expanded="false" aria-controls="{{$id}}-accordion" style="color: inherit">
            {{ $title }}

            @if($showScore)
                <span id="{{$id}}--score-badge" class="d-flex gap-1 badge text-bg-secondary ms-auto">
                    {{ trans('seolite::messages.score') }}:
                    <span><b id="{{$id}}--score">0</b>/<span id="{{$id}}--score-max">0</span></span>

                    <a role="button" type="button" class="ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="SEO Score Information"><i class="bi bi-question-circle"></i></a>
                </span>
            @endif
        </button>
    </div>
    <div id="{{$id}}-accordion" class="accordion-collapse collapse" data-bs-parent="#SEOLITE-accordions">
        <div class="accordion-body">
            {!! $content !!}
        </div>
    </div>
</div>
