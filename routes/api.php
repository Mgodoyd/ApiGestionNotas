<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Requested-With');



Route::group(['middleware' => 'cors'], function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

//Owners  
Route::resource('ownersnotes', 'App\Http\Controllers\Owner\OwnerNotesController', ['except' => ['create','edit']]); 

//Authors
Route::resource('authorsnotes', 'App\Http\Controllers\Author\AuthorNotesController', ['except' => ['create','edit']]);

//Readers
Route::resource('readersnotes', 'App\Http\Controllers\Reader\ReaderNotesController', ['only' => ['index','show']]); 

//Writers 
Route::resource('writersnotes', 'App\Http\Controllers\Writer\WriterNotesController', ['except' => ['create','destroy','store']]);  

//Notes
Route::resource('notes', 'App\Http\Controllers\Notes\NotesController', ['except' => ['create','edit']]); 
Route::resource('notes.states', 'App\Http\Controllers\Notes\NotesStatesController', ['only' => ['index']]);
Route::resource('notes.users', 'App\Http\Controllers\Notes\NotesUserControlle', ['only' => ['index']]);

//States
Route::resource('states', 'App\Http\Controllers\States\StatesController', ['only' => ['index','show']]);  

//Rol
Route::resource('rols', 'App\Http\Controllers\Rol\RolController', ['only' => ['index','show']]);  
Route::resource('rols.users', 'App\Http\Controllers\Rol\RolUserController', ['only' => ['index']]);

//Users
Route::resource('users', 'App\Http\Controllers\User\UserController' , ['except' => ['create','edit']]); 
Route::name('verify')->get('users/verify/{token}', 'App\Http\Controllers\User\UserController@verify');

//auth
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

//login
Route::post('/api/login', [App\Http\Controllers\Login\LoginController::class, 'login'])->name('api.login');

//Register
Route::post('/api/register', [App\Http\Controllers\Register\RegisterController::class, 'register'])->name('api.register');

});







