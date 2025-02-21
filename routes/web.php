<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

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

// Route::get('/', [ItemController::class, 'index'])->name('home');

// Route::resource('items', ItemController::class);

// // Дополнительные маршруты
Route::post('/items/generate', [ItemController::class, 'generateData'])->name('items.generate');

Route::get('/items/clear', [ItemController::class, 'clear'])->name('items.clear');

// // Роут для вывода данных из Google Sheets
// Route::get('/fetch/{count?}', function ($count = null) {
//     $command = 'fetch:google-sheets ' . ($count ?? '');
//     $output = shell_exec("php artisan $command");
//     return "<pre>$output</pre>";
// })->name('fetch');
// Route::resource('items', ItemController::class);
// Route::get('/fetch/{count?}', [GoogleSheetController::class, 'fetch']);

Route::get('/', [ItemController::class, 'index'])->name('home');

Route::resource('items', ItemController::class);
Route::get('/fetch/{count?}', [GoogleSheetController::class, 'fetch']);