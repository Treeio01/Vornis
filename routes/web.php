<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Settings;
use App\Models\Address;
use App\Models\Reward;
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
    $settings = Settings::find(1);
    return Inertia::render('Landing', [
        "twitter" => $settings->twitter,
        "text" => $settings->text
    ]);
})->name("landing");

Route::get('/login', function () {
    return Inertia::render('Login');
})->middleware('guest')->name('login');
Route::get('/register', function () {
    return Inertia::render('Register');
})->middleware('guest')->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/connect', function () {
        return Inertia::render('Connect');
    })->name('connect');

    Route::post("/user/connect", [UserController::class, "connect"])->name("connect");

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', [
            "twitter" => Settings::find(1)->twitter,
            "addresses" => Address::all()
        ]);
    })->name('dashboard');
    Route::get('/myReports', function () {
        return Inertia::render('MyReports', [
            "twitter" => Settings::find(1)->twitter,
            "addresses" => Address::where("user_id", auth()->user()->id)->get()
        ]);
    })->name('myReports');
    Route::get('/publicList', function () {
        return Inertia::render('PublicList', [
            "twitter" => Settings::find(1)->twitter,
            "addresses" => Address::where("status", "scam")->get()
        ]);
    })->name('publicList');
    Route::get('/earnings', function () {
        return Inertia::render('Earnings', [
            "twitter" => Settings::find(1)->twitter,
            "addresses" => Address::where("user_id", auth()->user()->id)->where("status", "scam")->get()
        ]);
    })->name('earnings');
    Route::prefix("/address")->group(function () {
        Route::post("/create", [AddressController::class, "store"])->name("address.create");
    });
});


require __DIR__ . '/auth.php';
