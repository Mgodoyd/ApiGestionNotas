<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Apicontroller;
use App\Http\Controllers\Controller;
use App\Models\Notes;
use Illuminate\Http\Request;

class ReaderNotesController extends Apicontroller
{
   /* public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
         $this->middleware('scope:read-notes')->except(['index']);
         $this->middleware('can:view,notes')->only('index', 'show');
    }*/
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
