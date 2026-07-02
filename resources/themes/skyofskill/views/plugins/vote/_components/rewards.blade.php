@if($displayRewards)
    <div class="position-relative card vote-card__wrapper" data-aos="fade-up" data-aos-delay="0">
        <i class="position-absolute start-0 translate-middle bi bi-trophy-fill vote-icon"></i>

        <div class="vote-card card-body d-flex flex-column gap-3">
            <hgroup>
                <h2 class="card-title mb-0">
                    {{ theme_config('vote.index.rewardTitle') ?? "Récompenses top voteurs" }}
                </h2>
                @if(theme_config('vote.index.rewardText'))
                    <p class="mb-0 opacity-75">{{ theme_config('vote.index.rewardText') }}</p>
                @endif
            </hgroup>

            @include('components.alert', [
                    'type' => 'info',
                    'message' => theme_config('vote.index.infosText') ?? "<p>Faites <strong>/vote</strong> en jeu pour consulter le classement et ses récompenses !</p>",
                    'icon' => 'bi bi-gift-fill'
                ])

            <p class="mb-0">{{ theme_config('vote.index.bottomText') ?? "Le classement est hebdomadaire"  }}</p>
        </div>
    </div>
@endif
