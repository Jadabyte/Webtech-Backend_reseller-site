<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

Route::get('/dashboard', [GeneralController::class, 'showHome'])->middleware(['auth'])->name('dashboard');
Route::post('/productSearch', [GeneralController::class, 'searchProducts']);
Route::get('/productSearch', [GeneralController::class, 'showResults']);

Route::get('/product/create', [ProductController::class, 'showCreate'])->middleware(['auth'])->name('productCreate');
Route::post('/product/create', [ProductController::class, 'createProduct']);

Route::get('/product/{id}', [ProductController::class, 'showProduct']);
Route::get('/{category}', [ProductController::class, 'showCategory']);

Route::get('/profile/edit', [UserController::class, 'showEditProfile'])->middleware(['auth'])->name('profileEdit');
Route::get('/profile/{id}', [UserController::class, 'showProfile'])->middleware(['auth'])->name('profileView');
Route::post('/profile/edit', [UserController::class, 'editProfile']);

require __DIR__.'/auth.php';
