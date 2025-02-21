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

Route::get('/', function () {
    return view('/items/index');
});
Route::get('/items/generate', [ItemController::class, 'generate'])->name('items.generate');
Route::get('/items/clear', [ItemController::class, 'clear'])->name('items.clear');
Route::get('/items/edit', [ItemController::class, 'edit'])->name('items.edit');
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
Route::get('/items/show', [ItemController::class, 'show'])->name('items.show');
Route::get('/fetch/{count?}', function ($count = null) {
    $command = 'fetch:google-sheets ' . ($count ?: '');
    $output = shell_exec("php artisan $command");
    return "<pre>$output</pre>";
});