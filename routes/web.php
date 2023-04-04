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
});

