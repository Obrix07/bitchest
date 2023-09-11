<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CryptoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/admin/profile', [ProfileController::class, 'editAdmin'])->name('profile.admin-edit');
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
        Route::get('/list', function () {
            return view('admin-crypto-list');
        });
    Route::get('/crypto/{id}', [CryptoController::class, 'showCryptoDetailAdmin']);

    });
});

// Routes pour les clients
Route::middleware(['auth:sanctum', 'role:client'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });
    Route::get('/list', function () {
        return view('crypto-list');
    });
    Route::get('/crypto/{id}', [CryptoController::class, 'showCryptoDetail']);
});




require __DIR__.'/auth.php';
