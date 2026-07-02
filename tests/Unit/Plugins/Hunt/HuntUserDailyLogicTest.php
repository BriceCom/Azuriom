<?php

namespace Tests\Unit\Plugins\Hunt;

use Azuriom\Plugin\Hunt\Models\Hunt;
use Azuriom\Plugin\Hunt\Models\HuntUserDaily;
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as Capsule;
use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../../../../plugins/hunt/src/Models/Hunt.php';
require_once __DIR__.'/../../../../plugins/hunt/src/Models/HuntUserDaily.php';

class HuntUserDailyLogicTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        static $booted = false;
        if (! $booted) {
            $capsule = new Capsule();
            $capsule->addConnection([
                'driver' => 'sqlite',
                'database' => ':memory:',
            ]);
            $capsule->setAsGlobal();
            $capsule->bootEloquent();
            $booted = true;
        }
    }

    public function test_get_remaining_claims_uses_hunt_max_per_day(): void
    {
        $daily = new HuntUserDaily();
        $daily->claims_count = 2;
        $daily->setRelation('hunt', $this->makeHunt(5));

        $this->assertSame(3, $daily->getRemainingClaims());
    }

    public function test_get_cooldown_remaining_minutes_is_zero_when_no_cooldown(): void
    {
        $daily = new FakeCooldownDaily();
        $daily->cooldown_until = null;

        $this->assertSame(0, $daily->getCooldownRemainingMinutes());
    }

    public function test_get_cooldown_remaining_minutes_is_non_negative_when_active(): void
    {
        $daily = new FakeCooldownDaily();
        $daily->cooldown_until = Carbon::now()->addHour();

        $remaining = $daily->getCooldownRemainingMinutes();

        $this->assertGreaterThanOrEqual(0, $remaining);
        $this->assertLessThanOrEqual(60, $remaining);
    }

    public function test_get_today_progress_contains_expected_fields(): void
    {
        $daily = new HuntUserDaily();
        $daily->claims_count = 1;
        $daily->money_received_today = 12.5;
        $daily->last_claim_at = Carbon::now()->subMinute();
        $daily->cooldown_until = Carbon::now()->addMinutes(5);
        $daily->setRelation('hunt', $this->makeHunt(3));

        $progress = $daily->getTodayProgress();

        $this->assertArrayHasKey('claims_today', $progress);
        $this->assertArrayHasKey('max_claims', $progress);
        $this->assertArrayHasKey('remaining_claims', $progress);
        $this->assertArrayHasKey('money_today', $progress);
        $this->assertArrayHasKey('last_claim', $progress);
        $this->assertArrayHasKey('on_cooldown', $progress);
        $this->assertArrayHasKey('cooldown_remaining_minutes', $progress);
        $this->assertSame(1, $progress['claims_today']);
        $this->assertSame(3, $progress['max_claims']);
    }

    private function makeHunt(int $maxPerDay): Hunt
    {
        $hunt = new Hunt();
        $hunt->max_per_day = $maxPerDay;

        return $hunt;
    }
}

class FakeCooldownDaily extends HuntUserDaily
{
    public mixed $cooldown_until = null;

    public function isOnCooldown(): bool
    {
        return $this->cooldown_until instanceof Carbon && Carbon::now()->lt($this->cooldown_until);
    }
}
