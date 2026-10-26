<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['email' => 'member@example.com', 'name' => 'Test Member'],
            ['email' => 'admin@example.com',  'name' => 'Admin'],
            ['email' => 'somchai@example.com', 'name' => 'Somchai'],
        ];

        foreach ($users as $u) {
            User::firstOrCreate(
                ['email' => $u['email']],
                ['name' => $u['name'], 'password' => 'password'],
            );
        }
    }
}