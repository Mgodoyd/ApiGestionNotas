<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\ApiController;
use App\Models\Notes;
use Illuminate\Http\Request;

class ReaderController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
}
