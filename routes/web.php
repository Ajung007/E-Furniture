<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\TestController;
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

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/details/{slug}', [FrontendController::class, 'details'])->name('details');
Route::get('/cart', [FrontendController::class, 'cart'])->name('cart');
Route::get('/checkout/success', [FrontendController::class, 'success'])->name('checkout.succes');

// Route::get('/test', [TestController::class, 'index'])->name('test');


Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->name('dashboard.')->prefix('dashboard')->group(function (){
    Route::get('/', [DashboardController::class,'index'])->name('index');


    Route::middleware(['admin'])->group(function ()
    {
        Route::resource('product', ProductController::class);
        Route::resource('product.gallery', ProductGalleryController::class)->shallow()->only([
            'index','create','store','destroy'
        ]);
    });

});

