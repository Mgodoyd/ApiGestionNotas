<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class Apicontroller extends Controller
{
    use ApiResponse;

    public function __construct() //este constructor se le pasa el middleware para que solo se pueda acceder a los metodos de esta clase si se esta autenticado
    {
        $this->middleware('auth:api');
    }
}
