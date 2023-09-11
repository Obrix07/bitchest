<?php

namespace Database\Seeders;

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
            'name' => 'Jerome',
            'email' => 'jerome@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin', 
        ]);

        // Seeder pour les clients
        $users = [
            ['name' => 'Alice Dupont', 'email' => 'alice.dupont@gmail.com'],
            ['name' => 'Bruno Martin', 'email' => 'bruno.martin@gmail.com'],
            ['name' => 'Claire Lefèvre', 'email' => 'claire.lefevre@gmail.com'],
            ['name' => 'David Bernard', 'email' => 'david.bernard@gmail.com'],
            ['name' => 'Eloïse Leroux', 'email' => 'eloise.leroux@gmail.com'],
        ];
        
        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('password'),
                'wallet_balance' => rand(400, 2000),
                'role' => 'client',
            ]);
        }
    }
}
