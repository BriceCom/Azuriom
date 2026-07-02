<?php

namespace Azuriom\Plugin\Vote\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Server;
use Azuriom\Models\User;
use Azuriom\Plugin\Vote\Models\Reward;
use Azuriom\Plugin\Vote\Models\Site;
use Azuriom\Plugin\Vote\Models\Vote;
use Azuriom\Plugin\Vote\Verification\VoteChecker;
use Azuriom\Rules\GameAuth;
use Azuriom\Rules\Username;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class VoteController extends Controller
{
    private const SESSION_PSEUDO_KEY = 'vote.pseudo';

    public function __construct()
    {
        $this->tempUser = null;
    }


    /**
     * Display the vote home page.
     */
    public function index(Request $request)
    {
        if ($request->boolean('clear_vote_pseudo')) {
            $request->session()->forget(self::SESSION_PSEUDO_KEY);
            $request->session()->forget('temp_user');
        }

        $user = $request->user();
        $sessionVoteName = null;
        $sessionVoteUser = null;
        $sessionVoteCount = null;

        if ($user !== null) {
            // Connected player has priority over any stored guest pseudo.
            $request->session()->forget([self::SESSION_PSEUDO_KEY, 'temp_user']);

            $sessionVoteUser = $user;
            $sessionVoteName = $user->name;
            $sessionVoteCount = $this->getVotesCount($user);
            $defaultName = $user->name;
        } else {
            $sessionVoteName = $request->session()->get(self::SESSION_PSEUDO_KEY);
            $sessionVoteNameFromTempUser = false;

            if (is_string($sessionVoteName)) {
                $sessionVoteName = trim($sessionVoteName);

                if ($sessionVoteName === '') {
                    $sessionVoteName = null;
                } else {
                    $sessionVoteUser = User::firstWhere('name', $sessionVoteName);
                }
            }

            if ($sessionVoteUser === null) {
                $tempUser = $request->session()->get('temp_user');

                if (is_object($tempUser) && isset($tempUser->name) && is_string($tempUser->name) && trim($tempUser->name) !== '') {
                    $sessionVoteName = trim($tempUser->name);
                    $sessionVoteNameFromTempUser = true;
                }
            }

            if ($sessionVoteUser === null) {
                if (! $sessionVoteNameFromTempUser) {
                    $request->session()->forget(self::SESSION_PSEUDO_KEY);
                    $sessionVoteName = null;
                }
            } else {
                $sessionVoteName = $sessionVoteUser->name;
                $sessionVoteCount = $this->getVotesCount($sessionVoteUser);
            }

            $queryName = ($gameId = $request->input('uid')) !== null
                ? User::where('game_id', $gameId)->value('name')
                : $request->input('user', '');
            $defaultName = $queryName !== '' ? $queryName : ($sessionVoteName ?? '');
        }

        $votesCount = $user !== null ? $this->getVotesCount($user) : -1;
        $goalTarget = (int) setting('vote.goal.target', -1);
        $goalProgress = $goalTarget > 0 ? Vote::getGoalProgress() : 0;

        return view('vote::index', [
            'name' => $defaultName,
            'user' => $request->user(),
            'request' => $request,
            'sites' => Site::enabled()->with('rewards')->get(),
            'rewards' => Reward::where('chances', '>', 0)->orderByDesc('chances')->get(),
            'votes' => Vote::getTopVoters(now()->startOfMonth()),
            'userVotes' => $votesCount,
            'sessionVoteName' => $sessionVoteName,
            'sessionVoteUser' => $sessionVoteUser,
            'sessionVoteCount' => $sessionVoteCount,
            'ipv6compatibility' => setting('vote.ipv4-v6-compatibility', true),
            'authRequired' => setting('vote.auth-required', false),
            'displayRewards' => (bool) setting('vote.display-rewards', true),
            'goalEnabled' => $goalTarget > 0,
            'goalTarget' => $goalTarget,
            'goalPercentage' => $goalTarget > 0 ? round(($goalProgress / $goalTarget) * 100) : 0,
            'goalProgress' => $goalProgress,
        ]);
    }


    public function tempUser(string $name)
    {
        $validator = Validator::make(
            ['name' => $name],
            ['name' => ['required', 'string', 'max:25', 'unique:users', new Username(), new GameAuth()]]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => "Une erreur est survenue.",
            ], 422);
        }

        // Validation passed: assign to tempUser
        $user = new User();
        $user->name = $name;
        $this->tempUser = $user;

        session(['temp_user' => $user]);
        session([self::SESSION_PSEUDO_KEY => $user->name]);

        return $user;
    }

    public function verifyUser(Request $request, string $name)
    {
        if (setting('vote.auth_required', false)) {
            return response()->json([
                'message' => trans('vote::messages.errors.auth'),
            ], 422);
        }

        $user = $request->user();

        if ($user !== null) {
            // Connected player always wins over guest pseudo in session.
            $request->session()->forget([self::SESSION_PSEUDO_KEY, 'temp_user']);
        } else {
            $user = User::firstWhere('name', $name);

            if ($user === null) {
                return $this->tempUser($name);
            }

            $request->session()->put(self::SESSION_PSEUDO_KEY, $user->name);
        }

        $sites = Site::enabled()
            ->with('rewards')
            ->get()
            ->mapWithKeys(function (Site $site) use ($user, $request) {
                return [
                    $site->id => $site->getNextVoteTime($user, $request->ip())?->valueOf(),
                ];
            });

        $goalTarget = (int) setting('vote.goal.target', -1);
        $goalProgress = $goalTarget > 0 ? Vote::getGoalProgress() : 0;

        return response()->json([
            'sites' => $sites,
            'votes' => $this->getVotesCount($user),
            'position' => $this->getVotesRankPosition($user),
            'goal' => [
                'target' => $goalTarget,
                'progress' => $goalProgress,
                'text' => trans('vote::messages.goal', ['current' => $goalProgress, 'target' => $goalTarget]),
            ],
        ]);
    }

    public function vote()
    {
        return response()->noContent(404);
    }

    public function done(Request $request, Site $site)
    {
        $user = $request->user();

        if ($user !== null) {
            // Logged-in user must not use a previously stored guest pseudo.
            $request->session()->forget([self::SESSION_PSEUDO_KEY, 'temp_user']);
        } elseif (session('temp_user')) {
            $user = session('temp_user');
        } else {
            $user = User::firstWhere('name', $request->input('user'));
        }

        abort_if($user === null, 401);

        $nextVoteTime = $site->getNextVoteTime($user, $request->ip());

        if ($nextVoteTime !== null) {
            return response()->json([
                'message' => $this->formatTimeMessage($nextVoteTime),
            ], 422);
        }

        $previousReward = $request->session()->has('vote.reward.'.$site->id)
            ? Reward::find($request->session()->get('vote.reward.'.$site->id))
            : null;

        if ($previousReward !== null) {
            return $this->selectServer($request, $user, $site, $previousReward);
        }

        $voteChecker = app(VoteChecker::class);

        if ($site->has_verification && ! $voteChecker->verifyVote($site, $user, $request->ip())) {
            return response()->json([
                'status' => 'pending',
            ]);
        }

        // Check again because sometimes API can be really slow...
        $nextVoteTime = $site->getNextVoteTime($user, $request->ip());

        if ($nextVoteTime !== null) {
            return response()->json([
                'message' => $this->formatTimeMessage($nextVoteTime),
            ], 422);
        }

        $reward = $site->getRandomReward();

        if ($reward !== null) {
            if ($reward->single_server) {
                $request->session()->put('vote.reward.'.$site->id, $reward->id);

                return response()->json([
                    'status' => 'select_server',
                    'servers' => $reward->servers->pluck('name', 'id'),
                ]);
            }

            if(session('temp_user')) {
                $userSession = session('temp_user');

                $user = User::create([
                    'name' => $userSession->name,
                    'password' => Hash::make(Str::random(32)),
                ]);

                session()->forget('temp_user');
            }

            $vote = $site->votes()->create([
                'user_id' => $user->id,
                'reward_id' => $reward->id,
            ]);

            $reward->dispatch($vote);

            $this->processVoteGoal($user);
        }

        $next = $site->vote_reset_at !== null
            ? now()->next($site->vote_reset_at)
            : now()->addMinutes($site->vote_delay);
        Cache::put('votes.site.'.$site->id.'.'.$request->ip(), $next, $next);

        return response()->json([
            'message' => trans('vote::messages.success', [
                'reward' => $reward?->name ?? trans('messages.unknown'),
            ]),
        ]);
    }

    private function selectServer(Request $request, User $user, Site $site, Reward $reward)
    {
        $server = Server::find($request->input('server'));

        if ($server === null || ! $reward->servers->contains($server)) {
            return response()->json([
                'status' => 'select_server',
                'servers' => $reward->servers->pluck('name', 'id'),
            ]);
        }

        $request->session()->forget('vote.reward.'.$site->id);

        if(session('temp_user')) {
            $userSession = session('temp_user');

            $user = User::create([
                'name' => $userSession->name,
                'password' => Hash::make(Str::random(32)),
            ]);

            session()->forget('temp_user');
        }

        $vote = $site->votes()->create([
            'user_id' => $user->id,
            'reward_id' => $reward->id,
        ]);

        $reward->dispatch($vote, [$server]);

        $this->processVoteGoal($user);

        return response()->json([
            'message' => trans('vote::messages.success', [
                'reward' => $reward?->name ?? trans('messages.unknown'),
            ]),
        ]);
    }

    private function processVoteGoal(User $user): void
    {
        $goalTarget = (int) setting('vote.goal.target', -1);
        $goalCommands = setting('vote.goal.commands');

        if ($goalTarget <= 0 || ! $goalCommands) {
            return;
        }

        $commands = collect(json_decode($goalCommands, true));

        if ($commands->isEmpty() || Vote::getGoalProgress() !== $goalTarget) {
            return;
        }

        $servers = Server::findMany($commands->pluck('server')->unique());

        foreach ($servers as $server) {
            $serverCommands = $commands->where('server', $server->id)
                ->pluck('commands')
                ->flatten()
                ->all();

            $server->bridge()->sendCommands($serverCommands, $user);
        }
    }

    private function formatTimeMessage(Carbon $nextVoteTime): string
    {
        $time = $nextVoteTime->diffForHumans([
            'parts' => 2,
            'join' => true,
            'syntax' => CarbonInterface::DIFF_ABSOLUTE,
        ]);

        return trans('vote::messages.errors.delay', ['time' => $time]);
    }

    private function getVotesCount(User $user): int
    {
        return Vote::where('user_id', $user->id)
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();
    }

    private function getVotesRankPosition(User $user): ?int
    {
        if (! isset($user->id)) {
            return null;
        }

        $from = now()->startOfMonth();
        $userVotes = $this->getVotesCount($user);

        if ($userVotes <= 0) {
            return null;
        }

        $higherVotersCount = Vote::query()
            ->select('user_id', DB::raw('COUNT(*) as votes_count'))
            ->where('created_at', '>=', $from)
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > ?', [$userVotes])
            ->count();

        return $higherVotersCount + 1;
    }

}
