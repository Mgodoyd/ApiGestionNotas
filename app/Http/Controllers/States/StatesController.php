<?php

namespace App\Http\Controllers\States;

use App\Http\Controllers\ApiController;
use App\Models\States;
use Illuminate\Http\Request;

class StatesController extends ApiController
{
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
