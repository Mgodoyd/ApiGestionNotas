<?php

namespace App\Http\Controllers\Rol;

use App\Http\Controllers\Apicontroller;
use App\Models\Rol;

class RolUserController extends Apicontroller
{
    public function __construct() //constructor de la clase y se le pasa el middleware para que solo se pueda acceder a los metodos de esta clase si se esta autenticado
    {
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('auth:api')->only(['index']);
        $this->middleware('scope:manage-rol-state')->only(['index']);

    }
    public function index($id) //metodo para mostrar todos los usuarios de un rol
    {
        $rol = Rol::find($id);
        if (!$rol) {
            return $this->errorResponse('El Rol no existe', 404);
        }
        $users = $rol->users;
        return $this->showAll($users);
    }
}
