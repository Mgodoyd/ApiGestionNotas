<?php

namespace App\Models;

use App\Transformers\AuthorTransformer;

class Author extends User
{
    public $transformer = AuthorTransformer::class; //transformador de la clase
    public function Notes(){
        return $this->hasMany(Notes::class);   // 1 a muchos
    }
}
