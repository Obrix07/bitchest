<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('clients', [AdminController::class, 'getClients']);
Route::put('clients/{id}', [AdminController::class, 'updateClient']);
Route::post('clients', [AdminController::class, 'createClient']);
Route::delete('clients/{id}', [AdminController::class, 'deleteClient']);

Route::post('/buy-crypto', [ClientController::class, 'buyCrypto']);
Route::post('/sell-crypto', [ClientController::class, 'sellCrypto']);
Route::get('/get-buying-price/{cryptoName}', [ClientController::class, 'getBuyingPrice']);
Route::get('/current-price/{cryptoName}', [ClientController::class, 'getCurrentPrice']);
Route::get('/client/dashboard', [ClientController::class, 'showDashboardData']);
Route::get('/all-cryptos', [ClientController::class, 'getAllCryptos']);
Route::get('/crypto-values/{id}', [CryptoController::class, 'getValues']);

