@plugin('faq')
@php
    $questions = \Azuriom\Plugin\FAQ\Models\Question::orderBy('position')->get();
@endphp

@if(!$questions->isEmpty())
<section class="faq-section">
    <div class="container">
        <div class="section-copy text-center mb-5">
            <span class="badge text-bg-tertiary text-tertiary text-uppercase fw-bold px-3 py-2 mb-3">{{ theme_config('home.faq.badge') ?? 'FAQ' }}</span>
            <h2 class="mb-3">{{ theme_config('home.faq.title') ?? 'Foire aux questions' }}</h2>
            <p>
                {{ theme_config('home.faq.text') ?? 'Lrem Ipsum is simply dummy text of the printing and typesetting industry. m Ipsum is simpm Ipsum is sm Ipsum is simpLrem Ipsum is simply dummy text of' }}
            </p>
        </div>
        <div class="accordion faq-accordion" id="faqAccordion">
            @foreach($questions as $index => $question)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button @if($index !== 0) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $question->id }}">
                            {{ $question->name }}
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="white" class="chevron-icon">
                                <path d="M2.469 6.969C2.53867 6.89916 2.62143 6.84374 2.71255 6.80593C2.80367 6.76812 2.90135 6.74866 3 6.74866C3.09865 6.74866 3.19633 6.76812 3.28745 6.80593C3.37857 6.84374 3.46133 6.89916 3.531 6.969L12 15.4395L20.469 6.969C20.5387 6.89927 20.6215 6.84395 20.7126 6.80621C20.8037 6.76848 20.9014 6.74905 21 6.74905C21.0986 6.74905 21.1963 6.76848 21.2874 6.80621C21.3785 6.84395 21.4613 6.89927 21.531 6.969C21.6007 7.03873 21.656 7.12152 21.6938 7.21262C21.7315 7.30373 21.7509 7.40138 21.7509 7.5C21.7509 7.59862 21.7315 7.69627 21.6938 7.78738C21.656 7.87848 21.6007 7.96127 21.531 8.031L12.531 17.031C12.4613 17.1008 12.3786 17.1563 12.2874 17.1941C12.1963 17.2319 12.0987 17.2513 12 17.2513C11.9013 17.2513 11.8037 17.2319 11.7125 17.1941C11.6214 17.1563 11.5387 17.1008 11.469 17.031L2.469 8.031C2.39916 7.96133 2.34374 7.87857 2.30593 7.78745C2.26812 7.69633 2.24866 7.59865 2.24866 7.5C2.24866 7.40135 2.26812 7.30367 2.30593 7.21255C2.34374 7.12143 2.39916 7.03867 2.469 6.969Z"/>
                            </svg>
                        </button>
                    </h2>
                    <div id="faq{{ $question->id }}" class="accordion-collapse collapse @if($index === 0) show @endif" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            {!! $question->answer !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endplugin
