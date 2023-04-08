<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\OwnerTransformer;

class owner extends User
{
    
    public $transformer = OwnerTransformer::class;
    public function notes()
    {
        return $this->morphMany(Note::class, 'owner');// 1 a muchos
    }
}
