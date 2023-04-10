<?php

namespace App\Models;

use App\Transformers\WriterTransformer;

class writer extends User
{

    public $transformer = WriterTransformer::class; //transformador de la clase
    public function Notes(){
        return $this->hasMany(Notes::class);   // 1 a muchos
    }
}
