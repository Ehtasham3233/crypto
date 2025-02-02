<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptoController;

Route::get('/', function () {
    return view('welcome');
});
// api route
Route::get('/cryptos', [CryptoController::class, 'index']);

// Route to fetch cryptocurrency data as JSON
// Route::get('/cryptos', [CryptoController::class, 'getCryptos']);
// Route to display the Crypto List view
// Route::get('/crypto', function () {
//     return view('crypto'); // Assuming the Blade file is in resources/views/crypto.blade.php
// });
use App\Http\Controllers\TradeController;

Route::get('/trade', [TradeController::class, 'index']);
Route::post('/trade', [TradeController::class, 'store']);
Route::get('/trade-chart', [TradeController::class, 'getChartData']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
