<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *//* public function login(Request $request)
    {
        $credentials = $request->only('email', 'password', 'rol_id');
    
        if (Auth::attempt($credentials)) {
            $rol_id = $request->input('rol_id');
            $user = Auth::user();
            $tokenResult = $user->createToken('Personal Access Token',['manage-notes', 'manage-account', 'manage-rol-state', 'update-notes', 'read-notes']);
            $token = $tokenResult->token;
            $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
           // dd($rol_id);
          

    
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'rol_id' => $rol_id,
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    */public function login(Request $request)
{
    $credentials = $request->only('email', 'password', 'rol_id');

    if (Auth::attempt($credentials)) {
        $rol_id = $request->input('rol_id');
        $user = Auth::user();
       //var_dump($user);
        $scopes = [];
       
        switch ($rol_id) {
            case 1:
                $scopes = ['manage-notes', 'manage-account', 'manage-rol-state','update-notes','read-notes']; //owner
                break;
            case 2:
                $scopes = ['manage-notes'];//author
                break;
            case 3:
                $scopes = ['update-notes'];//writer
                break;
            case 4:
                $scopes = ['read-notes'];//reader
                break;
            default:
                // En caso de que el rol_id no coincida con ninguno de los casos anteriores
                return response()->json(['error' => 'Invalid role'], 401);
        }

        $tokenResult = $user->createToken('Personal Access Token', $scopes);
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'rol_id' => $rol_id,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    } else {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

}