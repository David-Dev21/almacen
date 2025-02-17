<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear un usuario específico
        DB::table('users')->insert([
            'name' => 'Ruben David',
            'ci' => '9911191',
            'password' => Hash::make('rubendavid'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
