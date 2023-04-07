<?php

namespace App\Http\Controllers\Writer;

use App\Http\Controllers\ApiController;
use App\Models\Notes;
use Illuminate\Http\Request;

class WriterController extends ApiController
{

  
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {// Obtener el usuario autenticado
   // $user = auth()->user();         //tengo que modificarlo asi
    
   $notas = Notes::all();
   return $this->showAll($notas);
    
}
    /**
     * Display the specified resource.
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
