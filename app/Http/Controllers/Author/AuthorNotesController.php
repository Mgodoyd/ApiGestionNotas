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

    public function __construct() //constructor de la clase y se le pasa el middleware para que solo se pueda acceder a los metodos de esta clase si se esta autenticado
    {
        $this->middleware('client.credentials')->only(['index']);
        $this->middleware('auth:api')->except(['index']);
       // $this->middleware('transform.input' . AuthorTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:update')->only(['update']);
        $this->middleware('scope:store')->only(['store']);
        $this->middleware('scope:destroy')->only(['destroy']);
    } 
    public function index()  //metodo para mostrar todas las notas
        {
           $notas = Notes::all();
           var_dump($notas);
            return $this->showAll($notas);
        }
    public function store(Request $request) //metodo para crear una nota
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
       $notaExistente = Notes::where('title', $request->input('title'))->exists();
    
        if ($notaExistente) {
           return $this->errorResponse('Ya existe una nota con el mismo título', 400);
        }
        $campos = $request->all();
        $campos['states_id'] = 1;
        $nota = Notes::create($campos);
        return $this->showOne($nota, 201);
    }
    public function update(Request $request,Notes $notes) //metodo para actualizar una nota
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
    public function destroy(string $id) //metodo para eliminar una nota
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
