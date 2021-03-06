<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HEREController;
use App\Http\Controllers\ChatController;

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

Auth::routes();
Route::get('/', [GeneralController::class, 'showHome'])->middleware(['auth']);
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});

Route::get('/dashboard', [GeneralController::class, 'showHome'])->middleware(['auth'])->name('dashboard');

Route::get('/search', [GeneralController::class, 'showResults'])->middleware(['auth']);

Route::get('/product/create', [ProductController::class, 'showCreate'])->middleware(['auth'])->name('productCreate');
Route::post('/product/create', [ProductController::class, 'createProduct'])->middleware(['auth']);
Route::get('/product/{id}/edit', [ProductController::class, 'showEditProduct'])->middleware(['auth']);
Route::post('/product/{id}/edit', [ProductController::class, 'editProduct'])->middleware(['auth']);
Route::post('/product/{id}/remove', [ProductController::class, 'removeProduct'])->middleware(['auth']);

Route::get('/favorite/{productId}', [ProductController::class, 'favoriteProduct']);
Route::get('/favorites', [ProductController::class, 'showFavoriteProducts']);

Route::get('/chat', [ChatController::class, 'showChats'])->middleware(['auth'])->name('chat');
Route::get('/chat/{productId}', [ChatController::class, 'createChatShow'])->middleware(['auth']);
Route::get('/chat/{productId}/{userId}', [ChatController::class, 'sendMessage'])->middleware(['auth']);
Route::get('/chat/{productId}/{userId}/thread', [ChatController::class, 'showThread'])->middleware(['auth']);


Route::get('/product/{id}', [ProductController::class, 'showProduct'])->middleware(['auth']);
Route::get('/{category}', [ProductController::class, 'showCategory'])->middleware(['auth']);

Route::get('/profile/edit', [UserController::class, 'showEditProfile'])->middleware(['auth'])->name('profileEdit');
Route::get('/profile/{id}', [UserController::class, 'showProfile'])->middleware(['auth'])->name('profileView');
Route::post('/profile/edit', [UserController::class, 'editProfile'])->middleware(['auth']);

require __DIR__.'/auth.php';
