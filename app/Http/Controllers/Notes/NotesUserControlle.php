<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Apicontroller;
use App\Models\User;


class NotesUserControlle extends Apicontroller
{
    public function __construct() //constructor de la clase y se le pasa el middleware para que solo se pueda acceder a los metodos de esta clase si se esta autenticado
    {
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('auth:api')->only(['index']);
        $this->middleware('scope:update')->only(['index']);
    }

    public function index($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return $this->errorResponse('El usuario no existe', 404);
        }
        
    
        $notes = $user->notes;
     
        return $this->showAll($notes);
    }
    
}
