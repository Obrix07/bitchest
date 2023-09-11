<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cryptocurrency;
use App\Models\Cryptovalues;


class CryptoController extends Controller
{
    
public function getValues($id) {
    $crypto = Cryptocurrency::with('values')->find($id);
    return response()->json(['values' => $crypto->values->pluck('value')]);
}
public function showCryptoDetailAdmin($id) {
    $crypto = Cryptocurrency::with('values')->findOrFail($id);
    return view('admin-crypto-detail', ['crypto' => $crypto]);
}
public function showCryptoDetail($id) {
    $crypto = Cryptocurrency::with('values')->findOrFail($id);
    return view('crypto-detail', ['crypto' => $crypto]);
}
}
