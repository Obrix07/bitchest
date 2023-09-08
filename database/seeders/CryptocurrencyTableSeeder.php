<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cryptocurrency;

class CryptocurrencyTableSeeder extends Seeder
{
    public function run()
    {
        Cryptocurrency::create(['name' => 'Bitcoin', 'symbol' => 'BTC']);
        Cryptocurrency::create(['name' => 'Ethereum', 'symbol' => 'ETH']);
        Cryptocurrency::create(['name' => 'Ripple', 'symbol' => 'XRP']);
        Cryptocurrency::create(['name' => 'Bitcoin Cash', 'symbol' => 'BCH']);
        Cryptocurrency::create(['name' => 'Cardano', 'symbol' => 'ADA']);
        Cryptocurrency::create(['name' => 'Litecoin', 'symbol' => 'LTC']);
        Cryptocurrency::create(['name' => 'NEM', 'symbol' => 'XEM']);
        Cryptocurrency::create(['name' => 'Stellar', 'symbol' => 'XLM']);
        Cryptocurrency::create(['name' => 'IOTA', 'symbol' => 'IOTA']);
        Cryptocurrency::create(['name' => 'Dash', 'symbol' => 'DASH']);
    }
}

