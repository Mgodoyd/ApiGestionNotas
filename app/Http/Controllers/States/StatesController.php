<?php

namespace App\Http\Controllers\States;

use App\Http\Controllers\ApiController;
use App\Models\States;
use Illuminate\Http\Request;

class StatesController extends ApiController
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
        $statess = States::all();
        return $this->showAll($statess);
    }

   
    public function show(string $id)
    {
        $statess = States::findOrFail($id);
        return $this->showOne($statess, 200);
    }

}
