<?php

namespace App\Models;

use App\Transformers\OwnerTransformer;

class owner extends User
{
    
    public $transformer = OwnerTransformer::class; //transformador de la clase
    public function notes()
    {
        return $this->morphMany(Note::class, 'owner');// 1 a muchos
    }
}
