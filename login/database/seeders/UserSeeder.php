<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class UserSeeder extends Seeder
{

    public function run(): void
    {
        $cantidad = 2;

        for ($i = 0; $i < $cantidad; $i++) {
         DB::table('users')->insert([
            'username' => Str::random(10),
            'email' => Str::random(10).'@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        }
        $this->command->info("$cantidad Usuarios han sido creados exitosamente.");
    }
}
