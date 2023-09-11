<?php

namespace Database\Seeders;

use App\Models\Cryptocurrency;
use App\Models\Cryptovalues;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BrunoTransactionsAndWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $bruno = User::where('name', 'Bruno Martin')->first();

        $dates = [
            Carbon::parse('2023-09-01'),
            Carbon::parse('2023-09-02'),
        ];

        foreach ($dates as $date) {
            $crypto = Cryptocurrency::inRandomOrder()->first();
            
            $cryptoValue = Cryptovalues::where('cryptocurrency_id', $crypto->id)->where('value_date', $date)->first();
            
            $quantity = rand(1, 10);

            $transaction = Transaction::create([
                'user_id' => $bruno->id,
                'cryptocurrency_id' => $crypto->id,
                'cryptovalues_id' => $cryptoValue->id,
                'type' => 'buy', 
                'quantity' => $quantity,
            ]);

            $wallet = Wallet::firstOrCreate([
                'user_id' => $bruno->id,
                'cryptocurrency_id' => $crypto->id,
                'quantity' => 0,
            ]);

            $wallet->quantity += $quantity;
            $wallet->save();
        }
    }
}
