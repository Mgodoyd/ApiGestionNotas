<?php

namespace App\Http\Controllers\Rol;

use App\Http\Controllers\Apicontroller;
use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;

class RolUserController extends Apicontroller
{
   /* public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
    }*/


    public function index($id)
    {
        $rol = Rol::find($id);
        if (!$rol) {
            return $this->errorResponse('El Rol no existe', 404);
        }
        $users = $rol->users;
        return $this->showAll($users);
    }

    
  /*  public function store(Request $request)
    {
        $request->validate([
            'rol_id' => 'required',
            'user_id' => 'required'
        ]);
    
        $rol_id = $request->input('rol_id');
        $user_id = $request->input('user_id');
        
        $rol = Rol::find($rol_id);
        if (!$rol) {
            return $this->errorResponse('El Rol no existe', 404);
        }
        
        $user = User::find($user_id);
        if (!$user) {
            return $this->errorResponse('El Usuario no existe', 404);
        }
        
        $rol->users()->attach($user_id);
        
        return $this->showOne($rol, 201);
    }*/
    
    
}
