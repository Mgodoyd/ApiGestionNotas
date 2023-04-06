<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Owners
Route::resource('owners', 'App\Http\Controllers\Owner\OwnerController', ['except' => ['create','edit']]);  

//Authors
Route::resource('authors', 'App\Http\Controllers\Author\AuthorController', ['except' => ['create','edit']]); 

//Readers
Route::resource('readers', 'App\Http\Controllers\Reader\ReaderController', ['only' => ['index','show']]);  

//Writers
Route::resource('writers', 'App\Http\Controllers\Writer\WriterController', ['except' => ['create','destroy','store']]);  

//Notes
Route::resource('notess', 'App\Http\Controllers\Notes\NotesController'); 

//States
Route::resource('states', 'App\Http\Controllers\States\StatesController', ['only' => ['index','show']]);  

//Users
Route::resource('users', 'App\Http\Controllers\User\UserController' , ['except' => ['create','edit']]); 

//Rol
Route::resource('rol', 'App\Http\Controllers\Rol\RolController', ['only' => ['index','show']]);  


