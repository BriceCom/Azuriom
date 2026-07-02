<?php

namespace Tests\Unit\Plugins\Hunt;

use Azuriom\Models\Role;
use Azuriom\Models\User;
use Azuriom\Plugin\Hunt\Models\HuntReward;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../../../../plugins/hunt/src/Models/HuntReward.php';

class HuntRewardLogicTest extends TestCase
{
    public function test_is_user_eligible_when_reward_has_no_role_restriction(): void
    {
        $reward = new HuntReward();
        $reward->setRelation('roles', collect());

        $user = new User();
        $user->setRelation('roles', collect());

        $this->assertTrue($reward->isUserEligible($user));
    }

    public function test_is_user_eligible_is_false_when_user_has_no_matching_roles(): void
    {
        $reward = new HuntReward();
        $reward->setRelation('roles', collect([$this->role(1)]));

        $user = new User();
        $user->setRelation('roles', collect());

        $this->assertFalse($reward->isUserEligible($user));
    }

    public function test_is_user_eligible_is_true_when_roles_intersect(): void
    {
        $reward = new HuntReward();
        $reward->setRelation('roles', collect([$this->role(2), $this->role(3)]));

        $user = new User();
        $user->setRelation('roles', collect([$this->role(3)]));

        $this->assertTrue($reward->isUserEligible($user));
    }

    public function test_select_random_reward_returns_null_with_empty_collection(): void
    {
        $selected = HuntReward::selectRandomReward(collect());

        $this->assertNull($selected);
    }

    public function test_select_random_reward_returns_single_reward_when_always_eligible(): void
    {
        $reward = new DeterministicReward();
        $reward->chances = 100;

        $selected = HuntReward::selectRandomReward(new Collection([$reward]));

        $this->assertSame($reward, $selected);
    }

    private function role(int $id): Role
    {
        $role = new Role();
        $role->id = $id;

        return $role;
    }
}

class DeterministicReward extends HuntReward
{
    public function shouldBeAwarded(): bool
    {
        return true;
    }
}

