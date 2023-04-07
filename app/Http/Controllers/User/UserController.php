<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Models\Notes;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    
   // ...
    
   


    public function index()
    {
        $usuarios = User::all();
        return $this->showAll($usuarios);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //  $roles = Rol::allRoles();
    
      //  $validated = 
          $request -> validate([
           'name' => 'required',
           'email' => 'required|email|unique:users',
            'password' => 'min:8',
           // 'role' => 'required|in:' . $roles->implode('id', ','),
        ]);
  
        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::NO_VERIFICADO;
        $campos['verification_token'] = User::generateVerificationToken();
       /// $campos['rol_id'] = $validated['role'];*
    
        $usuario = User::create($campos);
        return $this->showOne($usuario, 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->showOne($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    { 
      
       $validatedData = $request->validate([ //valida los campos
            'email' => 'email|unique:users,email,' . $user->id,
            'rol_id' => 'in:' . Rol::allRoles()->implode('id', ','),
        ]);

        $user->fill($validatedData);
    
    
        if($request->has('name')){  //si el request tiene el campo name
            $user->name = $request->name;   //se actualiza el nombre   
        }

        if($request->has('email') && $user->email != $request->email){ //si el request tiene el campo email y el email del usuario es diferente al email del request
            $user->is_verificado = User::NO_VERIFICADO;  //se actualiza el estado de verificacion
            $user->verification_token = User::generateVerificationToken();  //se genera un nuevo token de verificacion
            $user->email = $request->email; //se actualiza el email
        } 

        if($request->has('password')){    //si el request tiene el campo password
            $user->password = bcrypt($request->password);   //se actualiza el password
        }

        if ($request->has('rol_id')) { //si el request tiene el campo role
           if(!$user->isVerificado()){ //si el usuario no esta verificado
             return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su rol', 409);
           }
           $user->rol_id = $request->rol_id; //se actualiza el rol
        }
        
        if ($user->isDirty()) {
            $user->save();
        } else {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }
       
        return $this->showOne($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
    
        $user->delete();
    
        return $this->showOne($user, 200);
    }
    
}
