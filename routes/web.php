<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

// Routes pour les administrateurs
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::prefix('admin')->group(function() {
        Route::get('/', function () {
            return view('admin-dashboard');
        });
        Route::get('/client/{id}', [AdminController::class, 'showClient']);
        Route::get('/create-client', function () {
            return view('create-client');
        });
        Route::delete('/delete-client/{id}', 'AdminController@deleteClient')->name('admin.deleteClient');
    });
});

// // Routes pour les clients
// Route::middleware(['auth:sanctum', 'role:client'])->group(function () {
//     Route::get('profile', [ClientController::class, 'getProfile']);
//     Route::get('wallet', 'ClientController@getWallet');
//     Route::post('transactions/buy', 'ClientController@buyCrypto');
//     Route::post('transactions/sell', 'ClientController@sellCrypto');
// });


require __DIR__.'/auth.php';
