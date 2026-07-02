@php
    $voteTotal = plugins()->isEnabled('vote') ? vote_leaderboard()->sum('votes') : 24221;
    $replaceVoteTotal = fn ($value) => str_replace('{vote_total}', (string) $voteTotal, (string) $value);
    $firstValue = $replaceVoteTotal(theme_config('home.stats.first.value') ?? '{vote_total}+');
    $secondValue = $replaceVoteTotal(theme_config('home.stats.second.value') ?? '{server_online}');
    $thirdValue = $replaceVoteTotal(theme_config('home.stats.third.value') ?? (theme_config('home.stats.experience') ?? '10 ans'));
@endphp

<section class="stats-section">
    <div class="container">
        <div class="stats-card">
            <div class="stat-item">
                <h3 class="stat-number" data-editable="true">{{ $firstValue }}</h3>
                <p class="stat-label">{{ theme_config('home.stats.first.label') ?? 'Total de votes' }}</p>
            </div>
            <div class="stat-item">
                <h3 class="stat-number" data-editable="true">{{ $secondValue }}</h3>
                <p class="stat-label">{{ theme_config('home.stats.second.label') ?? 'Joueurs en ligne' }}</p>
            </div>
            <div class="stat-item">
                <h3 class="stat-number" data-editable="true">{{ $thirdValue }}</h3>
                <p class="stat-label">{{ theme_config('home.stats.third.label') ?? "d'expérience" }}</p>
            </div>
        </div>
    </div>
</section>
