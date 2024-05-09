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

//Redirect to inventory if URL is entered alone
Route::get('/', function () {
    return redirect('/inventory');
});

//Inventory Route
Route::get('inventory', [ProductController::class, 'index'])->name('inventory');

//Create Product Route
Route::get('/products/create', [ProductController::class, 'create'])->name('create');

//Editing instacne of product route
Route::get('inventoryUpdate/{user_productID}', [ProductController::class, 'editInstance']);

//Recipes route
Route::get('recipes', function (){ return view('recipes');}) -> name('recipes');

//Scan barcode page route
Route::get('barcode', function (){ return view('barcode');}) -> name('barcode');

//Edit product route
Route::get('/inventory/{id}/edit', [ProductController::class, 'edit'])->name('edit');

//Selected Product Route
Route::get('inventory/{id}', [ProductController::class, 'show']);

//Creating product form submission route
Route::post('/inventory', [ProductController::class, 'store'])->name('store');

//Edit product form submission route
Route::put('/inventory/{id}/edit', [ProductController::class, 'update'])->name('products.edit');

//Save new instance of product route
Route::post('/inventoryInstance', [ProductController::class, 'storeInstance'])->name('storeInstance');

//Scanning barcode form submission route
Route::post('/barcode', [ProductController::class, 'findBarcode']) -> name('findBarcode');

//Update product instance route
Route::put('/inventoryUpdate/{user_productID}', [ProductController::class, 'updateInstance'])->name('products.updateInstance');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Delete product form submission route
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

//Delete product instance route
Route::delete('/inventoryUpdate/{user_productID}', [ProductController::class, 'destroyInstance'])->name('products.destroyInstance');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
