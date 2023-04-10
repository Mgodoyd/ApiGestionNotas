<?php

namespace App\Http\Controllers\Rol;

use App\Http\Controllers\Apicontroller;
use App\Models\Rol;

class RolController extends Apicontroller
{
     public function __construct() //constructor de la clase y se le pasa el middleware para que solo se pueda acceder a los metodos de esta clase si se esta autenticado
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->only(['index', 'show']);
        $this->middleware('scope:manage-rol-state')->only(['index', 'show']);

    }
    public function index()//metodo para mostrar todos los roles
    {
        $rol = Rol::all();
        return $this->showAll($rol);
    }
    public function show(Rol $rol)//metodo para mostrar un rol
    {
        return $this->showOne($rol, 200);
    }
   
}
