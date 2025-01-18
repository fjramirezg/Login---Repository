<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class usersseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password');
        Log::info($password);
        DB::table('users')->insert([
            'username' => Str::random(10),
            'email' => Str::random(10) . '@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
