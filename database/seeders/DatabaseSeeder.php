<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Sample users for roles
        User::create([
            'name' => 'Admin Pharmacie',
            'email' => 'admin@pharmacie.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Marie Dupont',
            'email' => 'pharmacien@pharmacie.com',
            'password' => bcrypt('password'),
            'role' => 'pharmacien',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Jean Martin',
            'email' => 'preparateur@pharmacie.com',
            'password' => bcrypt('password'),
            'role' => 'preparateur',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Sophie Lefèvre',
            'email' => 'caissier@pharmacie.com',
            'password' => bcrypt('password'),
            'role' => 'caissier',
            'is_active' => true,
        ]);
    }
}
