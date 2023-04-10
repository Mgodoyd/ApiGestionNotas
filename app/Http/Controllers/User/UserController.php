<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    public function __construct()//constructor de la clase y se le pasa el middleware para que solo se pueda acceder a los metodos de esta clase si se esta autenticado
    {
       // $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['verify']);
        $this->middleware('scope:manage-account')->only(['index', 'show','store', 'update', 'destroy']);
    } 
    public function index()//metodo para mostrar todos los usuarios
    {
        $usuarios = User::all();
        return $this->showAll($usuarios);
    }
    public function store(Request $request) //metodo para crear un usuario
    {
          $request -> validate([
           'name' => 'required',
           'email' => 'required|email|unique:users',
           'password' => 'min:8',
        ]);
  
        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::NO_VERIFICADO;
        $campos['verification_token'] = User::generateVerificationToken();
     
        $usuario = User::create($campos);
        return $this->showOne($usuario, 201);
    }
    public function show(User $user) //metodo para mostrar un usuario
    {
         return $this->showOne($user, 200);
    }
    public function update(Request $request, User $user) //metodo para actualizar un usuario
    {
        $usuarioExistente = User::where('email', $request->input('email'))->exists();
    
       if ($usuarioExistente) {
           return $this->errorResponse('Ya existe un usuario con el mismo Email', 400);
       }
      
         $request->validate([
          'email' => 'email',
          'password' => 'min:8',]);

        $user->fill($request->only([
           'email',
        ]));
       
        if($request->has('name')){  //si el request tiene el campo name
            $user->name = $request->name;   //se actualiza el nombre   
        }

        if($request->has('email') && $user->email != $request->email){ //si el request tiene el campo email y el email del usuario es diferente al email del request
            $user->is_verificado = User::NO_VERIFICADO;  //se actualiza el estado de verificacion
            $user->verification_token = User::generateVerificationToken();  //se genera un nuevo token de verificacion
            $user->email = $request->email; //se actualiza el email
            $user->save(); //se guarda el usuario
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
       public function destroy(User $user) //metodo para eliminar un usuario
    {
        $user->delete();
        return $this->showOne($user, 200);
    }
     public function verify($token)//metodo para verificar un usuario
    {
        $user = User::where('verification_token', $token)->firstOrFail();
        $user->is_verificado = User::VERIFICADO;
        $user->verification_token = null;
        $user->save();
    
        return new JsonResponse('El usuario ha sido verificado', 200);
    }
}
