<?php

namespace Azuriom\Plugin\SpinWheel\Controllers\Api;

use Azuriom\Models\Server;
use Azuriom\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Azuriom\Support\Discord\Embed;
use Azuriom\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Azuriom\Support\Discord\DiscordWebhook;
use Azuriom\Plugin\ScratchGame\Models\ScratchCard;
use Azuriom\Plugin\SpinWheel\Models\Rewards;
use Azuriom\Plugin\SpinWheel\Models\Laps as SpinLaps;

class ApiController extends Controller
{
    /**
     * Show the plugin API default page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rewards = [];
        $enabledRewards = Rewards::all()->where('is_enabled', true);
        $totalRewards = $enabledRewards->count();
        $equalSize = $totalRewards > 0 ? 360 / $totalRewards : 360;

        foreach ($enabledRewards as $reward) {
            array_push($rewards, [
                "fillStyle" => $reward->getColor()->background,
                "text" => $reward->name,
                "textFillStyle" => $reward->getColor()->color,
                'textFontSize' => $reward->textFontSize,
                'textOrientation' => $reward->textOrientation,
                "textDirection" => $reward->textDirection,
                "size" => setting('spin.proportionalWheel', 0) ? $reward->getSize() : $equalSize
            ]);
        }

        return response()->json($rewards, 200);
    }



    private function getDelayErrorMessage(User $user, bool $lock = false): ?string
    {
        $query = SpinLaps::where('user_id', $user->id)->latest('id');

        if ($lock) {
            $query->lockForUpdate();
        }

        $lastLaps = $query->first();

        if ($lastLaps === null) {
            return null;
        }

        $delay = $lastLaps->created_at->copy()->addMinutes((int) setting('spin.delay'));

        if ($delay->isFuture()) {
            return trans('spin-wheel::admin.errors.api.delay') . $delay->diffForHumans(null, false, false, 2);
        }

        return null;
    }

    private function getSpinPrice(User $user, bool $lock = false): float
    {
        $spinPrice = (float) setting('spin.price', 0);

        if (! setting('spin.freeSpin', 1)) {
            return $spinPrice;
        }

        $query = SpinLaps::where('user_id', $user->id)
            ->where('spin_price', 0.00)
            ->latest('id');

        if ($lock) {
            $query->lockForUpdate();
        }

        $lastFreeSpins = $query->first();

        if ($lastFreeSpins === null) {
            return 0.0;
        }

        $freeSpin = $lastFreeSpins->created_at->copy()->addMinutes((int) setting('spin.freeSpin.delay'));

        return $freeSpin->isPast() ? 0.0 : $spinPrice;
    }

    private function getNotEnoughMoneyMessage(User $user): string
    {
        return trans('spin-wheel::admin.errors.api.money') . ' '
            . trans('spin-wheel::admin.infos.sold')
            . $user->money
            . ' '
            . money_name();
    }

    public function check(Request $request)
    {
        $user = $request->user();
        $delayError = $this->getDelayErrorMessage($user);

        if ($delayError !== null) {
            return response()->json($delayError, 401);
        }

        $spinPrice = $this->getSpinPrice($user);

        if (! ($user->money >= $spinPrice)) {
            return response()->json($this->getNotEnoughMoneyMessage($user), 401);
        }

        return response()->json(200);
    }

    private function getReward()
    {
        $rewards = Rewards::where('is_enabled', true)->get();

        $total = $rewards->sum('chances');
        $random = random_int(0, $total);

        $sum = 0;
        $i = 0;

        foreach ($rewards as $reward) {
            $i++;

            $sum += $reward->chances;

            if ($sum >= $random) {
                $r = (object) [
                    "data" => $reward,
                    "place" => $i
                ];
                return $r;
            }
        };

        return $rewards->first();
    }

    public function play(Request $request)
    {
        $playData = DB::transaction(function () use ($request) {
            $lockedUser = User::query()->lockForUpdate()->findOrFail($request->user()->id);

            $delayError = $this->getDelayErrorMessage($lockedUser, true);
            if ($delayError !== null) {
                return ['error' => $delayError];
            }

            $spinPrice = $this->getSpinPrice($lockedUser, true);

            if ($lockedUser->money < $spinPrice) {
                return ['error' => $this->getNotEnoughMoneyMessage($lockedUser)];
            }

            $spinReward = $this->getReward();

            if ($spinPrice > 0) {
                $lockedUser->removeMoney($spinPrice);
            }

            SpinLaps::create([
                'user_id' => $lockedUser->id,
                'reward_id' => $spinReward->data->id,
                'reward_name' => $spinReward->data->name,
                'spin_price' => $spinPrice,
                'money_added' => $spinReward->data->money ?? 0,
                'created_at' => Carbon::now(),
            ]);

            if ($spinReward->data->money) {
                $lockedUser->addMoney($spinReward->data->money);
            }

            return ['reward' => $spinReward];
        }, 3);

        if (isset($playData['error'])) {
            return response()->json($playData['error'], 401);
        }

        $spinReward = $playData['reward'];

        /* It's checking if the reward has a scratch card and if it does, it will give a ticket. */
        if (! empty($spinReward->data->scratch_card_id)
            && function_exists('scratch_game_give_ticket')
            && class_exists(ScratchCard::class)
        ) {
            $card = ScratchCard::query()->whereKey($spinReward->data->scratch_card_id)->first();

            if ($card !== null && $card->is_enabled) {
                rescue(function () use ($card, $request) {
                    scratch_game_give_ticket(
                        $card,
                        $request->user(),
                        0.0,
                        null,
                        true,
                        $request->ip(),
                        $request->userAgent()
                    );
                });
            }
        }

