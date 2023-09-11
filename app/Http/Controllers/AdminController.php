<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cryptocurrency;

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

// FRONT

public function showClient($id) {
    $client = User::findOrFail($id);
    return view('client-details', ['client' => $client->toJson()]);
}

}
