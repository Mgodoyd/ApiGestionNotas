<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Apicontroller;
use App\Models\Notes;
use Illuminate\Http\Request;

class NotesController extends Apicontroller
{
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
