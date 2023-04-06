<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Notes;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notas = Notes::all();
        return response()->json(['Notas' => $notas], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $title)
    {
    $nota = Notes::where('title', $title)->firstOrFail();
    return response()->json(['Nota' => $nota], 200);
    }
}
