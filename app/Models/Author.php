<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\AuthorTransformer;

class Author extends User
{
    public $transformer = AuthorTransformer::class;
    public function Notes(){
        return $this->hasMany(Notes::class);   // 1 a muchos
    }
}
