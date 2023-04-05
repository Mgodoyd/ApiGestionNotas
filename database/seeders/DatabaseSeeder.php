<?php

namespace Database\Seeders;


use App\Models\User;
use App\Models\Notes;
use App\Models\Rol;
use App\Models\States;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nette\Schema\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('EXEC sp_msforeachtable "ALTER TABLE ? NOCHECK CONSTRAINT all"'); // Desactiva la comprobación de claves foráneas en SQL Server
        User::truncate();
        Rol::truncate();
        States::truncate();
        Notes::truncate();

        $cantidadRoles = 4;
        Rol::factory($cantidadRoles)->create();

        User::factory(5)->create()->each(function ($user) {
            $user->rol()->associate(Rol::all()->random())->save();
        });

       

        States::factory(3)->create();

        Notes::factory(5)->create()->each(function ($nota) {
            $nota->user()->associate(User::all()->random())->save();
            $nota->state()->associate(States::all()->random())->save();
        });

    } 
}
