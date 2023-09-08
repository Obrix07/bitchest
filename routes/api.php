<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('clients', [AdminController::class, 'getClients']);
Route::put('clients/{id}', [AdminController::class, 'updateClient']);
Route::post('clients', [AdminController::class, 'createClient']);
Route::delete('clients/{id}', [AdminController::class, 'deleteClient']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'showDashboardData']);
    Route::get('/all-cryptos', [ClientController::class, 'getAllCryptos']);
    Route::get('/crypto-values/{id}', [CryptoController::class, 'getValues']);

});


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// // Routes pour les administrateurs
// Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
//     Route::prefix('admin')->group(function() {
//         Route::get('profile', 'AdminController@getProfile');
//         Route::get('clients', 'AdminController@getClients');
//         Route::post('clients', 'AdminController@createClient');
//         Route::get('clients/{id}', 'AdminController@getClient');
//         Route::put('clients/{id}', 'AdminController@updateClient');
//         Route::delete('clients/{id}', 'AdminController@deleteClient');
//         Route::get('cryptocurrencies', 'AdminController@getCryptocurrencies');
//     });
// });

// // Routes pour les clients
// Route::middleware(['auth:sanctum', 'role:client'])->group(function () {
//     Route::get('profile', 'ClientController@getProfile');
//     Route::get('wallet', 'ClientController@getWallet');
//     Route::post('transactions/buy', 'ClientController@buyCrypto');
//     Route::post('transactions/sell', 'ClientController@sellCrypto');
// });

// require __DIR__.'/auth.php';

