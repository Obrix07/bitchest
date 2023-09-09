<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cryptocurrency;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    // API

public function getProfile() {
    $admin = auth()->user();
    return response()->json($admin);
}

public function getClients() {
    $clients = User::where('role', 'client')->get();
    return response()->json($clients);
}

public function createClient(Request $request) {
    $client = User::create($request->all());
    return response()->json($client);
}

public function getClient($id) {
    $client = User::findOrFail($id);
    return response()->json($client);
}

public function updateClient(Request $request, $id) {
    $client = User::findOrFail($id);
    $client->update($request->all());
    return response()->json($client);
}

public function deleteClient($id) {
    $client = User::findOrFail($id);
    $client->delete();
    return response()->json(['message' => 'Client supprimé avec succès']);
}

public function getCryptocurrencies() {
    $cryptos = Cryptocurrency::all();
    return response()->json($cryptos);
}

// FRONT

public function showClient($id) {
    $client = User::findOrFail($id);
    return view('client-details', ['client' => $client->toJson()]);
}

// public function getAllCryptos()
//     {
//         $cryptos = Cryptocurrency::select(
//             'id',
//             'name',
//             'symbol',
//             DB::raw("(SELECT value FROM cryptovalues WHERE cryptocurrencies.id = cryptovalues.cryptocurrency_id ORDER BY value_date DESC LIMIT 1) as latest_value")
//         )->get();
//         return response()->json($cryptos);
//     }

}
