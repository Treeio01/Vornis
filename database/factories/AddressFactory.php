<?php

namespace Database\Factories;

use App\Enums\AddressStatus;
use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Address>
 */
class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'address' => $this->faker->unique()->regexify('[A-HJ-NP-Za-km-z1-9]{44}'),
            'status' => AddressStatus::Pending,
            'remark' => $this->faker->optional()->sentence(),
            'reward' => 0,
            'token' => strtoupper($this->faker->lexify('???')),
            'user_id' => User::factory(),
            'comment' => $this->faker->optional()->sentence(),
        ];
    }
}
