<?php

namespace Azuriom\Plugin\Achievement\Services;

class HookService
{
    /**
     * The registered hooks.
     *
     * @var array
     */
    protected $hooks = [];

    /**
     * The objective service.
     *
     * @var \Azuriom\Plugin\Achievement\Services\ObjectiveService
     */
    protected $objectiveService;

    /**
     * Create a new hook service instance.
     *
     * @param  \Azuriom\Plugin\Achievement\Services\ObjectiveService  $objectiveService
     * @return void
     */
    public function __construct(ObjectiveService $objectiveService)
    {
        $this->objectiveService = $objectiveService;
        $this->registerDefaultHooks();
    }

    /**
     * Register a new hook.
     *
     * @param  string  $hook
     * @param  array  $triggers
     * @return void
     */
    public function registerHook(string $hook, array $triggers)
    {
        $this->hooks[$hook] = $triggers;
    }

    /**
     * Get all registered hooks.
     *
     * @return array
     */
    public function getHooks()
    {
        return $this->hooks;
    }

    /**
     * Register the default hooks.
     *
     * @return void
     */
    protected function registerDefaultHooks()
    {
        // Azuriom hooks
//        $this->registerHook('azuriom', [
//            'login_streak' => 'Login Streak',
//        ]);

        // Vote hooks
        $this->registerHook('vote', [
            'voted' => trans('achievement::admin.triggers.voted'),
            'leaderboard' => trans('achievement::admin.triggers.leaderboard'),
        ]);

        // Shop hooks
        $this->registerHook('shop', [
            'spent' => trans('achievement::admin.triggers.spent'),
            'points_spent' => trans('achievement::admin.triggers.points_spent'),
            'item_purchase' => trans('achievement::admin.triggers.item_purchase'),
        ]);

        // Forum hooks
        $this->registerHook('forum', [
            'message' => trans('achievement::admin.triggers.message'),
            'topic' => trans('achievement::admin.triggers.topic'),
            'like_received' => trans('achievement::admin.triggers.like_received'),
        ]);

        // Review hooks
        $this->registerHook('review', [
            'post' => trans('achievement::admin.triggers.post'),
        ]);

        // Suggest hooks
        $this->registerHook('suggest', [
            'post' => trans('achievement::admin.triggers.post'),
            'like_received' => trans('achievement::admin.triggers.like_received'),
        ]);

        // Post hooks
        $this->registerHook('post', [
            'like' => trans('achievement::admin.triggers.like'),
        ]);

        // Achievement hooks
        $this->registerHook('achievement', [
            'achievement_trophy_amount' => trans('achievement::admin.triggers.achievement_trophy_amount'),
        ]);
    }
}
