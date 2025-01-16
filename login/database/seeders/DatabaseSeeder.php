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
    public function run()
    {
        $this->call(UserSeeder::class);
    }
}
