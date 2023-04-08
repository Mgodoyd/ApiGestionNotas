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
Route::resource('ownersnotes', 'App\Http\Controllers\Owner\OwnerNotesController', ['except' => ['create','edit']]); 

//Authors
Route::resource('authors', 'App\Http\Controllers\Author\AuthorController', ['except' => ['create','edit']]); 
Route::resource('authorsnotes', 'App\Http\Controllers\Author\AuthorNotesController', ['except' => ['create','edit']]);

//Readers
Route::resource('readers', 'App\Http\Controllers\Reader\ReaderController', ['only' => ['index','show']]);  
Route::resource('readersnotes', 'App\Http\Controllers\Reader\ReaderNotesController', ['only' => ['index','show']]); 

//Writers
Route::resource('writers', 'App\Http\Controllers\Writer\WriterController', ['except' => ['create','destroy','store']]);  
Route::resource('writersnotes', 'App\Http\Controllers\Writer\WriterNotesController', ['except' => ['create','destroy','store']]);  

//Notes
Route::resource('notes', 'App\Http\Controllers\Notes\NotesController', ['except' => ['create','edit']]); 
Route::resource('notes.states', 'App\Http\Controllers\Notes\NotesStatesController', ['only' => ['index']]);

//States
Route::resource('states', 'App\Http\Controllers\States\StatesController', ['only' => ['index','show']]);  

//Rol
Route::resource('rols', 'App\Http\Controllers\Rol\RolController', ['only' => ['index','show']]);  
Route::resource('rols.users', 'App\Http\Controllers\Rol\RolUserController', ['only' => ['index']]);

//Users
Route::resource('users', 'App\Http\Controllers\User\UserController' , ['except' => ['create','edit']]); 
Route::name('verify')->get('users/verify/{token}', 'App\Http\Controllers\User\UserController@verify');

//Rol
Route::resource('rols', 'App\Http\Controllers\Rol\RolController', ['only' => ['index','show']]);  
Route::resource('rols.users', 'App\Http\Controllers\Rol\RolUserController', ['only' => ['index']]);

Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');


