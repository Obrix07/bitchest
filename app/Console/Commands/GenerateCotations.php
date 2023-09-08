<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cryptocurrency;  // importez le modèle Cryptocurrency
use App\Models\Cryptovalues;  // importez le modèle Cryptovalues
use Carbon\Carbon;

class GenerateCotations extends Command
{
    protected $signature = 'generate:cotations';
    protected $description = 'Generate daily crypto cotations';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $cryptos = Cryptocurrency::all(); // Récupérer toutes les crypto-monnaies depuis la BDD

        foreach ($cryptos as $crypto) {
            $firstCotation = $this->getFirstCotation($crypto->name);
            $dailyCotation = $this->getCotationFor($crypto->name);

            // Enregistrez ces valeurs dans votre base de données
            $cotation = new Cryptovalues();
            $cotation->cryptocurrency_id = $crypto->id;
            $cotation->value = $firstCotation + $dailyCotation;
            $cotation->value_date = Carbon::now();
            $cotation->save();
        }
    }
    function getFirstCotation($cryptoname){
        return ord(substr($cryptoname,0,1)) + rand(0, 10);
    }
  
    function getCotationFor($cryptoname){	
        return ((rand(0, 99)>40) ? 1 : -1) * ((rand(0, 99)>49) ? ord(substr($cryptoname,0,1)) : ord(substr($cryptoname,-1))) * (rand(1,10) * .01);
    }
}
