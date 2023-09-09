<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cryptocurrency;
use App\Models\Cryptovalues;


class CryptoController extends Controller
{
    // public function show($id) {
    //     $crypto = Cryptocurrency::findOrFail($id);
    //     return view('cryptoDetail', ['crypto' => $crypto]);
    // }

    // public function showDetail($id) {
    //     return view('crypto-detail', ['cryptoId' => $id]);
    // }

//     public function show($id)
// {
//     $crypto = Cryptocurrency::with('values')->find($id);
//     return view('cryptoDetail', compact('crypto'));
// }

public function show($id) {
    $crypto = Cryptocurrency::with('values')->find($id);
    return view('crypto-detail', compact('crypto')); // suppose que le blade se nomme `show.blade.php` dans un dossier `crypto`
}

public function getValues($id) {
    $crypto = Cryptocurrency::with('values')->find($id);
    return response()->json(['values' => $crypto->values->pluck('value')]);
}
public function showCryptoDetail($id) {
    $crypto = Cryptocurrency::with('values')->findOrFail($id);
    return view('crypto-detail', ['crypto' => $crypto]);
}
public function showCryptoDetailAdmin($id) {
    $crypto = Cryptocurrency::with('values')->findOrFail($id);
    return view('crypto-detail', ['crypto' => $crypto]);
}
}
