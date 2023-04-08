<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Apicontroller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Notes;
use App\Models\States;
use Illuminate\Http\Request;

class NotesStatesController extends Apicontroller
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
    }

    public function index($id)
    {
        $state = States::find($id);
        if (!$state) {
            return $this->errorResponse('El estado no existe', 404);
        }
        $notes = $state->notes;
        return $this->showAll($notes);
    }
}
