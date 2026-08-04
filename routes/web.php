<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MidtransController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/midtrans/success', [MidtransController::class, 'success']);
Route::get('/midtrans/unfinish', [MidtransController::class, 'unfinish']);
Route::get('/midtrans/error', [MidtransController::class, 'error']);
