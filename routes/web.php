<?php

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


Route::get('/', [App\Http\Controllers\Return\ReturnController::class, 'index']);
Route::get('/{barcode}', [App\Http\Controllers\Return\ReturnController::class, 'show'])->name('return.show');
Route::post('/create', [App\Http\Controllers\Return\ReturnController::class, 'create'])->name('return.create');
Route::get('/pdf/{barcode}', [App\Http\Controllers\Return\ReturnController::class, 'return_pdf'])->name('return.return_pdf');
