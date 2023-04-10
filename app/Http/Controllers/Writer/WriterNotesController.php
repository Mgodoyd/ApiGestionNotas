<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\Apicontroller;
use App\Models\Notes;
use Illuminate\Http\Request;

class WriterNotesController extends Apicontroller
{
   public function __construct(){ //constructor de la clase y se le pasa el middleware para que solo se pueda acceder a los metodos de esta clase si se esta autenticado

        $this->middleware('client.credentials')->only(['index','show']);  //sirve para que solo el cliente pueda ver las notas
        $this->middleware('auth:api')->except(['index','show']); //sirve para que solo el cliente pueda ver las notas
       // $this->middleware('transform.input' . WriterTransformer::class)->only(['update']);
        $this->middleware('scope:update')->only(['update']);
    }
    public function index() //metodo para mostrar todas las notas
    {
        $notas = Notes::all();
        return $this->showAll($notas);
    }
    public function show(string $title) //metodo para mostrar una nota
    {
            $nota = Notes::where('title', $title)->firstOrFail();
            return $this->showOne($nota, 200);
    }
    public function update(Request $request, string $title) //metodo para actualizar una nota
        {
            $nota = Notes::where('title', $title)->first();
            
            if (!$nota) {
                return $this->errorResponse('La nota no existe', 404);
            }
        
            if($request->has('title')){
                $nota->title = $request->title;
            }
        
            if($request->has('content')){
                $nota->content = $request->content;
            }

            if($request->has('states_id')){
                $nota->state_id = $request->state_id;
            }
           
           if ($nota->isDirty()) {
             var_dump($nota->isClean());
                $nota->save();
                return $this->showOne($nota, 200);
            } else {
                return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
          }
        
     }
}
