<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Iman',
            'email' => 'iman@appsakola.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Namiiman123'),
            'role' => 'admin',
        ]);
    }
}
