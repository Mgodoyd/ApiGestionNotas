<?php

namespace App\Models;

use App\Transformers\ReaderTransformer;

class reader extends User
{ 
    public $transformer = ReaderTransformer::class; //se le pasa el transformer de reader
    public function Notes(){
        return $this->hasMany(Notes::class);   // 1 a muchos
    }
}
