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

