<?php

namespace Database\Factories;

use App\Models\SyncLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SyncLog>
 */
class SyncLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'zone_code' => fake()->regexify('[A-Z]{3}[0-9]{2}'),
            'year' => fake()->year(),
            'status' => fake()->randomElement(['success', 'failed']),
            'records_created' => fake()->numberBetween(0, 365),
            'error_message' => null,
        ];
    }

    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
            'records_created' => 0,
            'error_message' => fake()->sentence(),
        ]);
    }
}
