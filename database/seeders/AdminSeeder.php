<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate([
            'email' => 'admin@pharmacie.com',
        ], [
            'name' => 'Admin Pharmacie',
            'password' => Hash::make('password123'),
        ]);

        echo "Admin créé avec succès! Email: admin@pharmacie.com | Mot de passe: password123\n";
    }
}
