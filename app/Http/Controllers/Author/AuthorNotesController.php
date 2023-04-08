<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Apicontroller;
use App\Http\Controllers\Controller;
use App\Models\Notes;
use App\Models\States;
use Illuminate\Http\Request;
use App\Transformers\AuthorTransformer;

class AuthorNotesController extends Apicontroller
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('auth:api')->except(['index']);
        $this->middleware('transform.input' . AuthorTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:manage-notes');
        $this->middleware('can:view,notes')->only('show');
        $this->middleware('can:update,notes')->only('update');
        $this->middleware('can:delete,notes')->only('destroy');
    } 
    /**
     * Display a listing of the resource.
     */
    public function index(/**owner $owner*/)
        {
           $notas = Notes::all();
            return $this->showAll($notas);
          /*  $notas = $owner->notes;
            return $this->showAll($notas);*/
        }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Notes $notes)
    {

    
    $this->validate($request, [
        'title' => 'string|max:255',
        'content' => 'string',
        'states_id' => 'integer|exists:states,id',
    ]);

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
/* public function update(Request $request, string $id)
        {
            $nota = Notes::find($id);

            if (!$nota) {
                return $this->errorResponse('La nota no existe', 404);
            }
        
            if($request->has('title')){
                $nota->title = $request->title;
            }
        
            if($request->has('content')){
                $nota->content = $request->content;
            }

            if($request->has('state_id')){
                $nota->state_id = $request->state_id;
            }
           
           if ($nota->isDirty()) {
                $nota->save();
                return $this->showOne($nota, 200);
            } else {
                return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
            }
        
        }*/
    
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $notes = Notes::find($id);
        if (!$notes) {
            return $this->errorResponse('La nota no existe', 404);
        }
        $notes->delete();
        if($notes->delete()){
            return $this->errorResponse('Error al eliminar la nota', 500);
        }
        return $this->showOne($notes);
    }
}