        /* It's checking if the reward has commands and if it does, it will replace {player} with the
        player's name and send the commands to the server. */
        if ($spinReward !== null && $spinReward->data->commands !== null) {
            $commands = str_replace('{player}', $request->user()->name, $spinReward->data->commands);

            $servers = Server::all();

            // Vérifier si le reward a des serveurs associés
            if (isset($spinReward->data->servers_id) && is_array($spinReward->data->servers_id) && count($spinReward->data->servers_id) > 0) {
                // Envoyer les commandes uniquement aux serveurs dont l'id figure dans le tableau
                foreach ($servers as $server) {
                    if (in_array($server->id, $spinReward->data->servers_id)) {
                        $server->bridge()->sendCommands(array_reverse($commands), $request->user(), $spinReward->data->need_online);
                    }
                }
            }
        }

        /* It's checking if the reward has the option to send a webhook and if the webhook url is set.
        If both are true, it will send the webhook. */
        if ($spinReward->data->send_webhook && setting('spin.webhookUrl') !== null) {
            $this->sendWebhook($request, $spinReward);
        }

        return response()->json($spinReward, 200);
    }

    public function sendWebhook(Request $request, $reward = null)
    {
        if($request->has('test') || $reward == null) {
            $reward = $this->getReward();
        };

        $variables = [$request->user()->name, $reward->data->name, site_name()];
        $placeholders = ["{player}", "{reward}", "{site_name}"];

        $webhookUrl = setting('spin.webhookUrl');
        $embed = Embed::create()
            ->color($reward->data->getColor()->background)
            ->url(route('spin-wheel.index'));

        if (setting('spin.webhookTitle') !== null) {
            $embed->title(str_replace($placeholders, $variables, setting('spin.webhookTitle')));
        }

        if (setting('spin.webhookSkin', 1)) {
            $embed->thumbnail($request->user()->getAvatar());
        }

        if (setting('spin.webhookDesc') !== null) {
            $embed->description(str_replace($placeholders, $variables, setting('spin.webhookDesc')));
        }

        if (setting('spin.webhookFooter') !== null) {
            $embed->footer(str_replace($placeholders, $variables, setting('spin.webhookFooter')));
        }

        if (setting('spin.webhookFooterDate', 1)) {
            $embed->timestamp(now());
        }

        rescue(function () use ($embed, $webhookUrl) {
            DiscordWebhook::create()->addEmbed($embed)->send($webhookUrl);
        });

        if($request->has('test')) {
            redirect()->route('spin-wheel.admin.settings.index')
            ->with('success', trans('spin-wheel::admin.webhook.sent'));
        };
    }
}
