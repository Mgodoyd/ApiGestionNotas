<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Apicontroller;
use App\Models\Notes;
use Illuminate\Http\Request;
use App\Transformers\NotesTransformer;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;


class NotesController extends Apicontroller
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('transform.input:' . NotesTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:manage-notes') //sirve para que solo los usuarios con el scope de manage-notes puedan acceder a las rutas
            ->only(['store', 'update', 'destroy']);
        $this->middleware('can:view,notes')->only('show'); //sirve para que solo los usuarios con el scope de manage-notes puedan acceder a las rutas
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $notes = Notes::all();
         return $this->showAll($notes);
    }

 
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:notes,title|max:255',
            'content' => 'required',
            'states_id' => 'required',
            'user_id' => 'required',
        ]);

        $nota = Notes::create($request->all());
        return $this->showOne($nota, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $nota = Notes::findOrFail($id);
        return $this->showOne($nota, 200);
    }

  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notes $notes)
    {
        $notes->fill($request->all());
        if (!$notes->isDirty()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }
        $notes->save();
        return $this->showOne($notes, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notes = Notes::findOrFail($id);
        $notes->delete();
    
        return $this->showOne($notes, 200);
    }
}
