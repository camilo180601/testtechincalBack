<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Docuu',
            'email' => 'admin@docuu.test',
            'password' => Hash::make('password'), // cambia según necesites
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Operator One',
            'email' => 'operator@docuu.test',
            'password' => Hash::make('password'),
            'role' => 'operator'
        ]);

        User::create([
            'name' => 'Viewer One',
            'email' => 'viewer@docuu.test',
            'password' => Hash::make('password'),
            'role' => 'viewer'
        ]);
    }
}
