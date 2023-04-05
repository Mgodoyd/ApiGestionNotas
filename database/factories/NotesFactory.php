<?php

namespace Database\Factories;

use App\Models\States;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notes>
 */
class NotesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=> fake()->word(),
            'content'=> fake()->paragraph(3),
            'user_id'=> User::inRandomOrder()->first()->id,   // Obtener un ID de usuario aleatorio de la tabla de usuarios
            'state_id'=> States::inRandomOrder()->firstOrFail()->id,        // Obtener un ID de estado aleatorio de la tabla de estados
        ];
    }
}
