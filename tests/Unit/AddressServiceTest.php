<?php

namespace Tests\Unit;

use App\Enums\AddressStatus;
use App\Models\Address;
use App\Models\User;
use App\Services\AddressService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressServiceTest extends TestCase
{
    use RefreshDatabase;

    private AddressService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = $this->app->make(AddressService::class);
    }

    public function test_dashboard_stats_aggregates_counts(): void
    {
        $user = User::factory()->create();
        Address::factory()->create([
            'user_id' => $user->id,
            'status' => AddressStatus::Pending,
        ]);
        Address::factory()->create([
            'user_id' => $user->id,
            'status' => AddressStatus::Verified,
        ]);
        Address::factory()->create([
            'user_id' => $user->id,
            'status' => AddressStatus::Scam,
        ]);
        Address::factory()->create([
            'status' => AddressStatus::Scam,
        ]);

        $stats = $this->service->dashboardStats($user);

        $this->assertSame(3, $stats['my_submissions']);
        $this->assertSame(1, $stats['my_verified']);
        $this->assertSame(1, $stats['my_pending']);
        $this->assertSame(2, $stats['total_scam']);
    }

    public function test_recent_for_user_returns_latest_limited_addresses(): void
    {
        $user = User::factory()->create();
        Address::factory()->count(3)->create(['user_id' => $user->id]);

        $recent = $this->service->recentForUser($user, limit: 2);

        $this->assertCount(2, $recent);
        $this->assertGreaterThanOrEqual($recent[1]['id'], $recent[0]['id']);
    }
}
