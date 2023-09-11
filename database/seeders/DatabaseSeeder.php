<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use UsersTableSeeder;
use CryptocurrencyTableSeeder;
use CryptovaluesSeeder;
use BrunoTransactionsAndWalletSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            CryptocurrencyTableSeeder::class,
            CryptovaluesSeeder::class,
            BrunoTransactionsAndWalletSeeder::class,
        ]);
    }
}
