<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
    return redirect('/inventory');
});

Route::get('inventory', [ProductController::class, 'index'])->name('inventory');

Route::get('/products/create', [ProductController::class, 'create'])->name('create');

Route::get('/inventory/{id}/edit', [ProductController::class, 'edit'])->name('edit');


Route::get('inventory/{id}', [ProductController::class, 'show']);

Route::get('recipes', function (){ return view('recipes');}) -> name('recipes');


Route::post('/inventory', [ProductController::class, 'store'])->name('store');

Route::post('/inventoryInstance', [ProductController::class, 'storeInstance'])->name('storeInstance');

Route::put('/inventory/{id}/edit', [ProductController::class, 'update'])->name('products.edit');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
