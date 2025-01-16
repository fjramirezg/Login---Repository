<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Ejecuta la semilla para la tabla `users`.
     *
     * @return void
     */
    public function run()
    {
        // Crear usuarios con diferentes estados
        User::factory()->count(10)->active()->create(); // 10 usuarios activos
        User::factory()->count(5)->create(['status' => 'inactive']); // 5 usuarios inactivos
        User::factory()->count(5)->create(['status' => 'suspended']); // 5 usuarios suspendidos
    }
}
