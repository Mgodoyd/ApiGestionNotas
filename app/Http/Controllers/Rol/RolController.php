<?php

namespace App\Http\Controllers\Rol;

use App\Http\Controllers\Apicontroller;
use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Apicontroller
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('scope:manage-rol-state')->except(['index']);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rol = Rol::all();
        return $this->showAll($rol);
    }

    

    /**
     * Display the specified resource.
     */
    public function show(Rol $rol)
    {
        return $this->showOne($rol, 200);
    }
   
}
