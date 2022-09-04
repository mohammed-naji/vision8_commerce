<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::prefix(LaravelLocalization::setLocale())->group(function(){
    Route::prefix('admin')->name('admin.')->middleware('auth', 'user_type', 'verified')->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('index');
    });
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('no-access', 'no_access');
