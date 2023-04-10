<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Apicontroller;
use App\Http\Controllers\Controller;
use App\Models\Notes;
use Illuminate\Http\Request;

class ReaderNotesController extends Apicontroller
{
    public function __construct() //constructor de la clase y se le pasa el middleware para que solo se pueda acceder a los metodos de esta clase si se esta autenticado
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
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
}
