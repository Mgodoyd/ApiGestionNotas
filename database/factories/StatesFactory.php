<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\States>
 */
class StatesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name_status' => fake()->word(),
        ];
    
    }
}
