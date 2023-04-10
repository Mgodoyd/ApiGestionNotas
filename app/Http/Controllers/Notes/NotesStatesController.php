<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Apicontroller;
use App\Models\States;

class NotesStatesController extends Apicontroller
{
    public function __construct() //constructor de la clase y se le pasa el middleware para que solo se pueda acceder a los metodos de esta clase si se esta autenticado
    {
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('auth:api')->only(['index']);
        $this->middleware('scope:manage-rol-state')->only(['index']);
    }

    public function index($id) //metodo para mostrar todas las notas de un estado
    {
        $state = States::find($id);
        if (!$state) {
            return $this->errorResponse('El estado no existe', 404);
        }
        $notes = $state->notes;
        return $this->showAll($notes);
    }
}
