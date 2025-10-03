<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\RenderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [RenderController::class, "renderLanding"])->name("landing");


Route::middleware('guest')->group(function () {
    Route::get('/login', [RenderController::class, 'renderLogin'])->name('login');
    Route::get('/register', [RenderController::class, 'renderRegister'])->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/connect', [RenderController::class, 'renderConnect'])->name('connect');

    Route::post('/user/connect', [UserController::class, 'connect'])->name('user.connect');

    Route::get('/dashboard', [RenderController::class, 'renderDashboard'])->name('dashboard');
    Route::get('/myReports', [RenderController::class, 'renderMyReports'])->name('myReports');
    Route::get('/publicList', [RenderController::class, 'renderPublicList'])->name('publicList');
    Route::get('/earnings', [RenderController::class, 'renderEarnings'])->name('earnings');

    Route::prefix('address')->group(function () {
        Route::post('/create', [AddressController::class, 'store'])->name('address.create');
    });
});


require __DIR__ . '/auth.php';
