<?php

namespace Tests\Feature;

use App\Enums\AddressStatus;
use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_submit_address(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('address.create'), [
                'address' => 'C12uHQvzctT6v4pXUpP3y8xZG8kdFgBP5MnmJ5C6gH9y',
                'token' => 'SOL',
                'comment' => 'Test submission',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas(Address::class, [
            'user_id' => $user->id,
            'address' => 'C12uHQvzctT6v4pXUpP3y8xZG8kdFgBP5MnmJ5C6gH9y',
            'token' => 'SOL',
            'comment' => 'Test submission',
            'status' => AddressStatus::Pending->value,
        ]);
    }

    public function test_submission_requires_authentication(): void
    {
        $response = $this->post(route('address.create'), [
            'address' => 'C12uHQvzctT6v4pXUpP3y8xZG8kdFgBP5MnmJ5C6gH9y',
            'token' => 'SOL',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount(Address::class, 0);
    }
}
