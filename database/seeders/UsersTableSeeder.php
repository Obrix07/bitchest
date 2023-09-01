<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seeder pour les admins
        User::create([
            'name' => 'Admin1',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',  // Supposant que vous utilisez une colonne 'role' dans la table users
        ]);

        User::create([
            'name' => 'Admin2',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Seeder pour les clients
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => 'Client' . $i,
                'email' => 'client' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'client',
            ]);
        }
    }
}
