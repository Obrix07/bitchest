<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Cryptocurrency;
use App\Models\Cryptovalues;

class CryptovaluesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cryptos = Cryptocurrency::all(); // Obtenez toutes les cryptos

        foreach ($cryptos as $crypto) {
            for ($i = 0; $i < 30; $i++) { // Génération de données pour les 30 derniers jours
                $date = Carbon::now()->subDays($i);

                $firstCotation = $this->getFirstCotation($crypto->name);
                $dailyCotation = $this->getCotationFor($crypto->name);

                $value = $firstCotation + $dailyCotation;

                Cryptovalues::create([
                    'cryptocurrency_id' => $crypto->id,
                    'value' => $value,
                    'value_date' => $date->toDateString(),
                ]);
            }
        }
    }

    private function getFirstCotation($cryptoname){
        return ord(substr($cryptoname, 0, 1)) + rand(0, 10);
    }
  
    private function getCotationFor($cryptoname){	
        return ((rand(0, 99) > 40) ? 1 : -1) * ((rand(0, 99) > 49) ? ord(substr($cryptoname, 0, 1)) : ord(substr($cryptoname, -1))) * (rand(1, 10) * .01);
    }
}

