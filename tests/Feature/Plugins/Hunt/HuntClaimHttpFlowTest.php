<?php

namespace Tests\Feature\Plugins\Hunt;

use Azuriom\Models\User;
use Azuriom\Plugin\Hunt\Models\Hunt;
use Azuriom\Plugin\Hunt\Models\HuntLog;
use Azuriom\Plugin\Hunt\Models\HuntReward;
use Azuriom\Plugin\Hunt\Models\HuntUserDaily;
use Illuminate\Support\Facades\Artisan;
use Tests\Concerns\BootsHuntPluginForTests;
use Tests\TestCase;

class HuntClaimHttpFlowTest extends TestCase
{
    use BootsHuntPluginForTests;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', database_path('hunt_feature_test.sqlite'));
        if (! file_exists(database_path('hunt_feature_test.sqlite'))) {
            touch(database_path('hunt_feature_test.sqlite'));
        }

        Artisan::call('migrate:fresh');

        $this->withoutMiddleware();
        $this->bootHuntPluginForTests();
    }

    public function test_claim_returns_401_when_user_is_not_authenticated(): void
    {
        $response = $this->postJson('/hunt/claim');

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'error' => 'not_authenticated',
            ]);
    }

    public function test_claim_returns_404_when_no_active_hunt_exists(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->postJson('/hunt/claim');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'error' => 'no_active_hunt',
            ]);
    }

    public function test_claim_returns_global_cap_reached_when_hunt_cap_is_full(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $hunt = $this->createActiveHunt([
            'global_cap' => 1,
            'spawn_rate' => 100.00,
        ]);

        HuntLog::create([
            'hunt_id' => $hunt->id,
            'user_id' => $user->id,
            'reward_id' => null,
            'money_received' => 0,
            'commands_executed' => null,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'phpunit',
        ]);

        $response = $this->postJson('/hunt/claim');

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'error' => 'global_cap_reached',
            ]);
    }

    public function test_claim_returns_daily_limit_reached_when_user_hit_max_per_day(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $hunt = $this->createActiveHunt([
            'max_per_day' => 1,
            'spawn_rate' => 100.00,
        ]);

        HuntUserDaily::create([
            'hunt_id' => $hunt->id,
            'user_id' => $user->id,
            'date' => today()->toDateString(),
            'claims_count' => 1,
            'money_received_today' => 0,
            'last_claim_at' => now()->subMinute(),
            'cooldown_until' => now()->subMinute(),
        ]);

        $response = $this->postJson('/hunt/claim');

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'error' => 'daily_limit_reached',
            ]);
    }

    public function test_claim_returns_cooldown_active_when_user_is_on_cooldown(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $hunt = $this->createActiveHunt([
            'max_per_day' => 5,
            'spawn_rate' => 100.00,
        ]);

        HuntUserDaily::create([
            'hunt_id' => $hunt->id,
            'user_id' => $user->id,
            'date' => today()->toDateString(),
            'claims_count' => 0,
            'money_received_today' => 0,
            'last_claim_at' => null,
            'cooldown_until' => now()->addMinutes(10),
        ]);

        $response = $this->postJson('/hunt/claim');

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'error' => 'cooldown_active',
            ]);
    }

    public function test_claim_returns_spawn_failed_and_sets_cooldown_when_spawn_roll_fails(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $hunt = $this->createActiveHunt([
            'max_per_day' => 5,
            'spawn_rate' => 0.00,
            'cooldown_minutes' => 15,
        ]);

        $response = $this->postJson('/hunt/claim');

        $response->assertOk()
            ->assertJson([
                'success' => false,
                'error' => 'spawn_failed',
                'cooldown_minutes' => 15,
            ]);

        $daily = HuntUserDaily::where('hunt_id', $hunt->id)->where('user_id', $user->id)->first();
        $this->assertNotNull($daily);
        $this->assertNotNull($daily->cooldown_until);
    }

    public function test_claim_returns_success_and_writes_log_when_spawn_succeeds(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $hunt = $this->createActiveHunt([
            'max_per_day' => 5,
            'spawn_rate' => 100.00,
            'global_cap' => null,
        ]);

        $response = $this->postJson('/hunt/claim');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'hunt' => [
                    'id' => $hunt->id,
                ],
            ]);

        $this->assertDatabaseHas('hunt_logs', [
            'hunt_id' => $hunt->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_claim_awards_money_reward_attached_to_hunt(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $hunt = $this->createActiveHunt([
            'max_per_day' => 5,
            'spawn_rate' => 100.00,
            'global_cap' => null,
        ]);

        $reward = HuntReward::create([
            'name' => '100 Credits',
            'chances' => 100.00,
            'money' => 100.00,
            'commands' => null,
            'scratch_card_id' => null,
            'need_online' => false,
            'is_enabled' => true,
        ]);

        $hunt->rewards()->sync([$reward->id]);

        $response = $this->postJson('/hunt/claim');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'reward' => [
                    'name' => '100 Credits',
                    'money' => 100,
                ],
            ]);

        $this->assertDatabaseHas('hunt_logs', [
            'hunt_id' => $hunt->id,
            'user_id' => $user->id,
            'reward_id' => $reward->id,
        ]);
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    private function createActiveHunt(array $overrides = []): Hunt
    {
        return Hunt::create(array_merge([
            'name' => 'HTTP Hunt',
            'slug' => 'http-hunt',
            'description' => 'HTTP test hunt',
            'priority' => 100,
            'max_per_day' => 3,
            'global_cap' => null,
            'spawn_rate' => 100.00,
            'cooldown_minutes' => 10,
            'spawn_delay_seconds' => 0,
            'start_date' => now()->subHour(),
            'end_date' => now()->addHour(),
            'is_active' => true,
            'is_archived' => false,
        ], $overrides));
    }
}
