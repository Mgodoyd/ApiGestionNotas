<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Apicontroller;
use App\Http\Middleware\checkscopes;
use App\Models\Notes;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;
use Illuminate\Auth\Access\AuthorizationException;


class NotesController extends Apicontroller
{

 
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
        $this->middleware('auth:api')->except(['index', 'show']);
       // $this->middleware('transform.input:' . NotesTransformer::class)->only(['store', 'update']);
      //  $this->middleware('scope:update-notes')->only(['update']);
       // $this->middleware('scope:manage-rol-state')->only(['store', 'update', 'destroy']);
       // $this->middleware('scope:manage-account')->only(['store', 'update', 'destroy']);
     //   $this->middleware('scope:manage-notes')->only(['store', 'update', 'destroy']);
      //  $this->middleware('check.scopes')->except(['index', 'show']); 
      $this->middleware('scope:update')->only(['update']);
        $this->middleware('scope:store')->only(['store']);
        $this->middleware('scope:destroy')->only(['destroy']);


    }
   


    // ...

  

    // ...


     
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
            'title' => 'required|unique:notes,title',
            'content' => 'required|max:255',
            'user_id' => 'required',
        ]);

       // $owner = auth()->user();
      /*  $note = new Notes([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);
        $note->owner()->associate($owner);*/
        
       $notaExistente = Notes::where('title', $request->input('title'))->exists();
    
        if ($notaExistente) {
           return $this->errorResponse('Ya existe una nota con el mismo título', 400);
        }
        $campos = $request->all();
        
        //$campos['users_id'] = auth()->user()->id;
        

        $campos['states_id'] = 1;
        $nota = Notes::create($campos);
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
    public function update(Request $request,string $id)
    {
        $notes = Notes::where('id', $id)->first();
       /* if (!$notes) {
            dd('Registro no encontrado');
        }*/
        
        $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'states_id' => 'integer|exists:states,id',
        ]);
      //  dd($request);
    $notes->fill($request->only([
        'title',
        'content',
        'states_id',
        'user_id',
    ]));
    
    if (!$notes->isDirty()) {
        return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
    }

    if (!$notes->save()) {
        return $this->errorResponse('Error al actualizar la nota', 500);
    }

    // Si el estado proporcionado es diferente del estado actual, actualizar el estado
    if ($request->has('states_id') && $request->input('states_id') !== $notes->states_id) {
        $notaEstado = new States([
            'id' => $notes->id,
            'states_id' => $request->input('states_id')
        ]);

        $notaEstado->save();
    }

    return $this->showOne($notes);

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
