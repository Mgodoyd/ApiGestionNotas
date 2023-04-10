<?php

namespace Database\Factories;

use App\Models\Rol;
use App\Models\States;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'is_verificado' => $verificado = fake()->randomElement([User::VERIFICADO, User::NO_VERIFICADO]),
            'verification_token' => $verificado == User::VERIFICADO ? null : User::generateVerificationToken(),
            'rol_id' => Rol::inRandomOrder()->first()->id,            // Establecer el ID de rol en la columna de llave foránea en la tabla de usuarios
        ];
    }
}
