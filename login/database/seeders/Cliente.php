<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Cliente extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clientes')->insert([
            'user_id' => rand(1, 1000),
            'name' => Str::random(10),
            'email' => Str::random(10) . '@example.com',
            'phone' => Str::random(10),
            'address' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }

}
