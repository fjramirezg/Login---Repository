<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class Cliente extends Seeder
{

    public function run(): void
    {
        $faker = Faker::create();

        $userIds = DB::table('users')->pluck('id')->toArray();

        // Verificar que existan usuarios para asignar
        if (empty($userIds)) {
            $this->command->info('No hay usuarios disponibles. Por favor, ejecuta el seeder de usuarios primero.');
            return;
        }

        // Definir la cantidad de clientes a crear
        $cantidad = 10;

        for ($i = 0; $i < $cantidad; $i++) {
            DB::table('clientes')->insert([
                'user_id'    => $faker->randomElement($userIds),
                'name'       => $faker->name,
                'email'      => $faker->unique()->safeEmail,
                'phone'      => $faker->phoneNumber,
                'address'    => $faker->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info("$cantidad clientes han sido creados exitosamente.");
    }
}
