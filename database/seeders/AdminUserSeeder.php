<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      User::firstOrCreate(
            ['email' => 'admin@biblioteca.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'), // você pode trocar por outra senha
                'role' => 'admin',
            ]
        ); 
    }
}
