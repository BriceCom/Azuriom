<?php

namespace Tests\Unit\Plugins\Hunt;

use Azuriom\Models\User;
use Azuriom\Plugin\Hunt\Models\Hunt;
use Azuriom\Plugin\Hunt\Models\HuntUserDaily;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../../../../plugins/hunt/src/Models/HuntUserDaily.php';
require_once __DIR__.'/../../../../plugins/hunt/src/Models/Hunt.php';

class HuntCanUserClaimLogicTest extends TestCase
{
    public function test_returns_hunt_not_active_when_hunt_is_not_currently_active(): void
    {
        $hunt = new FakeHunt();
        $hunt->mockCurrent = false;

        $result = $hunt->canUserClaim($this->createMock(User::class));

        $this->assertFalse($result['can_claim']);
        $this->assertSame('hunt_not_active', $result['reason']);
    }

    public function test_returns_global_cap_reached_when_cap_is_reached(): void
    {
        $hunt = new FakeHunt();
        $hunt->mockCurrent = true;
        $hunt->mockGlobalCapReached = true;

        $result = $hunt->canUserClaim($this->createMock(User::class));

        $this->assertFalse($result['can_claim']);
        $this->assertSame('global_cap_reached', $result['reason']);
    }

    public function test_returns_daily_limit_reached_when_claims_count_is_over_limit(): void
    {
        $hunt = new FakeHunt();
        $hunt->mockCurrent = true;
        $hunt->mockGlobalCapReached = false;
        $hunt->max_per_day = 2;

        $daily = new FakeUserDaily();
        $daily->claims_count = 2;
        $daily->cooldown_until = null;

        $hunt->mockUserDaily = $daily;

        $result = $hunt->canUserClaim($this->createMock(User::class));

        $this->assertFalse($result['can_claim']);
        $this->assertSame('daily_limit_reached', $result['reason']);
    }

    public function test_returns_cooldown_active_when_cooldown_not_expired(): void
    {
        $hunt = new FakeHunt();
        $hunt->mockCurrent = true;
        $hunt->mockGlobalCapReached = false;
        $hunt->max_per_day = 5;

        $daily = new FakeUserDaily();
        $daily->claims_count = 1;
        $daily->cooldown_until = Carbon::now()->addMinutes(10);

        $hunt->mockUserDaily = $daily;

        $result = $hunt->canUserClaim($this->createMock(User::class));

        $this->assertFalse($result['can_claim']);
        $this->assertSame('cooldown_active', $result['reason']);
    }

    public function test_returns_can_claim_true_when_all_conditions_are_met(): void
    {
        $hunt = new FakeHunt();
        $hunt->mockCurrent = true;
        $hunt->mockGlobalCapReached = false;
        $hunt->max_per_day = 5;
        $hunt->mockUserDaily = null;

        $result = $hunt->canUserClaim($this->createMock(User::class));

        $this->assertTrue($result['can_claim']);
        $this->assertArrayNotHasKey('reason', $result);
    }
}

class FakeHunt extends Hunt
{
    public bool $mockCurrent = true;
    public bool $mockGlobalCapReached = false;
    public ?HuntUserDaily $mockUserDaily = null;

    public function isCurrentlyActive(): bool
    {
        return $this->mockCurrent;
    }

    public function hasReachedGlobalCap(): bool
    {
        return $this->mockGlobalCapReached;
    }

    public function getUserDaily(User $user, ?Carbon $date = null): ?HuntUserDaily
    {
        return $this->mockUserDaily;
    }
}

class FakeUserDaily extends HuntUserDaily
{
    public int $claims_count = 0;
    public mixed $cooldown_until = null;
}
