<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class Apicontroller extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api');
    }
}
