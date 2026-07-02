<section class="py-5 pomodoro-testimonial">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-10 col-xl-7">
                <div class="text-center">
                    <div class="fs-4 mb-4 fst-italic">"{{ $testimonial['quote'] }}"</div>
                    <div class="d-flex align-items-center justify-content-center">
                        <img class="rounded-circle me-3 pomodoro-testimonial-avatar" src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['author'] }}">
                        <div class="fw-bold">
                            {{ $testimonial['author'] }}
                            <span class="fw-bold text-body-secondary mx-1">/</span>
                            {{ $testimonial['role'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
