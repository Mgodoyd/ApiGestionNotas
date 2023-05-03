<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{        
    public function login(Request $request) 
{
    $credentials = $request->only('email', 'password', 'rol_id');

    if (Auth::attempt($credentials)) {
       
        $user = Auth::user(); //obtenemos el usuario autenticado
        $rol_id = $user->rol_id;
        $id = $user->id;
        $scopes = []; //inicializamos el array de scopes vacio
       
        switch ($rol_id) {
            case 1:
            $scopes = ['manage-account','manage-rol-user', 'manage-rol-state','update','store','destroy']; //owner
                break;
            case 2:
                $scopes = ['manage-rol-user','update','store','destroy'];//author
                break;
            case 3:
                $scopes = ['update'];//writer
                break;
            case 4:
                $scopes = [ ];//reader
                break;
            default:
                // En caso de que el rol_id no coincida con ninguno de los casos anteriores
                return response()->json(['error' => 'Invalid role'], 401);
        }

        $tokenResult = $user->createToken('Personal Access Token', $scopes); //creamos el token
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'id' => $id,
            'rol_id' => $rol_id,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ])->header('Authorization', 'Bearer ' . $tokenResult->accessToken);        
    } else {
        return response()->json(['error' => 'No Autorizado'], 401);
          }
     }

}