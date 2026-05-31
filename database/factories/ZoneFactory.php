<?php

namespace Database\Factories;

use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Zone>
 */
class ZoneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => fake()->regexify('[A-Z]{3}[0-9]{2}'),
            'state' => fake()->state(),
            'description' => fake()->city(),
        ];
    }
}
