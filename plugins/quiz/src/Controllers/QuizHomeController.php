<?php

namespace Azuriom\Plugin\Quiz\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Quiz\Models\Question;
use Azuriom\Plugin\Quiz\Models\Response;
use Azuriom\Plugin\Quiz\Models\UserScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class QuizHomeController extends Controller
{
    /**
     * Show the home plugin page.
     */
    public function index()
    {
        $question = Question::active()
            ->where('activation_date', now()->toDateString())
            ->with('answers')
            ->first();

        $response = null;
        $delayRemaining = null;
        $timerRemaining = null;
        $timerStartedAt = null;
        $adminBlocked = Auth::check() && Auth::user()->isAdmin() && !setting('quiz.admin_responses', false);
        $delayHours = (int) setting('quiz.delay_hours', 0);

        if ($question && Auth::check()) {
            $response = Response::where('user_id', Auth::id())
                ->where('question_id', $question->id)
                ->with('answer')
                ->first();

            $delayRemaining = $this->getDelayRemainingSeconds($delayHours);

            if ($response === null && $delayRemaining === null && !$adminBlocked && $question->time_limit) {
                $timerKey = $this->timerKey($question->id);
                if (!session()->has($timerKey)) {
                    session()->put($timerKey, now()->timestamp);
                }

                $timerStartedAt = (int) session()->get($timerKey);
                $elapsed = now()->timestamp - $timerStartedAt;
                $timerRemaining = max(0, $question->time_limit - $elapsed);

                if ($timerRemaining === 0 && $question->answers->isNotEmpty()) {
                    $response = Response::create([
                        'user_id' => Auth::id(),
                        'question_id' => $question->id,
                        'answer_id' => $question->answers->first()->id,
                        'status' => 'expired',
                    ]);

                    session()->forget($timerKey);
                }
            }
        }

        $userScore = Auth::check() ? UserScore::where('user_id', Auth::id())->first() : null;

        return view('quiz::index', [
            'question' => $question,
            'response' => $response,
            'userScore' => $userScore,
            'delayRemaining' => $delayRemaining,
            'delayRemainingText' => $delayRemaining !== null ? $this->formatRemaining($delayRemaining) : null,
            'timerRemaining' => $timerRemaining,
            'timerStartedAt' => $timerStartedAt,
            'adminBlocked' => $adminBlocked,
        ]);
    }

    public function answer(Request $request, Question $question)
    {
        $this->middleware('auth');

        if ($question->activation_date->toDateString() !== now()->toDateString() || !$question->is_active) {
            abort(403);
        }

        if (Response::where('user_id', Auth::id())->where('question_id', $question->id)->exists()) {
            return redirect()->route('quiz.home')->with('error', trans('quiz::messages.already_answered'));
        }

        if (Auth::user()->isAdmin() && !setting('quiz.admin_responses', false)) {
            return redirect()->route('quiz.home')->with('error', trans('quiz::messages.admin_not_allowed'));
        }

        $delayHours = (int) setting('quiz.delay_hours', 0);
        $delayRemaining = $this->getDelayRemainingSeconds($delayHours);
        if ($delayRemaining !== null) {
            return redirect()->route('quiz.home')->with('error', trans('quiz::messages.delay_not_elapsed', [
                'remaining' => $this->formatRemaining($delayRemaining),
            ]));
        }

        $timerKey = $this->timerKey($question->id);
        $timerStartedAt = (int) session()->get($timerKey, now()->timestamp);
        $elapsed = now()->timestamp - $timerStartedAt;
        $isExpired = $question->time_limit !== null && $elapsed > ($question->time_limit + 1);
        $isExpired = $isExpired || $request->boolean('expired');

        if ($request->filled('answer')) {
            $request->validate([
                'answer' => ['integer', Rule::exists('quiz_answers', 'id')->where('question_id', $question->id)],
            ]);
        } elseif (!$isExpired) {
            $request->validate([
                'answer' => ['required', 'integer', Rule::exists('quiz_answers', 'id')->where('question_id', $question->id)],
            ]);
        }

        $answerId = $request->input('answer');
        if ($answerId === null && $question->answers()->exists()) {
            $answerId = $question->answers()->orderBy('id')->value('id');
        }
        if ($answerId === null) {
            abort(422);
        }

        $answer = $question->answers()->findOrFail($answerId);

        $response = Response::create([
            'user_id' => Auth::id(),
            'question_id' => $question->id,
            'answer_id' => $answer->id,
            'status' => $isExpired ? 'expired' : null,
        ]);

        session()->forget($timerKey);

        if ($isExpired) {
            return redirect()->route('quiz.home')->with('error', trans('quiz::messages.time_expired'));
        }

        if ($answer->is_correct) {
            $rewards = $this->resolveRewards($question);
            $user = Auth::user();

            foreach ($rewards as $reward) {
                $this->applyReward($user, $reward);
            }

            if (!empty($rewards)) {
                $response->reward_payload = $rewards;
                $response->save();
            }

            $response->status = 'correct';
            $response->save();

            return redirect()->route('quiz.home')->with('success', trans('quiz::messages.correct_answer', [
                'reward' => $this->formatRewardSummary($rewards),
            ]));
        }

        $response->status = 'wrong';
        $response->save();

        return redirect()->route('quiz.home')->with('error', trans('quiz::messages.wrong_answer'));
    }

    public function leaderboard()
    {
        if (!setting('quiz.leaderboard', true)) {
            abort(404);
        }

        $scores = UserScore::with('user')->orderByDesc('score')->paginate(20);

        return view('quiz::leaderboard', [
            'scores' => $scores,
        ]);
    }

    private function resolveRewards(Question $question): array
    {
        $rewards = [];

        $difficultyReward = $this->getDifficultyReward($question);
        if ($difficultyReward !== null) {
            $rewards[] = $difficultyReward;
        }

        $randomReward = $this->getRandomReward();
        if ($randomReward !== null) {
            $rewards[] = $randomReward;
        }

        return $rewards;
    }

    private function getDifficultyReward(Question $question): ?array
    {
        $settings = json_decode(setting('quiz.difficulty_rewards', ''), true);
        $settings = is_array($settings) ? $settings : [];
        $config = $settings[$question->difficulty] ?? null;

        if (!is_array($config)) {
            $config = ['type' => 'points', 'value' => $question->reward];
        }

        $type = $config['type'] ?? 'points';
        $value = $config['value'] ?? $question->reward;

        if ($value === null || $value === '' || (is_numeric($value) && (float) $value <= 0)) {
            return null;
        }

        if (in_array($type, ['points', 'money'], true) && !is_numeric($value)) {
            return null;
        }

        return [
            'type' => $type,
            'value' => $value,
        ];
    }

    private function getRandomReward(): ?array
    {
        $rewards = json_decode(setting('quiz.random_rewards', '[]'), true);
        if (!is_array($rewards) || empty($rewards)) {
            return null;
        }

        $filtered = [];
        $totalProbability = 0.0;

        foreach ($rewards as $reward) {
            if (!is_array($reward)) {
                continue;
            }
            $type = $reward['type'] ?? null;
            $value = $reward['value'] ?? null;
            $probability = $reward['probability'] ?? null;

            if (!in_array($type, ['points', 'money', 'item'], true)) {
                continue;
            }
            if ($value === null || $value === '') {
                continue;
            }
            if ($probability === null || !is_numeric($probability) || (float) $probability <= 0) {
                continue;
            }
            if (in_array($type, ['points', 'money'], true) && !is_numeric($value)) {
                continue;
            }

            $probability = (float) $probability;
            $totalProbability += $probability;
            $filtered[] = [
                'type' => $type,
                'value' => $value,
                'probability' => $probability,
            ];
        }

        if ($totalProbability <= 0) {
            return null;
        }

        $target = (mt_rand() / mt_getrandmax()) * $totalProbability;
        $current = 0.0;

        foreach ($filtered as $reward) {
            $current += $reward['probability'];
            if ($target <= $current) {
                return [
                    'type' => $reward['type'],
                    'value' => $reward['value'],
                ];
            }
        }

        return null;
    }

    private function applyReward($user, array $reward): void
    {
        if ($reward['type'] === 'money') {
            $user->addMoney((float) $reward['value']);
            $user->save();
            return;
        }

        if ($reward['type'] === 'points') {
            $userScore = UserScore::firstOrCreate(['user_id' => $user->id]);
            $userScore->increment('score', (int) $reward['value']);
        }
    }

    private function getDelayRemainingSeconds(int $delayHours): ?int
    {
        if (!Auth::check() || $delayHours <= 0) {
            return null;
        }

        $lastResponse = Response::where('user_id', Auth::id())->latest()->first();
        if ($lastResponse === null) {
            return null;
        }

        $nextAllowedAt = $lastResponse->created_at->addHours($delayHours);
        if ($nextAllowedAt->isPast()) {
            return null;
        }

        return now()->diffInSeconds($nextAllowedAt);
    }

    private function formatRemaining(int $remainingSeconds): string
    {
        $hours = intdiv($remainingSeconds, 3600);
        $minutes = intdiv($remainingSeconds % 3600, 60);
        $seconds = $remainingSeconds % 60;

        if ($hours > 0) {
            return sprintf('%dh %02dm', $hours, $minutes);
        }

        if ($minutes > 0) {
            return sprintf('%dm %02ds', $minutes, $seconds);
        }

        return sprintf('%ds', $seconds);
    }

    private function formatRewardSummary(array $rewards): string
    {
        if (empty($rewards)) {
            return trans('quiz::messages.no_reward');
        }

        $parts = [];
        foreach ($rewards as $reward) {
            $type = $reward['type'] ?? 'points';
            $value = $reward['value'] ?? '';
            $parts[] = trans('quiz::messages.reward_' . $type, ['value' => $value]);
        }

        return implode(', ', $parts);
    }

    private function timerKey(int $questionId): string
    {
        return 'quiz_timer_' . $questionId;
    }
}
