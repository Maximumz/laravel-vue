<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return Inertia::render('Home', [
      'canLogin' => Route::has('login'),
      'canRegister' => Route::has('register'),
      'products' => Product::getProducts(),
  ]);
})->name('home');

Route::get('/shop', function () {
  return Inertia::render('Shop', [
      'products' => Product::getProducts(),
  ]);
})->name('shop');

Route::get('/cart', function () {
  return Inertia::render('Shop/Cart', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'cart' => session('cart')
  ]);
})->name('cart');

Route::get('add-to-cart/{id}',
  [CartController::class, 'addToCart'])->name('addToCart');

  Route::get('remove-from-cart/{id}',
    [CartController::class, 'removeFromCart'])->name('removeFromCart');

Route::post('add-product/',
  [ProductController::class, 'store'])->name('addProduct');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
  return Inertia::render('Dashboard');
})->name('dashboard');
