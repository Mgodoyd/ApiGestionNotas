<?php

namespace App\Http\Controllers\States;

use App\Http\Controllers\ApiController;
use App\Models\States;

class StatesController extends ApiController
{
    public function __construct() //constructor de la clase y se le pasa el middleware para que solo se pueda acceder a los metodos de esta clase si se esta autenticado
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->only(['index', 'show']);
        $this->middleware('scope:manage-rol-state')->only(['index', 'show']);
    }
    public function index()//metodo para mostrar todos los estados
    {
        $statess = States::all();
        return $this->showAll($statess);
    }
    public function show(string $id)//metodo para mostrar un estado
    {
        $statess = States::findOrFail($id);
        return $this->showOne($statess, 200);
    }

}
