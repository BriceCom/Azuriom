@php
    $questions = Azuriom\Plugin\FAQ\Models\Question::orderBy('position')->get();
@endphp

@if(!$questions->isEmpty())
<div class="faq-section d-flex flex-column gap-4 gap-md-7">
        <hgroup class="text-center">
            <h2>{{ theme_config('vote.index.faqTitle') ?? "Foire aux questions" }}</h2>
            <p>{{ theme_config('vote.index.faqText') ?? "Retrouvez ici les réponses aux questions les plus fréquemment posées." }}</p>
        </hgroup>

        <div class="accordion" id="faq">
            @foreach($questions as $id => $question)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="{{ Str::slug($question->name) }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#answer{{ $question->id }}" aria-expanded="false" aria-controls="answer{{ $question->id }}">
                            {{ $question->name }}
                        </button>
                    </h2>
                    <div id="answer{{ $question->id }}" class="accordion-collapse collapse" aria-labelledby="{{ Str::slug($question->name) }}" data-bs-parent="#faq">
                        <div class="accordion-body">
                            {!! $question->answer !!}
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
 </div>
@endif
