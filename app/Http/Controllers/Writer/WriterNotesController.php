<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Apicontroller;
use App\Http\Controllers\Controller;
use App\Models\Notes;
use Illuminate\Http\Request;
use App\Transformers\WriterTransformer;

class WriterNotesController extends Apicontroller
{
    public function __construct(){

        $this->middleware('client.credentials')->only(['index','show']);  //sirve para que solo el cliente pueda ver las notas
        $this->middleware('auth:api')->except(['index','show']); //sirve para que solo el cliente pueda ver las notas
        $this->middleware('transform.input' . WriterTransformer::class)->only(['update']);
        $this->middleware('scope:update-notes')->except(['index','show']); //sirve para que solo el cliente pueda ver las notas
        $this->middleware('can:update,notes')->only('update'); //sirve para que solo el cliente pueda ver las notas
        $this->middleware('can:view,notes')->only('index','show');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notas = Notes::all();
        return $this->showAll($notas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show(string $title)
    
    {
            $nota = Notes::where('title', $title)->firstOrFail();
            return $this->showOne($nota, 200);
   }
    

 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
        
        }
}
