<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Registra las semillas de la base de datos.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([

            UserSeeder::class,
            usersseeder::class,
            Cliente::class,
            RolesAndPermissionsSeeder::class,
        ]);
    }
}
