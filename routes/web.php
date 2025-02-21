<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\GoogleSheetController;

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


Route::post('/items/generate', [ItemController::class, 'generateData'])->name('items.generate');

Route::get('/items/clear', [ItemController::class, 'clear'])->name('items.clear');

Route::get('/', [ItemController::class, 'index'])->name('home');

Route::resource('items', ItemController::class);
Route::get('/fetch/{count?}', [GoogleSheetController::class, 'fetch']);