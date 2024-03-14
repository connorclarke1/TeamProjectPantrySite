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
    return redirect('/products');
});

Route::get('products', [ProductController::class, 'index'])->name('products');

Route::get('/products/create', [ProductController::class, 'create'])->name('create');

Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('edit');


Route::get('products/{id}', [ProductController::class, 'show']);


Route::post('/products', [ProductController::class, 'store'])->name('store');

Route::put('/products/{id}/edit', [ProductController::class, 'update'])->name('products.edit');

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
