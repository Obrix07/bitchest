<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Wallet;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    // ClientController.php

    public function getProfile() {
        $client = auth()->user();
        return response()->json($client);
        // return view('client-profile');
    }
    
    public function getWallet() {
        $userId = auth()->id();
        $wallet = Wallet::where('user_id', $userId)->with('cryptocurrency')->get();
        return response()->json($wallet);
    }
    
    public function buyCrypto(Request $request) {
        // Logique d'achat
        // N'oubliez pas de valider les données reçues
        // ...
    
        return response()->json(['message' => 'Achat réussi']);
    }
    
    public function sellCrypto(Request $request) {
        // Logique de vente
        // ...
    
        return response()->json(['message' => 'Vente réussie']);
    }
    
    
    
        
}
