<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\ApiController;
use App\Models\Notes;
use Illuminate\Http\Request;

class AuthorController extends ApiController
{

  /*  private function errorResponse($message, $code) {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }*/
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
   
    }

  

    /**
     * Store a newly created resource in storage.
     */
    /*public function store(Request $request)
    {
       $request->validate([
            'title' => 'required|unique:notes,title|max:255',
            'content' => 'required'
        ]);

        $campos = $request->all();

       /* $notaExistente = Notes::where('title', $request->input('title'))->exists();
    
        if ($notaExistente) {
            return $this->errorResponse('Ya existe una nota con el mismo título', 400);
        }
    */
      /*  $nota = Notes::create($campos);
        return $this->showOne($nota, 201);
    }

    /**
     * Display the specified resource.
     */
/*    public function show(string $title)
    {
        $nota = Notes::where('title', $title)->firstOrFail();
        return $this->showOne($nota, 200);
    }

    /**
     * Update the specified resource in storage.
     */
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

            if($request->has('user_id')){
                $nota->user_id = $request->user_id;
            }
           
           if ($nota->isDirty()) {
                $nota->save();
                return $this->showOne($nota, 200); 
            } else {
                return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
            }
        
    }

    /**
     * Remove the specified resource from storage.
     */
   /* public function destroy(string $id)
    {
         $nota = Notes::findOrFail($id);
        $nota->delete();
        return response()->json(['Nota eliminida' => $nota], 200);
    }*/
}
