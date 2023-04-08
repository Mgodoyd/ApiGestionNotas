<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\WriterTransformer;

class writer extends User
{

    public $transformer = WriterTransformer::class;
    public function Notes(){
        return $this->hasMany(Notes::class);   // 1 a muchos
    }
}
