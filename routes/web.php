<?php

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
/*
Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    try {
        DB::connection()->getPdo();
        return "Conexión establecida correctamente.". DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "No se pudo establecer la conexión. Error: " . $e->getMessage();
    }
});*/

// Registration Routes...
// Registration Routes
Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.submit');

// Authentication Routes
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.submit');
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');



// Password Reset Routes...
/*
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');*/



//Auth::routes();

Route::get('/home/my-tokens', [App\Http\Controllers\HomeController::class,'getTokens'])->name('personal-tokens');
Route::get('/home/my-clients', [App\Http\Controllers\HomeController::class,'getClients'])->name('personal-clients');
Route::get('/home/authorized-clients', [App\Http\Controllers\HomeController::class,'getAuthorizedClients'])->name('authorized-clients');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/',function(){
    return view('welcome');
})->middleware('guest');
