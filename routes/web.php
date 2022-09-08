<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::prefix(LaravelLocalization::setLocale())->group(function(){
    Route::prefix('admin')->name('admin.')->middleware('auth', 'user_type', 'verified')->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('index');

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::get('delete-image/{id}', [ProductController::class, 'delete_image'])->name('products.delete_image');

    });
});

Auth::routes(['verify' => true]);
// Auth::routes(['verify' => true, 'register' => false]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('no-access', 'no_access');


// Site Routes
Route::get('/', function() {
    return 'home';
})->name('site.index');
